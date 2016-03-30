<?php

namespace App\Http\Controllers;

setlocale(LC_TIME, "Portuguese");
setlocale(LC_TIME, "Brazil");
setlocale(LC_TIME, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br', 'portuguese');

use DB;
use URL;
use Auth;
use Lang;
use Mail;
// use Image;
use App\User;
use App\Team;
use App\Task;
use App\Proposal;
use PusherManager;
use App\Timesheet;
use Carbon\Carbon;
use App\ClientGroup;
use App\ProjectTime;
use App\UserSetting;
use App\ProposalType;
use App\Http\Requests;
use App\TimesheetTask;
use App\ProposalVersion;
use App\UserLocalization;
use App\UserNotification;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as Image;

class GeneralController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /* Ajax requisitions */

    /**
     * Generates an array with parameters to messages
     *
     * @return Array with message
     */
    public function createMessageJSON(Request $request)
    {
        // Get the data receive from ajax.
        $inputs = $request->all();

        return response()->json($this->createMessage($inputs['type'], $inputs['icon'], $inputs['message']));
    }

    /**
     * Generates an array with parameters to messages
     *
     * @return Array with message
     */
    public function createNotificationJSON(Request $request)
    {
        // Get the data receive from ajax.
        $inputs = $request->all();

        return response()->json($this->createMessage($inputs['type'], $inputs['name'], $inputs['kind'], (isset($inputs['message']) ? $inputs['message'] : '')));
    }

    /**
     * Generates a name to project
     *
     * @return Array with message
     */
    public function projectNameJSON(Request $request)
    {
        // Get the data receive from ajax.
        $inputs = $request->all();

        $name = "-";

        $proposal = Proposal::find($inputs['id']);
        $proposal_version = ProposalVersion::find($proposal->id)->where('active', 1)->first();
        $name .= $proposal->client()->getResults()->name;
        $name .= "-" . $proposal->type()->getResults()->name;
        $name .= "-" . $proposal->clientGroup()->getResults()->name;
        $name .= "-" . $proposal->name;
        $name .= "-" . Carbon::now()->format('m/y');
        $name .= " " . $proposal_version->version;

        return strtoupper($name);
    }

    public function verifyEmailJSON(Request $request)
    {
        // Get the data receive from ajax.
        $inputs = $request->all();

        // Get user by e-mail
        $user = User::where('email', $inputs['email'])->get();

        $response = [];
        
        if ($user->count() > 0) {
            $response = array(
                'valid' => false,
                'message' => Lang::get('general.email-used')
            );
        } else {
            $response = array(
                'valid' => true
            );
        }

        return response()->json($response);
    }

    /**
     *
     * Verify the CPF
     * $request Request
     * return $response json
     */
    public function verifyCPFJSON(Request $request)
    {
        // Get the data receive from ajax.
        $inputs = $request->all();

        // Get user by e-mail
        $user = User::where('cpf', $inputs['cpf'])->get();

        // Let only numbers in the cpf
        $cpf = preg_replace('/\D/', '', $inputs['cpf']);

        $response = [];

        if (strlen($cpf) != 11) {
            $response = array(
                'valid' => false,
                'message' => Lang::get('general.cpf-wrong')
            );
        } else if ($cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' ||
                   $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' ||
                   $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' ||
                   $cpf == '99999999999') {
            $response = array(
                'valid' => false,
                'message' => Lang::get('general.cpf-wrong')
            );
        } else {
            $digitos = substr($cpf, 0, 9);
            $new_cpf = $this->calcCPF($digitos);
        
            $new_cpf = $this->calcCPF($new_cpf, 11);
            
            if ( $new_cpf !== $cpf ) {
                $response = array(
                    'valid' => false,
                    'message' => Lang::get('general.cpf-wrong')
                );
            } else if ($user->count() > 0) {
                $response = array(
                    'valid' => false,
                    'message' => Lang::get('general.cpf-used')
                );
            } else {
                $response = array(
                    'valid' => true
                );
            }
        }

        return response()->json($response);
    }

    /**
     * Multiply digits times positions
     *
     * @param string $digits
     * @param int $positions
     * @param int $sum_digits
     * @return int
     */
    public function calcCPF( $digits, $positions = 10, $sum_digits = 0 )
    {
        for ( $i = 0; $i < strlen( $digits ); $i++  ) {
            $sum_digits += ( $digits[$i] * $positions );
            $positions--;
        }

        $sum_digits = $sum_digits % 11;
 
        if ( $sum_digits < 2 ) {
            $sum_digits = 0;
        } else {
            $sum_digits = 11 - $sum_digits;
        }

        $cpf = $digits . $sum_digits;

        return $cpf;
    }

    /**
     * Generates an array with parameters to users
     *
     * @return Json with users
     */
    public function getUserAutocomplete(Request $request)
    {
        // Get all inputs
        $string = $request->all();

        // Search users with the string
        $users = User::findUserAC($string['query'])->get();

        $result = array();

        foreach ($users as $user) {
            $find['value'] = $user->first_name . ' ' . $user->last_name;
            $find['data']['id'] = $user->id;
            $find['data']['username'] = $user->username;
            $find['data']['email'] = $user->email;
            $find['data']['photo'] = $user->photo;
            $find['data']['name'] = $user->first_name . ' ' . $user->last_name;
            $find['data']['role'] = $user->roles()->first()->display_name;
            $find['data']['created_at'] = $user->created_at;

            $result['suggestions'][] = $find;
        }

        return response()->json($result);
    }

    /**
     * Generates an array with parameters to teams
     *
     * @return Json with teams
     */
    public function getTeamAutocomplete(Request $request)
    {
        // Get all inputs
        $string = $request->all();

        // Search teams with the string
        $teams = Team::findTeam($string['query'])->get();

        $result = array();

        foreach ($teams as $team) {
            $find['value'] = $team->name;
            $find['data']['id'] = $team->id;
            $find['data']['name'] = $team->name;
            $find['data']['color'] = $team->color;

            $result['suggestions'][] = $find;
        }

        return response()->json($result);
    }

    /**
     * Generates an array with parameters to users
     *
     * @return Json with users
     */
    public function getUser(Request $request)
    {
        // Get all inputs
        $id = $request->all();

        // Get user with the id
        $user = User::find($id['id']);

        return response()->json($user);
    }

    /**
     * Generates an array with parameters to Project Times
     *
     * @return Json with Project Times
     */
    public function getProjectTimes(Request $request)
    {
        $id = $request->get('id');

        $projects_times = ProjectTime::where('project_id', $id)->get();

        return response()->json($projects_times);
    }

    /**
     * Generates an array with parameters to client groups
     *
     * @return Json with client groups
     */
    public function getClientGroup(Request $request)
    {
        $id = $request->get('id');

        $client_group = ClientGroup::where('client_id', $id)->get();

        return response()->json($client_group);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $request
     * @return Response
     */
    public function getTasks(Request $request)
    {
        $project_id = $request->all();

        $tasks = DB::connection('openproject')->table('work_packages AS wp1')->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('work_packages AS wp2')
                  ->whereRaw('wp2.parent_id = wp1.id');
        })->where('project_id', $project_id['id'])->where('status_id', '!=', 11)->get();
        
        return response()->json($tasks);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $request
     * @
     */
    public function getTasksDay(Request $request) {
        // Get all the inputs
        $inputs = $request->all();

        // Get all the task on that day or the day
        $workday = Timesheet::find($inputs['id']);
        $data['workday'] = $workday;

        // Get all the task on that day or the day
        $tasks = TimesheetTask::where('timesheet_id', $inputs['id'])->orderBy('id', 'DESC')->get();
        $data['tasks'] = $tasks;

        return view('general.timeline')->with('data', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $request
     * @
     */
    public function getAllNotifications(Request $request) {
        // Get all the inputs
        $inputs = $request->all();

        // Get all the task on that day or the day
        $notifications = UserNotification::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $data['notifications'] = $notifications;

        return view('general.notification')->with('data', $data);
    }

    /**
     * Save the user settings
     *
     * @return Json with message true or false
     */
    public function saveSettings(Request $request)
    {
        $inputs = $request->all();

        $settings = UserSetting::where('user_id', Auth::user()->id)->get()->first();

        $data = [];
        
        if ($settings) {
            foreach($inputs as $input => $value) {
                $settings->{$input} = $value;
            }

            if ($settings->save()) {
                $data['success'] = true;
                $data['message'] = 'salvo';
            } else {
                $data['error'] = true;
                $data['message'] = 'não salvo';
            }
        } else {
            $inputs['user_id'] = Auth::user()->id;
            if (UserSetting::create( $inputs )) {
                $data['success'] = true;
                $data['message'] = 'salvo';
            } else {
                $data['error'] = true;
                $data['message'] = 'não salvo';
            }
        }

        return response()->json($data);
    }

    /**
     * Save the user position
     *
     * @return Json with message true or false
     */
    public function saveLocalization(Request $request)
    {
        // Get all the inputs
        $inputs = $request->all();

        // Get if the actual user position on the database
        $localization = UserLocalization::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get()->first();

        $data = [];
        
        if ($localization) {
            if (substr($localization->latitude, 0, 7) != substr($inputs['latitude'], 0, 7)
                && substr($localization->longitude, 0, 7) != substr($inputs['longitude'], 0, 7)) {
                if (UserLocalization::create ($inputs)) {
                    $data['success'] = true;
                    $data['message'] = 'salvo';
                } else {
                    $data['error'] = true;
                    $data['message'] = 'não salvo';
                }
            }
        } else {
            if (UserLocalization::create ($inputs)) {
                $data['success'] = true;
                $data['message'] = 'salvo';
            } else {
                $data['error'] = true;
                $data['message'] = 'não salvo';
            }
        }

        return response()->json($data);
    }


    /**
     * Save the user photos
     *
     * @return string iwht an image
     */
    public function saveImages(Request $request) {
        // Get all the inputs
        $inputs = $request->all();

        $destinationPath = public_path() . '/images/avatar/upload/';

        $file = str_replace('data:image/png;base64,', '', $inputs['image']);
        $img = str_replace(' ', '+', $file);
        $data = base64_decode($img);
        $filename = date('ymdhis') . '_croppedImage' . ".png";

        $returnData = '/images/avatar/upload/normal/' . $filename;
        $file = $destinationPath . 'normal/' . $filename;

        // Save photo normal
        $success = file_put_contents($file, $data);

        $image = Image::make($returnData);

        // Save photo 500x500
        $image500x500 = $image->resize(500, 500)->save($destinationPath . '500x500/' . $filename);

        // Save photo 240x240
        $image240x240 = $image->resize(240, 240)->save($destinationPath . '240x240/' . $filename);

        // Save photo 100x100
        $image100x100 = $image->resize(100, 100)->save($destinationPath . '100x100/' . $filename);

        if ($image500x500)
            return $image500x500;
        else {
            return array(
                'valid' => false,
                'message' => Lang::get('general.cpf-wrong')
            );
        }
    }

    /* Statics Functions */

    /**
     * Generates an array with parameters to messages
     *
     * @return Array with message
     */
    public static function createMessage($type, $name, $kind, $custonMessage = '')
    {
        // Array that will contain the generic message
        $message = array();

        // Verify what type is the message
        if ($type == 'success') {
            // Verify what kind is the message
            switch ($kind) {
                case 'create':
                    $message = array(
                        'status' => Lang::get('general.success'),
                        'class' => 'success',
                        'faicon' => 'check',
                        'message' =>  Lang::get('general.success-create', ['name' => $name])
                    );
                    break;
                case 'update':
                    $message = array(
                        'status' => Lang::get('general.success'),
                        'class' => 'success',
                        'faicon' => 'check',
                        'message' => Lang::get('general.success-update', ['name' => $name])
                    );
                    break;
                case 'delete':
                    $message = array(
                        'status' => Lang::get('general.success'),
                        'class' => 'success',
                        'faicon' => 'check',
                        'message' => Lang::get('general.success-delete', ['name' => $name])
                    );
                default:
                    # code...
                    break;
            }
        } else {
            // Verify what kind is the message
            switch ($kind) {
                case 'create':
                    $message = array(
                        'status' => Lang::get('general.failed'),
                        'class' => 'danger',
                        'faicon' => 'ban',
                        'message' => Lang::get('general.failed-create', ['name' => strtolower($name)])
                    );
                    break;
                case 'update':
                    $message = array(
                        'status' => Lang::get('general.failed'),
                        'class' => 'danger',
                        'faicon' => 'ban',
                        'message' => Lang::get('general.failed-update', ['name' => strtolower($name)])
                    );
                    break;
                case 'create-failed':
                    $message = array(
                        'status' => Lang::get('general.failed'),
                        'class' => 'danger',
                        'faicon' => 'ban',
                        'message' => Lang::get('general.failed-create-failed', ['name' => strtolower($name)])
                    );
                    break;
                case 'delete':
                    $message = array(
                        'status' => Lang::get('general.failed'),
                        'class' => 'danger',
                        'faicon' => 'ban',
                        'message' => Lang::get('general.failed-delete', ['name' => strtolower($name)])
                    );
                    break;
                case 'password':
                    $message = array(
                        'status' => Lang::get('general.failed'),
                        'class' => 'danger',
                        'faicon' => 'ban',
                        'message' => Lang::get('general.failed-password')
                    );
                    break;
                default:
                    $message = array(
                        'status' => Lang::get('general.failed'),
                        'class' => 'danger',
                        'faicon' => 'ban',
                        'message' => $custonMessage
                    );
                    break;
                }
        }

        return $message;
    }

    /**
     * Generates an array with parameters to messages
     *
     * @return Array with message
     */
    public static function createNotification($user_id, $notification)
    {
        PusherManager::trigger('presence-user-' . $user_id, 'new_notification', $notification);

        $notification['see'] = 0;

        if (!UserNotification::create($notification)) {
            $notification_fail['message'] = Lang::get('general.failed-notification');
            $notification_fail['faicon'] = 'times';
            PusherManager::trigger('presence-user-' . Auth::user()->id, 'new_notification', $notification);
        }
    }

    /**
     * Send e-mails
     *
     * @return E-mail send
     */
    public static function mail($data, $type)
    {
        // Verify what kind is the email
        switch ($type) {
            case 'signup':
                $send = [];

                $send['company']    = 'SVLabs';
                $send['email']      = $data->email;
                $send['year']       = Carbon::now()->format('Y');
                $send['name']       = $data->first_name;
                $send['url']        = URL::to('auth/confirm?ce=' . $data->confirmation_code);
                Mail::send('emails.signup', ['data' => $send], function ($message) use ($send) {
                        $message->from('leandro.b.03@gmail.com', 'Leandro');
                        $message->to($send['email'], $send['name'])->subject(Lang::get('emails.signup-title'));
                    });
                break;
            case 'update':
            case 'delete':
            default:
                # code...
                break;
        }

        return true;
    }

    /**
     * Get Month Hours
     *
     * @return array
     */
    public static function getTotalMonthHours ($month, $year, $workdays)
    {
        $total_month_hours = array();

        $date = '01/' . (isset($inputs['month']) ? $inputs['month'] : Carbon::now()->month) . '/' . (isset($inputs['year']) ? $inputs['year'] : Carbon::now()->year);
        $date = Carbon::createFromFormat('d/m/Y', $date);

        $total_month_in_hours = 0;

        $days = intval(date("t", strtotime($date->toDateString())));

        for ($i = 1; $i <= $days; $i++) {
            $day_of_the_week = $date->dayOfWeek;

            if ($day_of_the_week != 0 && $day_of_the_week != 6)
                $total_month_in_hours++;

            $date->addDay();
        }

        $total_month_in_hours = ($total_month_in_hours * 8) * 60;

        $seconds = '00';
        $hours = floor($total_month_in_hours / 60);
        $minutes = ($total_month_in_hours % 60);
        $month_hours = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

        $total_month_hours['month_hours'] = $month_hours;

        $total_work_month_in_hours = 0;

        foreach ($workdays as $day) {
            $day_in_minutes = 0;
            list($hour, $minute) = explode(':', $day->hours);
            $day_in_minutes += $hour * 60;
            $day_in_minutes += $minute;

            $nightly_in_minute = 0;
            list($hour, $minute) = explode(':', $day->nightly_hours);
            $nightly_in_minute += $hour * 60;
            $nightly_in_minute += $minute;

            $total_work_month_in_hours += $day_in_minutes + $nightly_in_minute;
        }

        $seconds = '00';
        $hours = floor($total_work_month_in_hours / 60);
        $minutes = ($total_work_month_in_hours % 60);
        $work_month_hours = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

        $total = 0;

        $total_month_hours['work_month_hours'] = $work_month_hours;

        if ($total_month_in_hours > $total_work_month_in_hours)
            $total += $total_month_in_hours - $total_work_month_in_hours;
        else
            $total += $total_work_month_in_hours - $total_month_in_hours;

        $seconds = '00';
        $hours = floor($total / 60);
        $minutes = ($total % 60);
        $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

        if ($total_month_in_hours > $total_work_month_in_hours){
            $total_month_hours['time_debit'] = '- ' . $time;
            $total_month_hours['time_credit'] = '00:00:00';
        }
        else {
            $total_month_hours['time_credit'] = $time;
            $total_month_hours['time_debit'] = '00:00:00';
        }

        return $total_month_hours;
    }

    /**
     * Get Month Hours
     *
     * @return array
     */
    public static function getInfo ($workday) {
        $info = array();

        $hours_day = 480;
        $info['hours_day'] = '08:00:00';

        $day_in_minutes = 0;
        list($hour, $minute) = explode(':', $workday->hours);
        $day_in_minutes += $hour * 60;
        $day_in_minutes += $minute;

        if ($hours_day > $day_in_minutes)
           $day_in_minutes = $hours_day - $day_in_minutes;
        else
            $day_in_minutes -= $hours_day;

        $seconds = '00';
        $hours = floor($day_in_minutes / 60);
        $minutes = ($day_in_minutes % 60);
        $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

        if ($hours_day > $day_in_minutes){
            $info['time_debit'] = '- ' . $time;
            $info['time_credit'] = '00:00:00';
        }
        else {
            $info['time_credit'] = $time;
            $info['time_debit'] = '00:00:00';
        }

        return $info;
    }

    /* Routes */

    /**
     * Confirm e-mail of the user
     *
     * @return Response
     */
    public function confirm(Request $request)
    {
        DB::beginTransaction();

        $inputs = $request->all();

        // Get the user request
        $user = User::findConfirmationCode($inputs['ce'])->get()->first();

        if ($user) {
            $user->status = 'A';
        } else {
            // Return the user view.
            return view('auth.confirm')->with('token', false);
        }

        try {
            if ($user->save()) {
                DB::commit();
                // Return the user view.
                return view('auth.confirm')->with('status', true);
            } else {
                DB::rollback();
                // Return the user view.
                return view('auth.confirm')->with('dbase', false);
            }
        } catch (Exception $e) {
            DB::rollback();
            // Return the user view.
            return view('auth.confirm')->with('dbase', false);
        }
    }
}
