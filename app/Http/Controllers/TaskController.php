<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Lang;
use App\Task;
use App\Team;
use App\Project;
use App\ProjectTime;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class TaskController extends Controller
{
    private $controller_name = 'TaskController';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the tasks
        $tasks = Task::All();
        $data['tasks'] = $tasks;

        foreach ($tasks as &$task) {
            $task->teams = Team::findTeamsJson(json_decode($task->teams))->get();
        }

        // Return the tasks view.
        return view('task.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Get all projects
        $projects = Project::all();
        $data['projects'] = $projects;

        // Return the task view.
        return view('task.create')->with('data', $data);
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
            $inputs['teams'] = json_encode($inputs['teams']);

            if($validator) {
                if (Task::create( $inputs )) {
                    return redirect('tasks')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                } else {
                    DB::rollback();
                    return redirect('tasks/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                }
            } else {
                DB::rollback();
                return redirect('tasks/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
        } catch (Exception $e){
            DB::rollback();
            return redirect('tasks/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
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
        // Retrive the task with param $id
        $task = Task::find($id);
        $data['task'] = $task;

        // Get the project_time
        $project_time = Project::find($task->projects_time_id)->get();
        $data['project_time'] = $project_time;

        // Return the dashboard view.
        return view('task.create')->with('data', $data);
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

        // Get task with param $id
        $task = Task::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        try {
            $inputs['teams'] = json_encode($inputs['teams']);

            foreach($inputs as $input => $value) {
                if($task->{$input})
                    $task->{$input} = $value;
            }

            if ($task->save()) {
                DB::commit();
                return redirect('tasks')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                DB::rollback();
                return redirect('tasks/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('tasks/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
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
            if (Task::destroy($ids)) {
                DB::commit();
                return redirect('tasks')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'delete'));
            } else {
                DB::rollback();
                return redirect('tasks')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('tasks')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
