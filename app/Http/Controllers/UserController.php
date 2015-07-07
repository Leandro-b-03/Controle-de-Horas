<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Lang;
use App\User;
use App\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class UserController extends Controller
{
    private $controller_name = 'UserController';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the users
        $users = User::All();
        $data['users'] = $users;

        // Return the users view.
        return view('user.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Create a data variable for view can consulting
        $data = [];

        // Get all Roles
        $roles = Role::all();

        $data['roles'] = $roles;

        // Return the user view.
        return view('user.create')->with('data', $data);
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

            if ($input['password'] == $input['confirm_password']) {
                if($validator) {
                    $input['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $input['birthday'])));
                    $input['password'] = bcrypt($input['password']);

                    $user = User::create( $input );

                    if ($user) {
                        $user->attachRole(Role::find($input['role']));
                        DB::commit();
                        return redirect('users')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                    } else {
                    DB::rollback();
                        return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                    }
                } else {
                    DB::rollback();
                    return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
                }
             } else {
                DB::rollback();
                return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'password'));
            }
        } catch (Exeption $e) {
            DB::rollback();
            return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
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
        // Create a data variable for view can consulting
        $data = [];

        // Get all Roles
        $roles = Role::all();

        $data['roles'] = $roles;

        // Retrive the user with param $id
        $user = User::find($id);
        $data['user'] = $user;

        // Return the dashboard view.
        return view('user.create')->with('data', $data);
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
        
        // Get user with param $id
        $user = User::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        try {
            // Attach role to the user
            $role = Role::find($inputs['role']);
            
            $user->detachRole($user->roles()->first());
            
            $user->attachRole($role);

            $inputs['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $inputs['birthday'])));
            
            if ($inputs['password'] != ''){
                if ($inputs['password'] == $inputs['confirm_password']) {
                    $inputs['password'] = bcrypt($inputs['password']);
                } else {
                    DB::rollback();
                    return redirect('users/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'password'));
                }
            } else {
                $inputs['password'] = 'n';
            }

            $fillable = $user->getFillable([]);

            foreach($inputs as $input => $value) {
                if ($user->{$input} || in_array($input, $fillable))
                    if ($input != 'password' && $value != 'n')
                        $user->{$input} = $value;
            }

            if ($user->save()) {
                DB::commit();
                return redirect('users')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                DB::rollback();
                return redirect('users/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('users/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
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
        DB::beginTransaction();

        // Get all the input data received.
        $input = $request->all();

        $ids = explode(',', $input['id']);

        if (User::destroy($ids)) {
            DB::commit();
            return redirect('users')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'delete'));
        } else {
            DB::rollback();
            return redirect('users')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
