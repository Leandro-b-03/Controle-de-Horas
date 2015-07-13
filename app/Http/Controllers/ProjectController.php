<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Lang;
use App\Role;
use App\Client;
use App\Project;
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
                'name' => 'required',
                'password' => 'required|min:8',
                'email' => 'required|email|unique:users'
            ]
        );

        try {
            if($validator) {
                if (Project::create( $inputs )) {
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

        try {
            foreach($inputs as $input => $value) {
                if($project->{$input})
                    $project->{$input} = $value;
            }

            if ($project->save()) {
                DB::commit();
                return redirect('projects')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                DB::rollback();
                return redirect('projects/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('projects/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
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
