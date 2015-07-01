<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Route;
use App\GroupPermission;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class GroupPermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the groups
        $groups = GroupPermission::All();
        $data['groups'] = $groups;

        // Return the groups view.
        return view('group-permission.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Create an array with all the controlles names
        $controllers = [];

        foreach (Route::getRoutes()->getRoutes() as $route)
        {
            //d($route);
            $action = $route->getAction();

            if (array_key_exists('controller', $action))
            {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $names = explode('\\', $action['controller']);
                $controller = explode('@', $names[count($names) - 1]);
                if (!in_array($controller[0], $controllers)) {
                    if ($controller[0] != "AuthController" and $controller[0] != 'PasswordController' and $controller[0] != 'HomeController' and $controller[0] != 'DashboardController' and $controller[0] != 'GeneralController')
                        $controllers[] = $controller[0];
                }
            }
        }

        // die(d($controllers));

        // Return the group view.
        return view('group-permission.create')->with('controllers', $controllers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        // Validation of the fields
        $validator = Validator::make(
            [
                $input
            ],
            [
                'name' => 'required',
                'password' => 'required|min:8',
                'email' => 'required|email|unique:users'
            ]
        );

        if($validator) {
            if (GroupPermission::create( $input )) {
                return redirect('groups')->with('return', GeneralController::createMessage('success', 'GroupPermissione', 'create'));
            } else {
                return view('groups.create')->withInput()->with('return', GeneralController::createMessage('failed', 'GroupPermissione', 'create'));
            }
        } else {
            return view('groups.create')->withInput()->with('return', GeneralController::createMessage('failed', 'GroupPermissione', 'create-failed'));
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
        // Retrive the group with param $id
        $group = GroupPermission::find($id);
        $data['group'] = $group;

        // Return the dashboard view.
        return view('group-permission.create')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        // Get group with param $id
        $group = GroupPermission::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        foreach($inputs as $input => $value) {
            if($group->{$input})
                $group->{$input} = $value;
        }

        if ($group->save()) {
            return redirect('groups')->with('return', GeneralController::createMessage('success', 'GroupPermissione', 'update'));
        } else {
            return view('groups.create')->withInput()->with('return', GeneralController::createMessage('failed', 'GroupPermissione', 'update'));
        }
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
        return response()->json(['status' => 'Ok', 'message' => 'Return correct']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function delete(Request $request)
    {
        // Get all the input data received.
        $input = $request->all();

        $ids = explode(',', $input['id']);

        if (GroupPermission::destroy($ids)) {
            return redirect('groups')->with('return', GeneralController::createMessage('success', 'GroupPermissione', 'delete'));
        } else {
            return redirect('groups')->with('return', GeneralController::createMessage('failed', 'GroupPermissione', 'delete'));
        }
    }
}
