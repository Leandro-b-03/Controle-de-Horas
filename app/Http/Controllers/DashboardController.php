<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use GeoIP;
use Geocoder;
use App\User;
use App\Project;
use App\Timesheet;
use Carbon\Carbon;
use PusherManager;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Auth::user()->getEloquent() == null) {
            return redirect()->to('register');
        }

        // GeoIP
        $location = GeoIP::getLocation();
        $data['location'] = $location;

        // New Users
        $new_users = User::orderBy('created_at', 'desc')->take(8)->get();
        $data['new_users'] = $new_users;

        // New Projects
        $new_projects = Project::where('status', 1)->orderBy('created_on', 'desc')->take(8)->get();
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
                    'hours' => 0,
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
