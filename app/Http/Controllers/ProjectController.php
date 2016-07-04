<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Log;
use Lang;
use App\Role;
// use App\Client;
use App\Project;
use App\CustomField;
use App\ProjectTime;
use App\Enumeration;
use App\Http\Requests;
use App\TaskPermission;
use App\TaskPermissionJournal;
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
        $projects = Project::orderBy('created_on', 'desc')->paginate(15);
        $data['projects'] = $projects;

        Log::debug($projects->first()->custom_field()->where('custom_field_id', 33)->get());

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
        // $users = Role::find(2)->users()->get();
        $data['users'] = null;

        // Get all clients
        // $clients = Client::all();
        $data['clients'] = null;

        // Get all proposals
        // $proposals = Proposal::all();
        $data['proposals'] = null;

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

        Log::debug($inputs);

        try {
            foreach ($inputs['columns'] as $column) {
                $enumeration_id = $column[0];
                if (isset($column[1])) {
                    foreach ($column[1] as $value) {
                        $task_permissions = TaskPermission::where('work_package_id', $value)->first();

                        if ($task_permissions) {
                            TaskPermissionJournal::create( array('work_package_id' => $task_permissions->work_package_id, 'enumeration_id' => $task_permissions->enumeration_id) );
                            TaskPermission::where('work_package_id', $value)->delete();
                        }

                        $data = array('work_package_id' => $value, 'enumeration_id' => $enumeration_id);
                        $task_permission = TaskPermission::create( $data );

                        if (!$task_permission) {
                            DB::rollback();
                            return redirect('projects/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                        }
                    }
                }
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

        $tasks = DB::connection('openproject')->table('work_packages AS wp1')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('work_packages AS wp2')
                  ->whereRaw('wp2.parent_id = wp1.id');
        })->where('project_id', $id)->where('type_id', '!=', 2)->get();
        // $data['tasks'] = $tasks;

        $activities = DB::connection('openproject')->table('enumerations AS en1')->whereNotExists(function ($query) use ($id) {
            $query->select(DB::raw(1))
                  ->from('enumerations AS en2')
                  ->whereRaw('en2.parent_id = en1.id')
                  ->where('en2.project_id', $id);
        })->where('en1.type', 'TimeEntryActivity')->where('active', 1)->get();
        $data['activities'] = $activities;

        $tasks_permissions =  array();

        foreach ($tasks as $task) {
            $task_permission = TaskPermission::where('work_package_id', $task->id)->first();
            
            if ($task_permission)
              $tasks_permissions[$task_permission->enumeration_id][] = $task;
            else
              $tasks_permissions[0][] = $task;
        }

        $data['tasks_permissions'] = $tasks_permissions;

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
                if($project->{$input} || $input == 'schedule_time' || $input == 'name_complement')
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
