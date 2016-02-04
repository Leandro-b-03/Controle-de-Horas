<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Lang;
use Calendar;
use App\Task;
use App\Journal;
use App\Holiday;
use App\Project;
use App\TaskTeam;
use App\UserTeam;
use App\Timesheet;
use Carbon\Carbon;
use App\TimeEntry;
use App\TaskJournal;
use App\TimesheetTask;
use App\Http\Requests;
use App\UserOpenProject;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class TimesheetController extends Controller
{
    private $controller_name = 'TimesheetController';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get the first day
        $today = new Carbon();
        $data['today'] = $today;

        // Get the workday
        $workday = Timesheet::where('user_id', Auth::user()->getEloquent()->id)->where('workday', $today->toDateString())->orderBy('workday', 'desc')->get()->first();

        try {
            DB::beginTransaction();

            if (!$workday) {
                $timesheet = array(
                    'user_id' => Auth::user()->getEloquent()->id,
                    'workday' => $today->toDateString(),
                    'hours' => 0,
                    'start' => $today->toTimeString()
                );

                $timesheet = Timesheet::create($timesheet);

                if ($timesheet) {
                    DB::commit();
                    $workday = $timesheet;
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            $data['error'] =  Lang::get('general.error-day');
        }
        $data['workday'] = $workday;

        $timesheet_task = TimesheetTask::where('timesheet_id', $workday->id)->where('end', null)->get()->first();
        $data['timesheet_task'] = $timesheet_task;

        $projects = Project::whereIn('status', [1, 7])->get();
        $data['projects'] = $projects;

        // Get all the tasks do today;
        $tasks = TimesheetTask::where('timesheet_id', $workday->id)->orderBy('id', 'DESC')->get();
        $data['tasks'] = $tasks;

        // Return the timesheets view.
        return view('timesheet.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Empty because theres no page
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $inputs = $request->all();

        // Get the actual date
        $today = Carbon::now();

        // Get the timesheet of today
        $workday = Timesheet::where('user_id', Auth::user()->getEloquent()->id)->where('workday', $today->toDateString())->orderBy('workday', 'desc')->get()->first();

        try {
            if (isset($inputs['start'])) {
                $task = array(
                    'timesheet_id' => $workday->id,
                    'project_id' => $inputs['project_id'],
                    'work_package_id' => $inputs['task_id'],
                    'start' =>  $today->toTimeString()
                );

                $timesheet_task = TimesheetTask::create( $task );

                if ($timesheet_task) {
                    DB::commit();

                    $work_package = Task::find($inputs['task_id']);
                    $work_package->status_id = 10;

                    if ($work_package->save()) {
                        DB::commit();
                        $this->journal($inputs['task_id'], 'WorkPackage', 'work_packages');
                        
                        return response()->json($this->line($timesheet_task));
                    } else {
                        DB::rollback();
                        return response()->json(array('error' => Lang::get('general.error')));
                    }
                } else {
                    DB::rollback();
                    return response()->json(array('error' => Lang::get('general.error')));
                }
            } else if (isset($inputs['finish']) || isset($inputs['pause']) || isset($inputs['fail'])) {
                $timesheet_task = TimesheetTask::where('timesheet_id', $workday->id)->where('end', null)->get()->first();
                $timesheet_task->end = $today->toTimeString();

                $seconds = '00';

                $start = new Carbon($timesheet_task->start);

                $diffTime = $start->diffInMinutes(new Carbon($timesheet_task->end));

                $hours = floor($diffTime / 60);
                $minutes = ($diffTime % 60);
                $tminutes = (float)($minutes / 60);
                $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . $minutes) . ":" . $seconds;

                $time_entry = array(
                    'project_id' => $timesheet_task->project_id,
                    'user_id' => UserOpenProject::where('login', 'LIKE', Auth::user()->getEloquent()->username . '@%')->orWhere('mail', 'LIKE', Auth::user()->getEloquent()->username . '@%')->get()->first()->id,
                    'work_package_id' => $timesheet_task->work_package_id,
                    'hours' => (float)$hours + $tminutes,
                    'activity_id' => 1,
                    'spent_on' => $start->toDateString(),
                    'tyear' => $start->year,
                    'tmonth' => $start->month,
                    'tweek' => $start->weekOfYear,
                    'created_on' => Carbon::now(),
                    'update_on' => Carbon::now()
                );

                $time_entry = TimeEntry::create ($time_entry);

                if ($timesheet_task->save()) {
                    DB::commit();
                } else {
                    DB::rollback();
                    return response()->json(array('error' => Lang::get('general.error')));
                }

                $timesheet_task->hours = $time;

                if ($timesheet_task->save()) {
                    DB::commit();

                    $status = 11;

                    if (isset($inputs['pause']))
                        $status = 14;

                    if (isset($inputs['fail']))
                        $status = 12;

                    $work_package = Task::find($timesheet_task->work_package_id);
                    $work_package->status_id = $status;

                    if ($work_package->save()) {
                        DB::commit();
                        $this->journal($timesheet_task->work_package_id, 'WorkPackage', 'work_packages');
                        
                        return response()->json($this->line($timesheet_task));
                    } else {
                        DB::rollback();
                        return response()->json(array('error' => Lang::get('general.error')));
                    }
                } else {
                    DB::rollback();
                    return response()->json(array('error' => Lang::get('general.error')));
                }
            } else if ($inputs['lunch']) {
                if ($inputs['start_lunch']) {
                    if ($workday->lunch_start == '00:00:00') {
                        $workday->lunch_start = $today->toTimeString();

                        if ($workday->save()) {
                            DB::commit();
                            return response()->json($this->lunch($workday));
                        } else {
                            DB::rollback();
                            return response()->json(array('error' => Lang::get('general.error')));
                        }
                    }
                }
                
                if ($inputs['start_lunch'] == 'false') {
                    if ($workday->lunch_end == '00:00:00' && $workday->lunch_start != '00:00:00') {
                        $workday->lunch_end = $today->toTimeString();

                        $start = new Carbon($workday->lunch_start);

                        $diffTime = $start->diffInMinutes(new Carbon($workday->lunch_end));

                        $seconds = '00';

                        $hours = floor($diffTime / 60);
                        $minutes = ($diffTime % 60);
                        $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

                        $workday->lunch_hours = $time;

                        if ($workday->save()) {
                            DB::commit();
                            return response()->json($this->lunch($workday));
                        } else {
                            DB::rollback();
                            return response()->json(array('error' => Lang::get('general.error')));
                        }
                    }
                }
            } else if ($inputs['end'] == 'true') {
                $workday->end = $today->toTimeString();

                $start = new Carbon($workday->start);

                $diffTime = $start->diffInMinutes(new Carbon($workday->end));

                $seconds = '00';

                $hours = floor($diffTime / 60);
                $minutes = ($diffTime % 60);
                $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;
                
                $workday->hours = $time;

                if ($workday->save()) {
                    DB::commit();
                    return response()->json($this->lunch($workday));
                } else {
                    DB::rollback();
                    return response()->json(array('error' => Lang::get('general.error')));
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(array('error' => Lang::get('general.error')));
        }
    }

    public function line($timesheet_task) {
        $timesheet_task->project    = $timesheet_task->getProject()->getResults()->name;
        $timesheet_task->task       = $timesheet_task->getTask()->getResults()->subject;
        $timesheet_task->start      = date("G:i a", strtotime($timesheet_task->start));
        $timesheet_task->end        = ($timesheet_task->end) ? date("G:i a", strtotime($timesheet_task->end)) : '---';
        $timesheet_task->hours      = ($timesheet_task->hours) ? date('G:i', strtotime($timesheet_task->hours)) : '---';

        return $timesheet_task;
    }

    public function lunch($workday) {
        $workday->lunch_start      = date("G:i a", strtotime($workday->lunch_start));
        $workday->lunch_end        = ($workday->lunch_end) ? date("G:i a", strtotime($workday->lunch_end)) : '---';
        $workday->lunch_hours      = ($workday->lunch_hours) ? date('G:i', strtotime($workday->lunch_hours)) : '---';

        return $workday;
    }

    public function journal($task_id, $type, $activity_type) {
        $task = Task::find($task_id);

        $user_id = UserOpenProject::where('login', 'LIKE', Auth::user()->getEloquent()->username . '@%')->orWhere('mail', 'LIKE', Auth::user()->getEloquent()->username . '@%')->get()->first()->id;

        $task->assigned_to_id = $user_id;

        try {
            if ($task->save()) {
                DB::commit();
                /*$journal = array(
                    'journable_type'    => $type,
                    'user_id'           => $user_id,
                    'version'           => 1,
                    'activity_type'     => $activity_type
                );

                $journal = Journal::create($journal);

                if ($journal) {
                    $task_journal = $task;
                    $task_journal['journal_id'] = $journal->id;

                    $task_journal = TaskJournal::create($task_journal);

                    if ($task_journal) {
                        DB::commit();
                        $journal->journable_id = $task_journal->id;

                        if ($journal->save()) {
                            DB::commit();
                        } else {
                            DB::rollback();
                            return response()->json(array('error' => Lang::get('general.error')));
                        }
                    } else {
                        DB::rollback();
                        return response()->json(array('error' => Lang::get('general.error')));
                    }
                } else {
                    DB::rollback();
                    return response()->json(array('error' => Lang::get('general.error')));
                }*/
            } else {
                DB::rollback();
                return response()->json(array('error' => Lang::get('general.error')));
            }
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(array('error' => Lang::get('general.error')));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id, Request $request)
    {
        if ($id == Auth::user()->id) {
            // Get the workdays in the month
            $inputs = $request->all();

            // Get all holidays
            $holidays = Holiday::where('month', (isset($inputs['month'])) ? $inputs['month'] : Carbon::now()->month)->get();
            $data['holidays'] = $holidays;

            // Get the workdays in the month
            $month = Timesheet::where(DB::raw('MONTH(workday)'), (isset($inputs['month'])) ? $inputs['month'] : Carbon::now()->month)
                ->where(DB::raw('YEAR(workday)'), (isset($inputs['year'])) ? $inputs['year'] : Carbon::now()->year)->where('user_id', $id)->get();
            $data['month'] = $month;

            // Return the timesheets view.
            return view('timesheet.show')->with('data', $data);
        } else {
            return redirect('timesheets');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // Retrive the timesheet with param $id
        $timesheet = Timesheet::find($id);
        $data['timesheet'] = $timesheet;

        // Return the dashboard view.
        return view('timesheet.create')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        DB::beginTransaction();
        
        // Get all the input data received.
        $input = $request->all();

        $ids = explode(',', $input['id']);

        try {
            if (Timesheet::destroy($ids)) {
                DB::commit();
                return redirect('timesheets')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'delete'));
            } else {
                DB::rollback();
                return redirect('timesheets')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('timesheets')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
