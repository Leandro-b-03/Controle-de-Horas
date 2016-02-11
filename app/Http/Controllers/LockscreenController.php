<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Timesheet;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LockscreenController extends Controller
{
    private $controller_name = 'LockscreenController';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = new Carbon();

        $timesheet = Timesheet::where('user_id', Auth::user()->getEloquent()->id)->where('lunch_start', '!=', '00:00:00')->where('lunch_end', '00:00:00')->where('workday', $today->toDateString())->get()->first();

        if ($timesheet) {
            $lunch_time = new Carbon($timesheet->lunch_start);

            $diffTime = $lunch_time->diffInMinutes($today);

            $hour = $diffTime / 60;

            $lunch_time->addHours(1);
            $data['lunch_time'] = $lunch_time;

            if ($timesheet && ($diffTime < 11)) {
                // Return the lockscreen view.
                return view('lockscreen.index')->with('data', $data);
            } else {
                // Return the timesheets view.
                return redirect()->to('timesheets');
            }
        } else {
            // Return the timesheets view.
            return redirect()->to('timesheets');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
