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
        $all_timesheets = Timesheet::where('user_id', Auth::user()->id)->orderBy('workday', 'desc')->get();

        d($all_timesheets);

        foreach ($all_timesheets as &$timesheets) {
            $timesheets->workday = Carbon::createFromFormat('Y-m-d H', $timesheets->workday . '00');
        }

        $data['timesheets'] = $all_timesheets;

        $timesheet_today = $all_timesheets->first();
        $data['timesheet_today'] = $timesheet_today;

        setlocale(LC_TIME, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br');

        $month = Carbon::now()->month;

        // Get the first day
        $today = new Carbon();
        $data['today'] = $today;

        $week = [];

        for ($day = 6; $day >= 0; $day--) {
            $days = new Carbon();

            if ($today->dayOfWeek >= $day)
                $week[] = $days->subDay($today->dayOfWeek - $day - 2);
            else
                $week[] = $days->addDay($today->dayOfWeek - $day - 2);
        }

        sort($week);

        $data['week'] = $week;

        foreach ($week as $day) {
            d($all_timesheets->find('workday'), $day->toDateString());
        }

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
