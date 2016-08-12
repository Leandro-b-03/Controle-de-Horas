<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Log;
use Lang;
use Auth;
use App\User;
use App\Role;
use GoogleMaps;
use App\Holiday;
use App\Overtime;
use App\UserRFID;
use App\Timesheet;
use Carbon\Carbon;
use App\UserProfile;
use App\UserSetting;
use App\Http\Requests;
use App\TimesheetTask;
use App\UserLocalization;
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
        $users = User::paginate(20);
        $data['users'] = $users;

        if (Auth::user()->hasRole('Colaborador')) {
            // Return the users view.
            return redirect('/');
        } else {
            // Return the users view.
            return view('user.index')->with('data', $data);
        }
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

        

        if (Auth::user()->hasRole('Colaborador')) {
            // Return the users view.
            return redirect('/');
        } else {
            // Return the user view.
            return view('user.create')->with('data', $data);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        $inputs = $request->all();

        $role = null;

        $role_id = null;

        if (!isset($inputs['role'])) {
            $role_exists = Role::where('name', 'Colaborador')->get()->first();

            if (!$role_exists) {
                $role = new Role();
                $role->name         = 'Colaborador';
                $role->display_name = 'Colaborador'; // optional
                $role->description  = 'Colaborador SVLabs'; // optional
                $role->save();
                $role->attachPermission(array('id' => 41, 'id' => 40, 'id' => 39, 'id' => 38, 'id' => 31, 'id' => 30, 'id' => 29, 'id' => 8));

                $role_id = $role->id;
            } else {
                $role_id = $role_exists->id;
            }
        } else {
            $role_id = $inputs['role'];
        }
        
        try {
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

            $confirmation_code = str_random(30);

            $inputs['confirmation_code'] = $confirmation_code;

            if($validator) {
                $inputs['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $inputs['birthday'])));
                $inputs['password'] = bcrypt($confirmation_code);

                $user = User::create( $inputs );

                if ($user) {
                    $user->attachRole(Role::find($role_id));

                    $settings = array(
                        'user_id' => $user->id,
                        'skin' => 'skin-yellow',
                        'boxed' => 'false',
                        'sidebar_toggle' => 'false',
                        'right_sidebar_slide' => 'control-sidebar-open',
                        'right_sidebar_white' => 'true'
                    );

                    $settings = UserSetting::create( $settings );

                    if (!$settings)  {
                        DB::rollback();
                        if ($request->is('register')) {
                            return redirect('register')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                        } else {
                            return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                        }
                    }

                    $notification = array(
                        'user_id' => $user->id,
                        'faicon'  => 'plus-circle',
                        'message' => Lang::get('users.welcome'),
                    );

                    if (isset($inputs['rfid_code'])) {
                        $rfid_code = array("user_id" => $user->id, "rfid_code" => $inputs['rfid_code']);

                        $rfid_code = UserRFID::create($rfid_code);

                        if (!$rfid_code) {
                            DB::rollback();
                            if ($request->is('register')) {
                                return redirect('register')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                            } else {
                                return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                            }
                        }
                    }

                    GeneralController::createNotification($user->id, $notification);

                    // GeneralController::mail($user, 'signup');                        
                    DB::commit();
                    if ($request->is('register')) {
                        return redirect('register')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                    } else {
                        return redirect('users')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                    }
                } else {
                    DB::rollback();
                    if ($request->is('register')) {
                        return redirect('register')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                    } else {
                        return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                    }
                }
            } else {
                DB::rollback();
                if ($request->is('register')) {
                    return redirect('register')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
                } else {
                    return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
                }
            }
        } catch (Exeption $e) {
            DB::rollback();
            if ($request->is('register')) {
                return redirect('register')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            } else {
                return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
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
        // Retrive the user with param $id
        $user = User::find($id);
        $data['user'] = $user;

        $timesheets = Timesheet::select('id')->where('user_id', $id)->get();

        // Retrive all the tasks done
        $tasks = TimesheetTask::whereIn('timesheet_id', $timesheets->toArray())->get();
        $data['tasks'] = $tasks;

        // Create a data variable for view can consulting
        $data = [];

        // Get all Roles
        $roles = Role::all();

        $data['roles'] = $roles;
        $data['user'] = $user;

        $profile = UserProfile::where('user_id', $id)->get()->first();

        if ($profile) {
            $data['profile'] = $profile;

            $skills_refined = explode(',', $profile->skills);
            $skills = array();
            foreach ($skills_refined as $key => $value) {
                $number = rand(1,5);

                $color = '';
                switch ($number) {
                    case 1:
                        $color = "primary";
                        break;
                    case 2:
                        $color = "danger";
                        break;
                    case 3:
                        $color = "success";
                        break;
                    case 4:
                        $color = "warning";
                        break;
                    case 5:
                        $color = "info";
                        break;
                    
                    default:
                        $color = "primary";
                        break;
                }

                $skills[] = array($color, $value);
            }

            // die(d($skills));

            $data['skills'] = $skills;
        }

        $location = UserLocalization::where('user_id', $id)->get()->last();

        $url  = "http://maps.googleapis.com/maps/api/geocode/json?latlng=".
        $location->latitude.",".$location->longitude."&sensor=false";
        $json = @file_get_contents($url);
        $return = json_decode($json);
        $status = $return->status;
        $location = '';

        if($status == "OK"){
            $location = $return->results[0]->formatted_address;
        }

        $data['location'] = $location;

        // Return the dashboard view.
        return view('user.profile')->with('data', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function timesheet($id, Request $request)
    {
        // Get the workdays in the month
        $inputs = $request->all();

        // Get all holidays in the month
        $holidays = Holiday::where('month', (isset($inputs['month'])) ? $inputs['month'] : Carbon::now()->month)->get();
        $data['holidays'] = $holidays;

        // Get the overtime
        $overtime = Overtime::where('user_id', $id)->get()->first();
        $data['overtime'] = $overtime;

        // Get the workdays in the month
        $month = Timesheet::where(DB::raw('MONTH(workday)'), (isset($inputs['month']) ? $inputs['month'] : Carbon::now()->month))
            ->where(DB::raw('YEAR(workday)'), (isset($inputs['year']) ? $inputs['year'] : Carbon::now()->year))->where('user_id', $id)->orderBy('workday')->get();
        $data['month'] = $month;

        // Get total hour month
        $total_month_hours = GeneralController::getTotalMonthHours((isset($inputs['month']) ? $inputs['month'] : Carbon::now()->month), (isset($inputs['year']) ? $inputs['year'] : Carbon::now()->year), $month);
        $data['total_month_hours'] = $total_month_hours;

        // Set date and get month
        $month_name = ucwords(Carbon::create((isset($inputs['year']) ? $inputs['year'] : Carbon::now()->year), (isset($inputs['month']) ? $inputs['month'] : Carbon::now()->month), 1)->formatLocalized('%B %Y'));
        $data['$month_name'] = utf8_encode($month_name);

        $data['actual_month'] = (isset($inputs['month'])) ? $inputs['month'] : Carbon::now()->month;
        $data['year'] = (isset($inputs['year'])) ? $inputs['year'] : Carbon::now()->year;

        $data['user_id'] = $id;

        // Return the timesheets view.
        return view('user.show')->with('data', $data);
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
        // Retrive the rfid code
        $user_rfid_code = UserRFID::where('user_id', $id)->get()->first();

        if ($user_rfid_code)
            $user->rfid_code = $user_rfid_code->rfid_code;
        $data['user'] = $user;

        if (Auth::user()->hasRole('Colaborador')) {
            // Return the users view.
            return redirect('/');
        } else {
            // Return the users view.
            return view('user.create')->with('data', $data);
        }
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

        // Get all the inputs from update.
        $inputs = $request->all();

        try {
            $inputs['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $inputs['birthday'])));

            $fillable = $user->getFillable([]);

            foreach($inputs as $input => $value) {
                if ($user->{$input} || in_array($input, $fillable))
                    if ($input != 'password' && $input != "rfid_code")
                        $user->{$input} = $value;
            }

            if (isset($inputs['role'])) {
                // Attach role to the user
                $role = Role::find($inputs['role']);

                d($inputs['role']);
                
                $user->detachRole($user->roles()->first());
                
                $user->attachRole($role);
            }

            if (isset($inputs['rfid_code'])) {
                $rfid_code = UserRFID::where('rfid_code', $inputs['rfid_code'])->get()->first();
                $user_rfid_code = UserRFID::where('user_id', $id)->get()->first();

                d($rfid_code);
                d($user_rfid_code);

                if ($rfid_code != $user_rfid_code) {
                    if (!$rfid_code and !$user_rfid_code) {
                        $user_rfid_code = array("user_id" => $user->id, "rfid_code" => $inputs['rfid_code']);
                        $user_rfid_code = UserRFID::create($rfid_code);
                    } else if (!$rfid_code and $user_rfid_code) {
                        $user_rfid_code->rfid_code = $inputs['rfid_code'];
                        $user_rfid_code->save();
                    }

                    if (!$user_rfid_code) {
                        DB::rollback();
                        return redirect('users/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
                    }
                }
            }

            if (isset($inputs['education'])) {
                $profile = UserProfile::where('user_id', $id)->get()->first();

                if (!$profile) {
                    $profile = array('user_id' => $id,
                        'education' => $inputs['education'],
                        'skills' => $inputs['skills'],
                        'description' => $inputs['description']
                        );

                    $profile = UserProfile::create($profile);
                } else {
                    $profile->education = $inputs['education'];
                    $profile->skills = $inputs['skills'];
                    $profile->description = $inputs['description'];

                    $profile->save();
                }

                if (!$profile) {
                    return redirect('profile/' . $id)->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
                }
            }

            if ($user->saveOrFail()) {
                DB::commit();
                if ($request->is('users/' . $id . '/edit')) {
                    return redirect('users')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
                } else {
                    return redirect('profile/' . $id)->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
                }
            } else {
                Log::error($user);

                DB::rollback();
                if ($request->is('users/' . $id . '/edit')) {
                    return redirect('users/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
                } else {
                    return redirect('profile/' . $id)->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
                }
            }
        } catch (Exception $e) {
            Log::error($e);

            DB::rollback();
            if ($request->is('users/' . $id . '/edit')) {
                return redirect('users/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                return redirect('profile/' . $id)->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
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

        // Get all the inputs data received.
        $inputs = $request->all();

        $ids = explode(',', $inputs['id']);

        try {
            if (User::destroy($ids)) {
                DB::commit();
                return redirect('users')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'delete'));
            } else {
                DB::rollback();
                return redirect('users')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('users')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
