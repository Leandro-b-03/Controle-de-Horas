<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use URL;
use Auth;
use Lang;
use Mail;
use App\User;
use App\Team;
use App\Task;
use App\Settings;
use App\Proposal;
use PusherManager;
use App\Timesheet;
use Carbon\Carbon;
use App\ClientGroup;
use App\ProjectTime;
use App\UserSetting;
use App\ProposalType;
use App\Http\Requests;
use App\TimesheetTask;
use App\ProposalVersion;
use App\UserLocalization;
use App\UserNotification;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    private $controller_name = 'SettingsController';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Create a data variable for view can consulting
        $data = [];

        // Get all the settings
        $settings = Settings::findOrFail(1);
        $data['settings'] = $settings;

        return view('settings.index')->with('data', $data);
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
