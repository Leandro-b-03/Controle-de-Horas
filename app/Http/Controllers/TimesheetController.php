<?php

namespace App\Http\Controllers;

setlocale(LC_TIME, "Portuguese");
setlocale(LC_TIME, "Brazil");
setlocale(LC_TIME, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br', 'portuguese');

use Illuminate\Http\Request;

use DB;
use Log;
use Auth;
use Lang;
use Calendar;
use App\User;
use App\Task;
use App\Member;
use App\Journal;
use App\Holiday;
use App\Project;
use App\UseCase;
use App\Overtime;
use App\TaskTeam;
use App\UserTeam;
use App\Timesheet;
use Carbon\Carbon;
use App\TimeEntry;
use App\TaskJournal;
use App\CustomField;
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
                    'hours' => '00:00:00',
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
            Log::error($e);
            Log::error($workday);

            $data['error'] =  Lang::get('general.error-day');
        }

        $data['workday'] = $workday;

        // Get the actual task
        $timesheet_task = TimesheetTask::where('timesheet_id', $workday->id)->where('end', '00:00:00')->get()->first();
        $data['timesheet_task'] = $timesheet_task;

        // Get the Openproject's user id
        $user_id = UserOpenProject::where('login', 'LIKE', Auth::user()->getEloquent()->username . '@%')->orWhere('mail', 'LIKE', Auth::user()->getEloquent()->username . '@%')->get()->first()->id;

        // Get all the Projects that the user is assigned off
        $user_projects = Member::select('project_id')->where('user_id', $user_id)->get()->toArray();

        // Get all the projects infos
        $projects = Project::whereIn('status', [1, 7])->whereIn('id', $user_projects)->get();
        $data['projects'] = $projects;

        // Get all the tasks do today;
        $tasks = TimesheetTask::where('timesheet_id', $workday->id)->orderBy('id', 'DESC')->paginate(20);
        $data['tasks'] = $tasks;

        // Get the info if the day is off
        $info = GeneralController::getInfo($workday);
        $data['info'] = $info;

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

                    $user_open_project = UserOpenProject::where('login', 'LIKE', Auth::user()->getEloquent()->username . '@%')->orWhere('mail', 'LIKE', Auth::user()->getEloquent()->username . '@%')->get()->first();

                    if ($work_package->type_id == 1)
                        $work_package->status_id = 10;
                    else {
                        $custom_fields = CustomField::where('customized_id', $work_package->id)->whereIn('custom_field_id', [38, 39, 40])->get();

                        if (!$custom_fields) {
                            $custom_fields = array(
                                array (
                                    'customized_type' => 'WorkPackage',
                                    'customized_id' => $work_package->id,
                                    'custom_field_id' => 38,
                                    'value' => $user_open_project->lastname . ' ' . $user_open_project->lastname
                                ),
                                array (
                                    'customized_type' => 'WorkPackage',
                                    'customized_id' => $work_package->id,
                                    'custom_field_id' => 40,
                                    'value' => '{
                                                  "working": "' . $user_open_project->id . '",
                                                  "worked": ""
                                                }'
                                )
                            );

                            $custom_fields = CustomField::create( $custom_fields );

                            if ($custom_fields) {
                                DB::commit();
                            } else {
                                DB::rollback();
                                Log::error($e);
                                Log::error($work_package);
                                Log::error($timesheet_task);

                                return response()->json(array('error' => Lang::get('general.error')));
                            }
                        } else {
                            foreach ($custom_fields as $custom_field) {
                                if ($custom_field->custom_field_id == 38) {
                                    $custom_field->value = $custom_field->value . ', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname;
                                } else if ($custom_field->custom_field_id == 39) {
                                    $custom_field->value = str_replace($user_open_project->lastname . ' ' . $user_open_project->lastname, '', str_replace(', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname, '', ($custom_field->value)));
                                } else if ($custom_field->custom_field_id == 40) {
                                    $working_worked = json_decode($custom_field->value);

                                    $key = array_search($custom_field->id, $working_worked['worked']);
                                    unset($working_worked['worked'][$key]);

                                    $working_worked['working'][] = $custom_field->id;

                                    $custom_field->values = json_encode($working_worked);
                                }

                                if ($custom_field->save()) {
                                    DB::commit();
                                } else {
                                    DB::rollback();
                                    Log::error($e);
                                    Log::error($custom_field);
                                    Log::error($work_package);
                                    Log::error($timesheet_task);

                                    return response()->json(array('error' => Lang::get('general.error')));
                                }
                            }
                        }
                    }

                    if ($work_package->save()) {
                        DB::commit();
                        $this->journal($inputs['task_id'], 'WorkPackage', 'work_packages');

                        $this->notify($inputs, $timesheet_task->project_id);
                        
                        return response()->json($this->line($timesheet_task, $work_package->type_id));
                    } else {
                        DB::rollback();
                        Log::error($e);
                        Log::error($work_package);
                        Log::error($timesheet_task);

                        return response()->json(array('error' => Lang::get('general.error')));
                    }
                } else {
                    DB::rollback();
                    Log::error($e);
                    Log::error($work_package);
                    Log::error($timesheet_task);

                    return response()->json(array('error' => Lang::get('general.error')));
                }
            } else if (isset($inputs['finish']) || isset($inputs['pause']) || isset($inputs['fail'])) {
                $timesheet_task = TimesheetTask::where('timesheet_id', $workday->id)->where('end', '00:00:00')->get()->first();

                $today = Carbon::now();
                $timesheet_task->end = $today->toTimeString();

                $seconds = '00';

                $start = new Carbon($timesheet_task->start);

                $diffTime = $start->diffInMinutes(new Carbon($timesheet_task->end));

                $hours = floor($diffTime / 60);
                $minutes = ($diffTime % 60);
                $tminutes = (float)($minutes / 60);
                $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . $minutes) . ":" . $seconds;

                $user_open_project = UserOpenProject::where('login', 'LIKE', Auth::user()->getEloquent()->username . '@%')->orWhere('mail', 'LIKE', Auth::user()->getEloquent()->username . '@%')->get()->first();

                $work_package = Task::find($timesheet_task->work_package_id);

                $time_entry = array(
                    'project_id' => $timesheet_task->project_id,
                    'user_id' => $user_open_project->id,
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
                    Log::error($e);
                    Log::error($time_entry);
                    Log::error($work_package);
                    Log::error($timesheet_task);

                    return response()->json(array('error' => Lang::get('general.error')));
                }

                $timesheet_task->hours = $time;

                if ($timesheet_task->save()) {
                    DB::commit();

                    if ($work_package->type_id == 1) {
                        $status = 11;

                        if (isset($inputs['pause']))
                            $status = 14;

                        if (isset($inputs['fail']))
                            $status = 12;

                        $work_package->status_id = $status;
                    } else {
                        $custom_fields = CustomField::where('customized_id', $work_package->id)->where('custom_field_id', 39)->get();

                        if (!$custom_fields) {
                            $custom_fields = array(
                                array (
                                    'customized_type' => 'WorkPackage',
                                    'customized_id' => $work_package->id,
                                    'custom_field_id' => 39,
                                    'value' => $user_open_project->lastname . ' ' . $user_open_project->lastname
                                )
                            );

                            $custom_fields = CustomField::create( $custom_fields );

                            if ($custom_fields) {
                                DB::commit();
                            } else {
                                DB::rollback();
                                Log::error($e);
                                Log::error($custom_field);
                                Log::error($work_package);
                                Log::error($timesheet_task);

                                return response()->json(array('error' => Lang::get('general.error')));
                            }

                            $custom_fields = CustomField::where('customized_id', $work_package->id)->whereIn('custom_field_id', [38, 40])->get();

                            if ($custom_field->custom_field_id == 38) {
                                $custom_field->value = str_replace($user_open_project->lastname . ' ' . $user_open_project->lastname, '', str_replace(', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname, '', ($custom_field->value)));
                            } else if ($custom_field->custom_field_id == 40) {
                                $working_worked = json_decode($custom_field->value);

                                $key = array_search($custom_field->id, $working_worked['worked']);
                                unset($working_worked['working'][$key]);

                                $working_worked['worked'][] = $custom_field->id;

                                $custom_field->values = json_encode($working_worked);
                            }

                            if ($custom_field->save()) {
                                DB::commit();
                            } else {
                                DB::rollback();
                                Log::error($e);
                                Log::error($custom_field);
                                Log::error($work_package);
                                Log::error($timesheet_task);

                                return response()->json(array('error' => Lang::get('general.error')));
                            }
                        } else {
                            $custom_fields = CustomField::where('customized_id', $work_package->id)->whereIn('custom_field_id', [38, 39, 40])->get();

                            foreach ($custom_fields as $custom_field) {
                                if ($custom_field->custom_field_id == 38) {
                                    $custom_field->value = str_replace($user_open_project->lastname . ' ' . $user_open_project->lastname, '', str_replace(', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname, '', ($custom_field->value)));
                                } else if ($custom_field->custom_field_id == 39) {
                                    $custom_field->value = $custom_field->value . ', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname;
                                } else if ($custom_field->custom_field_id == 40) {
                                    $working_worked = json_decode($custom_field->value);

                                    $key = array_search($custom_field->id, $working_worked['worked']);
                                    unset($working_worked['working'][$key]);

                                    $working_worked['worked'][] = $custom_field->id;

                                    $custom_field->values = json_encode($working_worked);
                                }

                                if ($custom_field->save()) {
                                    DB::commit();
                                } else {
                                    DB::rollback();
                                    Log::error($e);
                                    Log::error($custom_field);
                                    Log::error($work_package);
                                    Log::error($timesheet_task);

                                    return response()->json(array('error' => Lang::get('general.error')));
                                }
                            }
                        }

                        $use_cases = array(
                            'timesheet_task_id' => $timesheet_task->id,
                            'ok' => $inputs['ok'],
                            'nok' => $inputs['nok'],
                            'impacted' => $inputs['impacted'],
                            'cancelled' => $inputs['cancelled']
                        );

                        $use_cases = UseCase::create ($use_cases);

                        if ($use_cases) {
                            DB::commit();
                        } else {
                            DB::rollback();
                            Log::error($e);
                            Log::error($use_cases);
                            Log::error($work_package);
                            Log::error($timesheet_task);

                            return response()->json(array('error' => Lang::get('general.error')));
                        }
                    }

                    if ($work_package->save()) {
                        DB::commit();
                        $this->journal($timesheet_task->work_package_id, 'WorkPackage', 'work_packages');

                        $this->notify($inputs, $timesheet_task->project_id);

                        return response()->json($this->line($timesheet_task, $work_package->type_id));
                    } else {
                        DB::rollback();
                        Log::error($e);
                        Log::error($work_package);
                        Log::error($timesheet_task);

                        return response()->json(array('error' => Lang::get('general.error')));
                    }
                } else {
                    DB::rollback();
                    Log::error($e);
                    Log::error($work_package);
                    Log::error($timesheet_task);

                    return response()->json(array('error' => Lang::get('general.error')));
                }
            } else if (isset($inputs['lunch'])) {
                if ($inputs['start_lunch']) {
                    if ($workday->lunch_start == '00:00:00') {
                        $workday->lunch_start = $today->toTimeString();

                        if ($workday->save()) {
                            DB::commit();
                            return response()->json($this->lunch($workday));
                        } else {
                            DB::rollback();
                            Log::error($e);
                            Log::error($work_package);
                            Log::error($timesheet_task);

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
                            Log::error($e);
                            Log::error($work_package);
                            Log::error($timesheet_task);

                            return response()->json(array('error' => Lang::get('general.error')));
                        }
                    }
                }
            } else if (isset($inputs['end'])) {
                $workday->end = $today->toTimeString();

                $start = new Carbon($workday->start);

                $lunch_in_minute = 0;
                list($hour, $minute) = explode(':', $workday->lunch_hours);
                $lunch_in_minute += $hour * 60;
                $lunch_in_minute += $minute;

                $diffTime = $start->diffInMinutes(new Carbon($workday->end));

                $diffTime -= $lunch_in_minute;

                $seconds = '00';

                $hours = floor($diffTime / 60);
                $minutes = ($diffTime % 60);
                $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;
                
                $workday->hours = $time;

                $workday->status = "P";

                if ($workday->save()) {
                    DB::commit();
                    return response()->json($this->lunch($workday));
                } else {
                    DB::rollback();
                    Log::error($e);
                    Log::error($work_package);
                    Log::error($timesheet_task);

                    return response()->json(array('error' => Lang::get('general.error')));
                }
            } else if (isset($inputs['nightly'])) {
                if (isset($inputs['nightly_start'])) {
                    $workday->nightly_start = $today->toTimeString();

                    if ($workday->save()) {
                        DB::commit();
                        return response()->json($this->lunch($workday));
                    } else {
                        DB::rollback();
                        Log::error($e);
                        Log::error($work_package);
                        Log::error($timesheet_task);

                        return response()->json(array('error' => Lang::get('general.error')));
                    }
                } else if (isset($inputs['nightly_end'])) {
                    $workday->nightly_end = $today->toTimeString();

                    $start = new Carbon($workday->nightly_start);

                    $diffTime = $start->diffInMinutes(new Carbon($workday->nightly_end));

                    $seconds = '00';

                    $hours = floor($diffTime / 60);
                    $minutes = ($diffTime % 60);
                    $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

                    $workday->nightly_hours = $time;

                    if ($workday->save()) {
                        DB::commit();
                        return response()->json($this->lunch($workday));
                    } else {
                        DB::rollback();
                        Log::error($e);
                        Log::error($work_package);
                        Log::error($timesheet_task);

                        return response()->json(array('error' => Lang::get('general.error')));
                    }
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            Log::error($work_package);
            Log::error($timesheet_task);

            return response()->json(array('error' => Lang::get('general.error')));
        }
    }

    /**
     * Make an array to pass as json for html
     *
     * @param array $timesheet
     * @param int $type
     */
    public function line($timesheet_task, $type)
    {
        $timesheet_task->project    = $timesheet_task->getProject()->getResults()->name;
        $timesheet_task->task       = $timesheet_task->getTask()->getResults()->subject;
        $timesheet_task->start      = date("G:i a", strtotime($timesheet_task->start));
        $timesheet_task->end        = ($timesheet_task->end) ? date("G:i a", strtotime($timesheet_task->end)) : '---';
        $timesheet_task->hours      = ($timesheet_task->hours) ? date('G:i', strtotime($timesheet_task->hours)) : '---';
        $timesheet_task->type_id    = $type;

        return $timesheet_task;
    }

    /**
     * Make an array to pass as json for html
     *
     * @param array $workday
     */
    public function lunch($workday)
    {
        $workday->lunch_start      = date("G:i a", strtotime($workday->lunch_start));
        $workday->lunch_end        = ($workday->lunch_end) ? date("G:i a", strtotime($workday->lunch_end)) : '---';
        $workday->lunch_hours      = ($workday->lunch_hours) ? date('G:i', strtotime($workday->lunch_hours)) : '---';

        return $workday;
    }


    /**
     * Make a notification for the task done
     *
     * @param array $inputs
     * @param int $project_id
     */
    public function notify($inputs, $project_id)
    {
        try {
            // Get the responsible for the project
            $project = Project::findOrFail($project_id);

            // Get the op user
            $user_open_project = UserOpenProject::find($project->responsible_id);

            // Get the user in the ts
            $user = User::where('email', $user_open_project->mail)->get()->first();

            Log::info($user_open_project);
            Log::info($user);

            if ($project->responsible_id && $user) {
                $message = '';

                if (isset($inputs['start'])) {
                    $message = Lang::get('timesheets.tasks-start', ['name' => Auth::user()->first_name . ' ' . Auth::user()->last_name]);
                } else {
                    if (isset($inputs['finish']) || isset($inputs['pause']) || isset($inputs['fail'])) {
                        if (!isset($inputs['ok'])) {
                            $message = Lang::get('timesheets.tasks-done_1', ['name' => Auth::user()->first_name . ' ' . Auth::user()->last_name]);
                        } else {
                            $message = Lang::get('timesheets.tasks-done_2', ['name' => Auth::user()->first_name . ' ' . Auth::user()->last_name, 'ok' => $inputs['ok'], 'nok' => $inputs['nok'], 'impacted' => $inputs['impacted'], 'cancelled' => $inputs['cancelled']]);
                        }
                    }
                }

                $notification = array(
                    'user_id' => $user->id,
                    'faicon'  => isset($inputs['start']) ? 'play-circle' : 'check-circle',
                    'message' => $message

                );

                GeneralController::createNotification($user->id, $notification);
            } else {
                $notification = array(
                    'user_id' => Auth::user()->id,
                    'faicon'  => 'error',
                    'message' => 'Erro ao enviar a notificação'

                );

                GeneralController::createNotification(Auth::user()->id, $notification);
            }
        } catch (Exception $e) {
            $notification = array(
                'user_id' => Auth::user()->id,
                'faicon'  => 'error',
                'message' => 'Erro ao enviar a notificação'

            );

            GeneralController::createNotification(Auth::user()->id, $notification);
        }
    }

    public function journal($task_id, $type, $activity_type)
    {
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
                            Log::error($e);
                            Log::error($work_package);
                            Log::error($timesheet_task);

                            return response()->json(array('error' => Lang::get('general.error')));
                        }
                    } else {
                        DB::rollback();
                        Log::error($e);
                        Log::error($work_package);
                        Log::error($timesheet_task);

                        return response()->json(array('error' => Lang::get('general.error')));
                    }
                } else {
                    DB::rollback();
                    Log::error($e);
                    Log::error($work_package);
                    Log::error($timesheet_task);

                    return response()->json(array('error' => Lang::get('general.error')));
                }*/
            } else {
                DB::rollback();
                Log::error($e);
                Log::error($work_package);
                Log::error($timesheet_task);

                return response()->json(array('error' => Lang::get('general.error')));
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            Log::error($work_package);
            Log::error($timesheet_task);

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

            // Get all holidays in the month
            $holidays = Holiday::where('month', (isset($inputs['month'])) ? $inputs['month'] : Carbon::now()->month)->get();
            $data['holidays'] = $holidays;

            // Get the overtime
            $overtime = Overtime::where('user_id', Auth::user()->id)->get()->first();
            $data['overtime'] = $overtime;

            // Get the workdays in the month
            $month = Timesheet::where(DB::raw('MONTH(workday)'), (isset($inputs['month']) ? $inputs['month'] : Carbon::now()->month))
                ->where(DB::raw('YEAR(workday)'), (isset($inputs['year']) ? $inputs['year'] : Carbon::now()->year))->where('user_id', $id)->get();
            $data['month'] = $month;

            // Get total hour month
            $total_month_hours = GeneralController::getTotalMonthHours((isset($inputs['month']) ? $inputs['month'] : Carbon::now()->month), (isset($inputs['year']) ? $inputs['year'] : Carbon::now()->year), $month);
            $data['total_month_hours'] = $total_month_hours;

            // Set date and get month
            $month_name = ucwords(Carbon::create((isset($inputs['year']) ? $inputs['year'] : Carbon::now()->year), (isset($inputs['month']) ? $inputs['month'] : Carbon::now()->month), 1)->formatLocalized('%B %Y'));
            $data['$month_name'] = utf8_encode($month_name);

            $data['actual_month'] = (isset($inputs['month'])) ? $inputs['month'] : Carbon::now()->month;
            $data['year'] = (isset($inputs['year'])) ? $inputs['year'] : Carbon::now()->year;

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
                Log::error($e);
                Log::error($work_package);
                Log::error($timesheet_task);

                return redirect('timesheets')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
            }
        } catch (Exception $e) {
            DB::rollback();
            Log::error($e);
            Log::error($work_package);
            Log::error($timesheet_task);

            return redirect('timesheets')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
