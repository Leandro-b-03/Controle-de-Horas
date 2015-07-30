<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Lang;
use App\Role;
use App\Client;
use App\Project;
use App\Proposal;
use App\ProjectTime;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class ProjectController extends Controller
{
    private $controller_name = 'ProjectController';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the projects
        $projects = Project::All();
        $data['projects'] = $projects;

        // d($projects->first()->proposal()->getResults()->client()->getResults()->name);

        // Return the projects view.
        return view('project.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $data = [];

        // Get all the managers users
        $users = Role::find(2)->users()->get();
        $data['users'] = $users;

        // Get all clients
        $clients = Client::all();
        $data['clients'] = $clients;

        // Get all proposals
        $proposals = Proposal::all();
        $data['proposals'] = $proposals;

        // Return the project view.
        return view('project.create')->with('data', $data);
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
                'name' => 'required'
            ]
        );

        $projects_time = $inputs['project_time'];

        try {
            if($validator) {
                $project = Project::create( $inputs );
                if ($project) {
                    foreach ($projects_time as $project_time) {
                        $project_time['cycle'] = $project_time['cycle'][0];
                        $project_time['schedule_time'] = $project_time['schedule_time'][0];
                        $project_time['budget'] = $project_time['budget'][0];
                        $project_time['project_id'] = $project->id;

                        if (ProjectTime::create( $project_time )) {
                            DB::rollback();
                            return redirect('projects/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                        }
                    }
                    DB::commit();
                    return redirect('projects')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                } else {
                    DB::rollback();
                    return redirect('projects/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                }
            } else {
                DB::rollback();
                return redirect('projects/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
        } catch (Exception $e){
            DB::rollback();
            return redirect('projects/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
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
        // Retrive the project with param $id
        $project = Project::find($id);
        $data['project'] = $project;

        // Retrive the project with param $id
        $projects_times = ProjectTime::where('project_id', $id)->get();
        $data['projects_times'] = $projects_times;

        // Get all the managers users
        $users = Role::find(2)->users()->get();
        $data['users'] = $users;

        // Get all clients
        $clients = Client::all();
        $data['clients'] = $clients;

        // Get all proposals
        $proposals = Proposal::all();
        $data['proposals'] = $proposals;

        // Return the dashboard view.
        return view('project.create')->with('data', $data);
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

        // Get project with param $id
        $project = Project::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        $projects_time = $inputs['project_time'];

        try {
            foreach($inputs as $input => $value) {
                if($project->{$input})
                    $project->{$input} = $value;
            }

            if ($project->save()) {
                ProjectTime::where('project_id', $project->id)->delete();
                
                foreach ($projects_time as $project_time) {
                    $project_time['cycle'] = $project_time['cycle'][0];
                    $project_time['schedule_time'] = $project_time['schedule_time'][0];
                    $project_time['budget'] = $project_time['budget'][0];
                    $project_time['project_id'] = $project->id;

                    if (!ProjectTime::create( $project_time )) {
                        DB::rollback();
                        return redirect('projects/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                    }
                }

                DB::commit();
                return redirect('projects')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                DB::rollback();
                return redirect('projects/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('projects/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
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
            if (Project::destroy($ids)) {
                DB::commit();
                return redirect('projects')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'delete'));
            } else {
                DB::rollback();
                return redirect('projects')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('projects')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
