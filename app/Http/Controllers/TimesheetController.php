<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
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
        $timesheets = Timesheet::All();
        $data['timesheets'] = $timesheets;

        $month = Carbon::now()->month;

        // Get the first day
        $firstday = new Carbon('first day of this month');
        $data['firstday'] = $firstday;

        d($firstday);

        // Get the last day
        $lastday = new Carbon('last day of this month');
        $data['lastday'] = $lastday;

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
        // Return the timesheet view.
        return view('timesheet.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        
        // Validation of the fields
        $validator = Validator::make(
            [
                $inputs
            ],
            [
                'name' => 'required',
                'password' => 'required|min:8',
                'email' => 'required|email|unique:users'
            ]
        );

        try {
            $inputs['phone'] = str_replace('_', '', $inputs['phone']);

            if($validator) {
                if (Timesheet::create( $inputs )) {
                    return redirect('timesheets')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                } else {
                    DB::rollback();
                    return redirect('timesheets/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                }
            } else {
                DB::rollback();
                return redirect('timesheets/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
        } catch (Exception $e){
            DB::rollback();
            return redirect('timesheets/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
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
        DB::beginTransaction();

        // Get timesheet with param $id
        $timesheet = Timesheet::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        try {
            $inputs['phone'] = str_replace('_', '', $inputs['phone']);

            foreach($inputs as $input => $value) {
                if($timesheet->{$input})
                    $timesheet->{$input} = $value;
            }

            if ($timesheet->save()) {
                DB::commit();
                return redirect('timesheets')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                DB::rollback();
                return redirect('timesheets/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('timesheets/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
        }
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
