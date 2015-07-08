<?php namespace App\Http\Controllers;

use Lang;
use App\User;
use App\Http\Requests;
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

    /**
     * Generates an array with parameters to messages
     *
     * @return Array with message
     */
    public function createMessageJSON(Request $request)
    {
        // Get the data receive from ajax.
        $inputs = $request->all();

        return response()->json($this->createMessage($inputs['type'], $inputs['name'], $inputs['kind'], (isset($inputs['message']) ? $inputs['message'] : '')));
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

}
