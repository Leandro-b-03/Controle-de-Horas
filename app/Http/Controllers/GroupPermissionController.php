<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Lang;
use Route;
use App\Role;
use App\Permission;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class GroupPermissionController extends Controller
{
    private $controller_name = 'GroupPermissionController';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the groups
        $groups = Role::All();
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
        DB::beginTransaction();

        $input = $request->all();

        try {
            $role = new Role();
            $role->name         = $input['name'];
            $role->display_name = $input['display_name']; // optional
            $role->description  = $input['description']; // optional
            
            if ($role->save()) {
                $permissions = array();
                foreach ($input['permission'] as $controller => $permission_controller) {
                    foreach ($permission_controller as $permission => $on) {
                        $permission_exists = Permission::findName($controller . '@' . $permission)->get()->all();

                        if (count($permission_exists) == 0) {
                            $new_permission = new Permission();
                            $new_permission->name = $controller . '@' . $permission;

                            switch ($permission) {
                                case 'create':
                                    $new_permission->display_name = Lang::get('general.create') . ' ' . $controller; // optional
                                    // Allow a user to...
                                    $new_permission->description  = Lang::get('group-permissions.create-new') . $controller; // optional
                                    break;
                                case 'edit':
                                    $new_permission->display_name = Lang::get('general.edit') . ' ' . $controller; // optional
                                    // Allow a user to...
                                    $new_permission->description  = Lang::get('group-permissions.edit-new') . $controller; // optional
                                    break;
                                case 'index':
                                    $new_permission->display_name = Lang::get('general.view') . ' ' . $controller; // optional
                                    // Allow a user to...
                                    $new_permission->description  = Lang::get('group-permissions.view-new') . $controller; // optional
                                    break;
                                case 'delete':
                                    $new_permission->display_name = Lang::get('general.delete') . ' ' . $controller; // optional
                                    // Allow a user to...
                                    $new_permission->description  = Lang::get('group-permissions.delete-new') . $controller; // optional
                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }

                            $new_permission->save();
                        } else {
                            $new_permission = $permission_exists[0];
                        }

                        $permissions[] = $new_permission;
                    }
                }

                try {
                    // equivalent to $owner->perms()->sync(array($createPost->id, $editUser->id));
                    if ($role->attachPermissions($permissions) == null) {
                        DB::commit();
                        return redirect('group-permissions')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                    } else {
                        DB::rollback();
                        return redirect('group-permissions/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                    }
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect('group-permissions/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
                }
            } else {
                DB::rollback();
                return redirect('group-permissions/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('group-permissions/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
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
        $data = [];
        // Get the Role
        $role = Role::find($id);

        $data['role'] = $role;

        // Create an array with all the controlles names
        $controllers = [];

        foreach (Route::getRoutes()->getRoutes() as $route)
        {
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

        // Return the group view.
        return view('group-permission.create')->with('controllers', $controllers)->with('data', $data);
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
        $group = Role::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        d($inputs);

        /*foreach($inputs as $input => $value) {
            if($group->{$input})
                $group->{$input} = $value;
        }

        if ($group->save()) {
            return redirect('group-permissions')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
        } else {
            return view('group-permission.create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
        }*/
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

        if (Role::destroy($ids)) {
            return redirect('group-permissions')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'delete'));
        } else {
            return redirect('group-permissions')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
