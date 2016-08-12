<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App;
use DB;
use Auth;
use GeoIP;
use Geocoder;
use App\User;
use App\Member;
use App\Project;
use App\Timesheet;
use Carbon\Carbon;
use PusherManager;
use App\TimesheetTask;
use App\Http\Requests;
use App\UserOpenProject;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->getEloquent() == null) {
            return redirect()->to('register');
        }

        // GeoIP
        $location = GeoIP::getLocation($request->ip());

        if ($location['ip'] == $request->ip())
            $location['use'] = true;
        
        $data['location'] = $location;

        // New Users
        $new_users = User::orderBy('created_at', 'desc')->take(8)->get();
        $new_users->count = User::where('created_at', '>=', Carbon::now()->startOfMonth())->get()->count();
        $data['new_users'] = $new_users;

        // New Projects
        $new_projects = Project::orderBy('created_on', 'desc')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('projects AS projects2')
                  ->whereRaw('projects2.parent_id = projects.id');
            })->orderBy('created_on', 'desc')->take(8)->get();
        $data['new_projects'] = $new_projects;

        $today = new Carbon();

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
                }
            }
        } catch (Exception $e) {
            DB::rollback();
            $data['error'] =  Lang::get('general.error-day');
        }

        try {
            // Get the Openproject's user id
            $user = UserOpenProject::where('login', 'LIKE', Auth::user()->getEloquent()->username . '@%')->orWhere('mail', 'LIKE', Auth::user()->getEloquent()->username . '@%')->get()->first();

            $user_id = null;
            if ($user) {
                $user_id = $user->id;
            } else {
                $data['message-op'] = true;
            }

            // Get all the Projects that the user is assigned off
            $user_projects = Member::select('project_id')->where('user_id', $user_id)->get()->toArray();

            // Get all task
            $tasks = DB::connection('openproject')->table('work_packages AS wp1')->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('work_packages AS wp2')
                      ->whereRaw('wp2.parent_id = wp1.id');
            })->whereIn('project_id', $user_projects)->take(15)->get();
            $data['tasks'] = $tasks;
        } catch (Exception $e) {
            $data['tasks'] = array();
            $data['message-op'] = true;
        }

        // Get all the Projects that the user is assigned off
        $user_projects = Member::select('project_id')->where('user_id', $user_id)->get()->toArray();

        // Get all task
        $tasks = DB::connection('openproject')->table('work_packages AS wp1')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('work_packages AS wp2')
                  ->whereRaw('wp2.parent_id = wp1.id');
        })->whereIn('project_id', $user_projects)->take(15)->get();
        $data['tasks'] = $tasks;

        // Return the dashboard view.
        return view('dashboard.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
