<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Lang;
use Calendar;
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
        $timesheet_today->workday = Carbon::createFromFormat('Y-m-d H', $timesheet_today->workday . '00');
        $data['timesheet_today'] = $timesheet_today;

        setlocale(LC_TIME, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br');

        // Get the first day
        $today = new Carbon();
        $data['today'] = $today;

        $week = [];

        for ($days = 6; $days >= 0; $days--) {
            $day = new Carbon();

            switch ($today->dayOfWeek) {
                case Carbon::SUNDAY:
                    $day->subDay($today->dayOfWeek - $days);
                    break;
                case Carbon::MONDAY:
                    if ($today->dayOfWeek <= $day)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 2);
                    break;
                case Carbon::TUESDAY:
                    if ($today->dayOfWeek <= $day)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 3);
                    break;
                case Carbon::WEDNESDAY:
                    if ($today->dayOfWeek <= $day)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 4);
                    break;
                case Carbon::THURSDAY:
                    if ($today->dayOfWeek <= $day)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 5);
                    break;
                case Carbon::FRIDAY:
                    if ($today->dayOfWeek <= $day)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 6);
                    break;
                case Carbon::SATURDAY:
                    if ($today->dayOfWeek <= $day)
                        $day->subDay($today->dayOfWeek - $days);
                    else
                        $day->addDay($today->dayOfWeek - $days - 7);
                    break;
            }

            $workday = Timesheet::findWorkday($day->toDateString())->get()->first();

            $day_info = array('day' => $day, 'workday' => $workday);
            $week[] = $day_info;
        }

        sort($week);

        d($week);

        $data['week'] = $week;

        d($data);

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

        // Get the actual date
        $data = Carbon::now();

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
