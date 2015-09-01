<?php namespace App\Http\Controllers;

use DB;
use URL;
use Lang;
use Mail;
use App\User;
use App\Team;
use App\Proposal;
use PusherManager;
use Carbon\Carbon;
use App\ClientGroup;
use App\ProjectTime;
use App\UserSetting;
use App\ProposalType;
use App\Http\Requests;
use App\ProposalVersion;
use App\UserNotification;
use Illuminate\Http\Request;

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

    public function verifyCPFJSON(Request $request)
    {
        // Get the data receive from ajax.
        $inputs = $request->all();

        // Get user by e-mail
        $user = User::where('cpf', $inputs['cpf'])->get();

        $response = [];
        
        if ($user->count() > 0) {
            $response = array(
                'valid' => false,
                'message' => Lang::get('general.cpf-used')
            );
        } else {
            $response = array(
                'valid' => true
            );
        }

        return response()->json($response);
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
     * Save the user settings
     *
     * @return Json with message true or false
     */
    public function saveSettings(Request $request)
    {
        $inputs = $request->all();

        $settings = UserSetting::where('user_id', Auth::user()->id);

        if ($settings) {
            foreach ($inputs as $key => $value) {
                # code...
            }
        }

        return response()->json($client_group);
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
