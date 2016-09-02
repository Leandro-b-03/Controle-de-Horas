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
use App\UserLocalization;
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

        $today = new Carbon();

        // GeoIP
        $location = GeoIP::getLocation($request->ip());

        if ($location['ip'] == $request->ip())
            $location['use'] = true;
        
        $data['location'] = $location;

        // New Users
        $new_users = User::orderBy('created_at', 'desc')->take(8)->get();
        $new_users->count = User::where('created_at', '>=', Carbon::now()->startOfMonth())->get()->count();
        $data['new_users'] = $new_users;

        // See if users have started a task
        $users_work = User::orderBy('first_name', 'desc')->orderBy('last_name', 'desc')->get();
        $users = array();

        foreach ($users_work as $user) {
            $handled_user = array();
            $handled_user['name'] = $user->first_name . ' ' . $user->last_name;
            if ($user->timesheets()->getResults()->where('workday', $today->toDateString())->first()) {
                if ($user->timesheets()->getResults()->where('workday', $today->toDateString())->first()->timesheetTasks()->first()) {
                  if (isset($handled_user['project'] = $user->timesheets()->getResults()->where('workday', \Carbon\Carbon::now()->toDateString())->first()->timesheetTasks()->getResults()->first()->getProject()->getResults()->name))
                      $handled_user['project'] = $user->timesheets()->getResults()->where('workday', \Carbon\Carbon::now()->toDateString())->first()->timesheetTasks()->getResults()->first()->getProject()->getResults()->name;
                    else
                      $handled_user['project'] = 'Colaborador com erro de gravação';
                    $handled_user['task'] = $user->timesheets()->getResults()->where('workday', \Carbon\Carbon::now()->toDateString())->first()->timesheetTasks()->getResults()->first()->getTask()->getResults()->subject;
                    if ($user->timesheets()->getResults()->where('workday', \Carbon\Carbon::now()->toDateString())->first()->timesheetTasks()->getResults()->first()->getProject()->getResults()->id != 90 && $user->timesheets()->getResults()->where('workday', \Carbon\Carbon::now()->toDateString())->first()->timesheetTasks()->getResults()->first()->getProject()->getResults()->id != 91) {
                            $handled_user['status'] = 'Trabalhando';
                    } else {
                        $handled_user['status'] = 'Ocioso';
                    }
                    $handled_user['start'] = $user->timesheets()->getResults()->where('workday', \Carbon\Carbon::now()->toDateString())->first()->timesheetTasks()->getResults()->first()->start;
                    if ($handled_user['end'] = $user->timesheets()->getResults()->where('workday', \Carbon\Carbon::now()->toDateString())->first()->timesheetTasks()->getResults()->first()->end != '00:00:00') {
                        $handled_user['end'] = $user->timesheets()->getResults()->where('workday', \Carbon\Carbon::now()->toDateString())->first()->timesheetTasks()->getResults()->first()->end;
                    } else {
                        $handled_user['end'] = 'Atuando';
                    }
                } else {
                    $handled_user['project'] = '----';
                    $handled_user['task'] = '----';
                    $handled_user['status'] = 'Ocioso';
                    $handled_user['start'] = '----';
                    $handled_user['end'] = '----';
                }
            } else {
                $handled_user['project'] = '----';
                $handled_user['task'] = '----';
                $handled_user['status'] = 'Ocioso';
                $handled_user['start'] = '----';
                $handled_user['end'] = '----';
            }

            $users[] = $handled_user;
        }

        $data['users'] = $users;

        // New Projects
        $new_projects = Project::orderBy('created_on', 'desc')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('projects AS projects2')
                  ->whereRaw('projects2.parent_id = projects.id');
            })->orderBy('created_on', 'desc')->take(8)->get();
        $data['new_projects'] = $new_projects;

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

                $timesheet_task = array(
                    'timesheet_id' => $timesheet->id,
                    'project_id' => 91,
                    'work_package_id' => 31416,
                    'start' =>  $today->toTimeString()
                );

                $timesheet_task = TimesheetTask::create( $timesheet_task );

                if ($timesheet_task) {
                    DB::commit(); 
                } else {
                    DB::rollback();
                    Log::error($e);
                    Log::error($work_package);
                    Log::error($timesheet_task);

                    $receive = array('error' => Lang::get('general.error'));
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
            })->whereIn('project_id', $user_projects)->take(5)->get();
            $data['tasks'] = $tasks;

            //   $locations = UserLocalization::groupBy('user_id', 'desc')->get();

            $sub = UserLocalization::orderBy('created_at','desc');

            $locations_db = DB::table(DB::raw("({$sub->toSql()}) as sub"))->groupBy('user_id')->get();

            $locations = array();

            $count = 0;
            foreach ($locations_db as $location) {
              $user = User::find($location->user_id);
              $locations[] = array($user->first_name . ' ' . $user->last_name, $location->latitude, $location->longitude, $count);
              $count++;
            }

            $data['locations'] = $locations;

            // die(d($locations));
        } catch (Exception $e) {
            $data['tasks'] = array();
            $data['message-op'] = true;
            $data['locations'] = array();
        }

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
