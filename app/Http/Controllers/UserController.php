<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\User;
use App\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class UserController extends Controller
{

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

            if($validator) {
                $input['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $inputs['birthday'])));
                $input['password'] = bcrypt($input['password']);

                if (User::create( $input )) {
                    DB::commit();
                    return redirect('users')->with('return', GeneralController::createMessage('success', 'Colaborador', 'create'));
                } else {
                DB::rollback();
                    return view('users.create')->withInput()->with('return', GeneralController::createMessage('failed', 'Colaborador', 'create'));
                }
            } else {
                DB::rollback();
                return view('users.create')->withInput()->with('return', GeneralController::createMessage('failed', 'Colaborador', 'create-failed'));
            }
        } catch (Exeption $e) {
            DB::rollback();
            return view('users.create')->withInput()->with('return', GeneralController::createMessage('failed', 'Colaborador', 'create-failed'));
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
            
            if ($inputs['password'] != '')
                $inputs['password'] = bcrypt($inputs['password']);
            else
                $inputs['password'] = 'n';

            $fillable = $user->getFillable([]);

            foreach($inputs as $input => $value) {
                if ($user->{$input} || in_array($input, $fillable))
                    if ($input != 'password' && $value != 'n')
                        $user->{$input} = $value;
            }

            if ($user->save()) {
                DB::commit();
                return redirect('users')->with('return', GeneralController::createMessage('success', 'Colaborador', 'update'));
            } else {
                DB::rollback();
                return view('users.create')->withInput()->with('return', GeneralController::createMessage('failed', 'Colaborador', 'update'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return view('users.create')->withInput()->with('return', GeneralController::createMessage('failed', 'Colaborador', 'update'));
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
            return redirect('users')->with('return', GeneralController::createMessage('success', 'Colaborador', 'delete'));
        } else {
            DB::rollback();
            return redirect('users')->with('return', GeneralController::createMessage('failed', 'Colaborador', 'delete'));
        }
    }
}
