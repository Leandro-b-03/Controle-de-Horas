<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Lang;
use App\Team;
use App\User;
use App\UserTeam;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class TeamController extends Controller
{
    private $controller_name = 'TeamController';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the teams
        $teams = Team::All();
        $data['teams'] = $teams;

        // Return the teams view.
        return view('team.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Get all users
        $users = User::all();
        $data['users'] = $users;

        // Return the team view.
        return view('team.create')->with('data', $data);
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
                'name'      => 'required',
                'user_id'   => 'required',
                'color'     => 'required|min:7'
            ]
        );

        try {
            if($validator) {
                $team = Team::create( $inputs );
                if ($team) {
                    foreach ($inputs['users_id'] as $user_id) {
                        $data = array('team_id' => $team->id, 'user_id' => $user_id);

                        if (!UserTeam::create( $data )) {
                            DB::rollback();
                            return redirect('teams/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
                        }

                        $notification = [];

                        $notification['user_id'] = $user_id;

                        if ($user_id == Auth::user()->getEloquent()->id) {
                            if ($user_id == Auth::user()->getEloquent()->id && $user_id == $team->user_id) {
                                $notification['message'] = Lang::get('teams.include-create_lider', ['team' => $team->name]);
                            } else {
                                $notification['message'] = Lang::get('teams.include-create', ['team' => $team->name]);
                            }
                        } else if ($user_id == $team->user_id) {
                            $notification['message'] = Lang::get('teams.include-lider', ['team' => $team->name]);
                        } else {
                            $notification['message'] = Lang::get('teams.include-user', ['team' => $team->name]);
                        }

                        $notification['faicon'] = 'group';

                        GeneralController::createNotification($user_id, $notification);
                    }

                    DB::commit();
                    return redirect('teams')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                } else {
                    DB::rollback();
                    return redirect('teams/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                }
            } else {
                DB::rollback();
                return redirect('teams/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
        } catch (Exception $e){
            DB::rollback();
            return redirect('teams/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
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
        // Get all users
        $users = User::all();
        $data['users'] = $users;

        // Get all users
        $users_team = UserTeam::getUsersTeam($id)->get();
        $data['users_team'] = $users_team;
        
        // Retrive the team with param $id
        $team = Team::find($id);
        $data['team'] = $team;

        // Return the dashboard view.
        return view('team.create')->with('data', $data);
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

        // Get team with param $id
        $team = Team::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        try {
            foreach ($inputs as $input => $value) {
                if($team->{$input})
                    $team->{$input} = $value;
            }

            if ($team->save()) {
                $user_team = UserTeam::where('team_id', $id)->get();

                if ($user_team->count() > 0) {
                    UserTeam::where('team_id', $id)->delete();
                }

                foreach ($inputs['users_id'] as $user_id) {
                    $data = array('team_id' => $id, 'user_id' => $user_id);

                    if (!UserTeam::create( $data )) {
                        DB::rollback();
                        return redirect('teams/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
                    }

                    $notification = [];

                    $notification['user_id'] = $user_id;

                    if ($user_id == Auth::user()->getEloquent()->id) {
                        if ($user_id == Auth::user()->getEloquent()->id && $user_id == $team->user_id) {
                            $notification['message'] = Lang::get('teams.include-alter_lider', ['team' => $team->name]);
                        } else {
                            $notification['message'] = Lang::get('teams.include-alter', ['team' => $team->name]);
                        }
                    } else if ($user_id == $team->user_id) {
                        $notification['message'] = Lang::get('teams.include-lider', ['team' => $team->name]);
                    } else {
                        $notification['message'] = Lang::get('teams.include-user', ['team' => $team->name]);
                    }

                    $notification['faicon'] = 'group';

                    GeneralController::createNotification($user_id, $notification);
                }

                DB::commit();
                return redirect('teams')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                DB::rollback();
                return redirect('teams/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('teams/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
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
            if (Team::destroy($ids)) {
                DB::commit();
                return redirect('teams')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'delete'));
            } else {
                DB::rollback();
                return redirect('teams')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('teams')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
