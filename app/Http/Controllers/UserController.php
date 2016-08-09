<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Log;
use Lang;
use App\User;
use App\Role;
use App\Holiday;
use App\Overtime;
use App\UserRFID;
use App\Timesheet;
use Carbon\Carbon;
use App\UserSetting;
use App\Http\Requests;
use App\TimesheetTask;
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

        $inputs = $request->all();

        $role = null;

        if (!isset($inputs['role'])) {
            $role = Role::where('name', 'Colaborador');

            if (!$role) {
                $role = new Role();
                $role->name         = 'Colaborador';
                $role->display_name = 'Colaborador'; // optional
                $role->description  = 'Colaborador SVLabs'; // optional
                $role->save();
                $role->attachPermission(array('id' => 41, 'id' => 40, 'id' => 39, 'id' => 38, 'id' => 31, 'id' => 30, 'id' => 29, 'id' => 8));

                $role_id = $role->id;
            } else {
                $role_id = $role->id;
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

            // Attach role to the user
            $role = Role::find($inputs['role']);
            
            $user->detachRole($user->roles()->first());
            
            $user->attachRole($role);

            $rfid_code = UserRFID::where('rfid_code', $inputs['rfid_code'])->get()->first();
            $user_rfid_code = UserRFID::where('user_id', $id)->get()->first();

            if (!$rfid_code and !$user_rfid_code) {
                $rfid_code = array("user_id" => $user->id, "rfid_code" => $inputs['rfid_code']);
                $rfid_code = UserRFID::create($rfid_code);
            } else if ($rfid_code and !$user_rfid_code) {
                $rfid_code->rfid_code = $inputs['rfid_code'];
                $rfid_code->save();
            }

            if (!$rfid_code) {
                DB::rollback();
                if ($request->is('register')) {
                    return redirect('register')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                } else {
                    return redirect('users/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                }
            }

            if ($user->saveOrFail()) {
                DB::commit();
                return redirect('users')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                Log::error($user);

                DB::rollback();
                return redirect('users/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
        } catch (Exception $e) {
            Log::error($e);

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
