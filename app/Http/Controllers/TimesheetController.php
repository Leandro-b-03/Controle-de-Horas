<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Lang;
use Calendar;
use App\Task;
use App\Timesheet;
use Carbon\Carbon;
use App\Http\Requests;
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
        // Get all the timesheets
        $timesheet_today = Timesheet::where('user_id', Auth::user()->id)->orderBy('workday', 'desc')->get()->first();
        if ($timesheet_today) {
            $timesheet_today->workday = Carbon::createFromFormat('Y-m-d H', $timesheet_today->workday . '00');
        }
        
        $data['timesheet_today'] = $timesheet_today;

        setlocale(LC_TIME, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br');

        // Get the first day
        $today = new Carbon();
        $data['today'] = $today;

        if($timesheet_today){
            if($timesheet_today->lunch_start != null) {
                $lhs = explode(':', $timesheet_today->lunch_start);
                $lunch_start = Carbon::createFromTime($lhs[0], $lhs[1], $lhs[2], 'America/Sao_Paulo');
                            
                $lhe = explode(':', $timesheet_today->lunch_end);
                $lunch_end = Carbon::createFromTime($lhe[0], $lhe[1], $lhe[2], 'America/Sao_Paulo');
            }
        }

        $week = [];

        for ($days = 6; $days >= 0; $days--) {
            $day = new Carbon();

            switch ($today->dayOfWeek) {
                case Carbon::SUNDAY:
                    $day->subDay($today->dayOfWeek - $days);
                    break;
                case Carbon::MONDAY:
                    if ($today->dayOfWeek <= $days)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 2);
                    break;
                case Carbon::TUESDAY:
                    if ($today->dayOfWeek <= $days)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 3);
                    break;
                case Carbon::WEDNESDAY:
                    if ($today->dayOfWeek <= $days)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 4);
                    break;
                case Carbon::THURSDAY:
                    if ($today->dayOfWeek <= $days)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 5);
                    break;
                case Carbon::FRIDAY:
                    if ($today->dayOfWeek <= $days)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 6);
                    break;
                case Carbon::SATURDAY:
                    if ($today->dayOfWeek <= $days)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 7);
                    break;
            }

            $workday = Timesheet::findWorkday($day->toDateString())->get()->first();

            if ($workday){
                if ($workday->lunch_start != '00:00:00') {
                    if ($workday->lunch_end != '00:00:00') {
                        $lunch = '<p>' . $workday->lunch_hours . '</p>';
                    } else {
                        $lunch = '<a id="lunch_end" class="btn btn-primary" ><span class="fa fa-cutlery"></span> ' . Lang::get('timesheets.end') . '</a>';
                    }
                } else {
                    $lunch = '<a id="lunch_start" class="btn btn-primary" ><span class="fa fa-cutlery"></span> ' . Lang::get('timesheets.start') . '</a>';
                }
            } else {
                $lunch = '---';
            }
            
            $day_info = array('day' => $day, 'workday' => $workday, 'lunch' => $lunch);
            $week[] = $day_info;
        }

        sort($week);

        $data['week'] = $week;

        // Get all tasks
        // $tasks = Task::where('teams', 'like', Auth::user()->teams)->get();

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
        $data = Carbon::now();

        // die($inputs['start'] === 'false');

        if (isset($inputs['start'])) {
            $data = array(
                'user_id' => Auth::user()->id,
                'workday' => $data->toDateString(),
                'hours' => 0,
                'start' => $data->toTimeString()
                // 'end' => ,
                // 'status' => 
            );

            $timesheet = Timesheet::create($data);

            if ($timesheet) {
                DB::commit();
                return response()->json($timesheet);
            }
        } else if (isset($inputs['lunch_start'])) {
            $timesheet = Timesheet::find($inputs['id']);

            $timesheet->lunch_start = $data->toTimeString();

            if ($timesheet->save()) {
                DB::commit();
                return response()->json($timesheet);
            }
        } else if (isset($inputs['lunch_end'])) {
            $timesheet = Timesheet::find($inputs['id']);

            $timesheet->lunch_end = $data->toTimeString();

            $lhs = explode(':', $timesheet->lunch_start);
            $lunch_start = Carbon::createFromTime($lhs[0], $lhs[1], $lhs[2], 'America/Sao_Paulo');
                        
            $lhe = explode(':', $timesheet->lunch_end);
            $lunch_end = Carbon::createFromTime($lhe[0], $lhe[1], $lhe[2], 'America/Sao_Paulo');

            $total_time = $lunch_start->diffInHours($lunch_end);

            if($total_time > 1.0) {
                $timesheet->lunch_hours = $total_time;

                if ($timesheet->save()) {
                    DB::commit();
                    return response()->json($timesheet);
                }
            } else {
                return response()->json(['error' => 'true', 'message' => Lang::get('timesheets.error-lunch')]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
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
