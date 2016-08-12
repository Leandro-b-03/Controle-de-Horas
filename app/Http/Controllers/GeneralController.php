<?php

namespace App\Http\Controllers;

setlocale(LC_TIME, "Portuguese");
setlocale(LC_TIME, "Brazil");
setlocale(LC_TIME, 'ptb', 'pt_BR', 'portuguese-brazil', 'bra', 'brazil', 'pt_BR.utf-8', 'pt_BR.iso-8859-1', 'br', 'portuguese');

use DB;
use URL;
use Log;
use Auth;
use Lang;
use Mail;
use File;
// use Image;
use App\User;
use App\Team;
use App\Task;
use App\Role;
use App\Member;
use App\Journal;
use App\Project;
use App\UseCase;
use App\Holiday;
use App\Proposal;
use App\TaskTeam;
use App\UserRFID;
use App\UserTeam;
use App\Overtime;
use App\RoleUser;
use PusherManager;
use App\Timesheet;
use Carbon\Carbon;
use App\TimeEntry;
use App\ClientGroup;
use App\ProjectTime;
use App\UserSetting;
use App\TaskJournal;
use App\CustomField;
use App\ProposalType;
use App\Http\Requests;
use App\TimesheetTask;
use App\TaskPermission;
use App\UserOpenProject;
use App\ProposalVersion;
use App\UserLocalization;
use App\UserNotification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;
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

    /**
     * Verify the yuser e-mail if exists in the database
     *
     * @return message OK/NOK object
     */
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

        // Get user by cpf
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
        $inputs = $request->all();

        $tasks = DB::connection('openproject')->select(DB::raw('select distinct *, node.id, node.description, node.type_id, node.status_id, node.subject, group_concat(parent.subject order by parent.lft separator \'/ \' ) as path, (count(parent.lft) - 1) AS depth, (select from_id from relations where node.id = from_id and relation_type = \'precedes\') as from_id, (select to_id from relations where node.id = to_id and relation_type = \'precedes\') as to_id from work_packages as node inner join work_packages as parent on node.lft between parent.lft and parent.rgt and parent.project_id = :project_id where not exists (select 1 from `work_packages` as `wp2` where wp2.parent_id = node.id) and node.project_id = :project_id_2 and node.type_id != 2 and node.status_id != 11 group by node.lft, node.subject order by node.lft, node.start_date, from_id, to_id'), array('project_id' => $inputs['id'], 'project_id_2' => $inputs['id']));

        $order_tasks = array();

        $html = '';
        $parent = '';

        foreach ($tasks as $task) {
            $task_permission = TaskPermission::where('work_package_id', $task->id)->first();   
            
            $selected = '';

            if (isset($inputs['select'])) {
                if ($inputs['select'] == $task->subject)
                    $selected = 'selected="selected"';

                Log::debug($inputs['select']);
                Log::debug($task->subject);
            }

            if ($task_permission) {
                Log::debug($task_permission->enumeration_id != 0);
                if ($task_permission->enumeration_id != 0) {
                    $_parent = str_replace($task->subject, '', $task->path);
                    if ($_parent != $parent) {
                        $parent = $_parent;

                        if ($parent == '')
                            $html .= '</optgroup>';

                        $number_parent = count(explode('/', $_parent));

                        if ($number_parent > 1) {
                            $html .= '<optgroup label="' . $parent . '">';
                            $html .= '<option value="' . $task->id . '" data-type="' . $task->type_id . '" data-activity="' . $task_permission->enumeration_id . '"' . $selected . '>' . $task->subject . '</option>';
                            $parent_id[$task->parent_id] = array($task->parent_id, true);
                        }
                    } else {
                        $html .= '<option value="' . $task->id . '" data-type="' . $task->type_id . '" data-type="' . $task->type_id . '" data-activity="' . $task_permission->enumeration_id . '"' . $selected . '>' . $task->subject . '</option>';
                    }
                }
            }
        }
        
        return response()->json($html);
    }

    /**
     * Verify how many parents the task have.
     *
     * @param  int  $request
     * @return object array
     */
    protected function verifyParentTask($group_tasks, $parent_old, $task_id)
    {
        $_group_tasks = $group_tasks;

        $parent = DB::connection('openproject')->table('work_packages')->find($parent_old->parent_id);

        $parent_exists = false;


        if ($parent->parent_id) {
            $parent_exists = true;

            $_group_tasks[$parent->parent_id][$parent->id][] = array('name' => $parent->subject);

            $this->verifyParentTask($_group_tasks, $parent, $task_id);
        } else {
            $_group_tasks[$parent->root_id][] = array('name' => $parent->subject, 'task_id' => $task_id);

            
            return $_group_tasks;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $request
     * @
     */
    public function getTasksDay(Request $request)
    {
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
    public function getTasksEditDay(Request $request)
    {
        // Get all the inputs
        $inputs = $request->all();

        // Get all the task on that day or the day
        $workday = Timesheet::find($inputs['id']);
        $data['workday'] = $workday;

        // Get all the task on that day or the day
        $tasks = TimesheetTask::where('timesheet_id', $inputs['id'])->orderBy('id', 'DESC')->get();
        $data['tasks'] = $tasks;

        $user = User::find($workday->user_id);

        // Get the Openproject's user id
        $user_id = UserOpenProject::where('login', 'LIKE', $user->username . '@%')->orWhere('mail', 'LIKE', $user->username . '@%')->get()->first()->id;

        // Get all the Projects that the user is assigned off
        $user_projects = Member::select('project_id')->where('user_id', $user_id)->get()->toArray();

        // Get all the projects infos
        $projects = Project::whereIn('status', [1, 7])->whereIn('id', $user_projects)->get();
        $data['projects'] = $projects;

        return view('general.timeline-edit')->with('data', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $request
     * @
     */
    public function getAllNotifications(Request $request)
    {
        // Get all the inputs
        $inputs = $request->all();

        // Get all the task on that day or the day
        $notifications = UserNotification::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        $data['notifications'] = $notifications;

        return view('general.notification')->with('data', $data);
    }

    /**
     * Input the new line
     *
     * @return All time again
     */
    public function changeDay(Request $request)
    {
        $inputs = $request->all();

        $start_explode = explode(':', str_replace(' ', '', $inputs['start']));
        $lunch_start_explode = explode(':', str_replace(' ', '', $inputs['lunch_start']));
        $lunch_end_explode = explode(':', str_replace(' ', '', $inputs['lunch_end']));
        $end_explode = explode(':', str_replace(' ', '', $inputs['end']));
        $nightly_start_explode = explode(':', str_replace(' ', '', $inputs['nightly_start']));
        $nightly_end_explode = explode(':', str_replace(' ', '', $inputs['nightly_end']));

        $start = Carbon::createFromTime($start_explode[0], $start_explode[1], (array_key_exists(2, $start_explode) ? $start_explode[2] : '00'));
        $lunch_start = Carbon::createFromTime($lunch_start_explode[0], $lunch_start_explode[1], (array_key_exists(2, $lunch_start_explode) ? $lunch_start_explode[2] : '00'));
        $lunch_end = Carbon::createFromTime($lunch_end_explode[0], $lunch_end_explode[1], (array_key_exists(2, $lunch_end_explode) ? $lunch_end_explode[2] : '00'));
        $end = Carbon::createFromTime($end_explode[0], $end_explode[1], (array_key_exists(2, $end_explode) ? $end_explode[2] : '00'));
        $nightly_start = Carbon::createFromTime($nightly_start_explode[0], $nightly_start_explode[1], (array_key_exists(2, $nightly_start_explode) ? $nightly_start_explode[2] : '00'));
        $nightly_end = Carbon::createFromTime($nightly_end_explode[0], $nightly_end_explode[1], (array_key_exists(2, $nightly_end_explode) ? $nightly_end_explode[2] : '00'));

        $seconds = '00';

        $diffTime = $lunch_start->diffInMinutes(new Carbon($lunch_end));

        $lunch_in_minute = $diffTime;

        $hours = floor($diffTime / 60);
        $minutes = ($diffTime % 60);
        $tminutes = (float)($minutes / 60);
        $lunch_time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

        $diffTime = $nightly_start->diffInMinutes(new Carbon($nightly_end));

        $hours = floor($diffTime / 60);
        $minutes = ($diffTime % 60);
        $tminutes = (float)($minutes / 60);
        $nightly_time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

        $diffTime = $start->diffInMinutes(new Carbon($end));

        $diffTime -= $lunch_in_minute;

        $hours = floor($diffTime / 60);
        $minutes = ($diffTime % 60);
        $tminutes = (float)($minutes / 60);
        $day_time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

        try {
            DB::beginTransaction();

            if ($inputs['id'] == 'new'){
                $day = Carbon::createFromFormat('d/m/Y', $inputs['date'])->toDateString();

                $date = Timesheet::where('user_id', $inputs['user_id'])->where('workday', $day)->get();
                
                if (count($date) == 0) {
                    $workday['user_id'] = $inputs['user_id'];
                    $workday['workday'] = $day;
                    $workday['start'] = $start->toTimeString();
                    $workday['lunch_start'] = $lunch_start->toTimeString();
                    $workday['lunch_end'] = $lunch_end->toTimeString();
                    $workday['lunch_hours'] = $lunch_time;
                    $workday['end'] = $end->toTimeString();
                    $workday['hours'] = $day_time;
                    $workday['nightly_start'] = $nightly_start->toTimeString();
                    $workday['nightly_end'] = $nightly_end->toTimeString();
                    $workday['nightly_hours'] = $nightly_time;

                    $workday = Timesheet::create( $workday );

                    if ($workday) {
                        DB::commit();
                        return 'true';
                    } else {
                        Log::error('$workday->save(): Error trying to save the workday');
                        DB::rollback();
                        return 'false';
                    }
                } else {
                    return 'false';
                }
            } else {
                $workday = Timesheet::find($inputs['id']);

                $workday->start = $start->toTimeString();
                $workday->lunch_start = $lunch_start->toTimeString();
                $workday->lunch_end = $lunch_end->toTimeString();
                $workday->lunch_hours = $lunch_time;
                $workday->end = $end->toTimeString();
                $workday->hours = $day_time;
                $workday->nightly_start = $nightly_start->toTimeString();
                $workday->nightly_end = $nightly_end->toTimeString();
                $workday->nightly_hours = $nightly_time;


                if ($workday->save()) {
                    DB::commit();
                    return 'true';
                } else {
                    Log::error('$workday->save(): Error trying to save the workday');
                    DB::rollback();
                    return 'false';
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            DB::rollback();
            return 'false';
        }
    }

    /**
     * Input the new task
     *
     * @return All time again
     */
    public function changeTaskDay(Request $request)
    {
        $inputs = $request->all();

        die(Log::debug($inputs));

        $start_explode = explode(':', str_replace(' ', '', $inputs['start']));
        $end_explode = explode(':', str_replace(' ', '', $inputs['end']));

        $start = Carbon::createFromTime($start_explode[0], $start_explode[1], (array_key_exists(2, $start_explode) ? $start_explode[2] : '00'));
        $end = Carbon::createFromTime($lunch_start_explode[0], $lunch_start_explode[1], (array_key_exists(2, $end_explode) ? $lunch_start_explode[2] : '00'));

        $seconds = '00';

        $diffTime = $start->diffInMinutes($end);

        $hours = floor($diffTime / 60);
        $minutes = ($diffTime % 60);
        $tminutes = (float)($minutes / 60);
        $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

        $user_open_project = UserOpenProject::where('login', 'LIKE', Auth::user()->getEloquent()->username . '@%')->orWhere('mail', 'LIKE', Auth::user()->getEloquent()->username . '@%')->get()->first();

        $work_package = Task::find($timesheet_task->work_package_id);

        try {
            $time_entry = array(
                'project_id' => $timesheet_task->project_id,
                'user_id' => $user_open_project->id,
                'work_package_id' => $timesheet_task->work_package_id,
                'hours' => (float) $hours + $tminutes,
                'comments' => 'Inserido pelo Timesheet',
                'activity_id' => $inputs['activity'],
                'spent_on' => $start->toDateString(),
                'tyear' => $start->year,
                'tmonth' => $start->month,
                'tweek' => $start->weekOfYear,
                'created_on' => Carbon::now(),
                'update_on' => Carbon::now()
                );

            $time_entry = TimeEntry::create ($time_entry);

            if ($timesheet_task->save()) {
                DB::commit();
                Log::info($timesheet_task);
            } else {
                DB::rollback();
                Log::error($e);
                Log::error($time_entry);
                Log::error($work_package);
                Log::error($timesheet_task);

                return response()->json(array('error' => Lang::get('general.error')));
            }

            $timesheet_task->hours = $time;

            if ($timesheet_task->save()) {
                DB::commit();

                if ($work_package->type_id == 1) {
                    $status = 11;

                    if (isset($inputs['pause']))
                        $status = 14;

                    if (isset($inputs['fail']))
                        $status = 12;

                    $work_package->status_id = $status;
                } else {
                    $custom_fields = CustomField::where('customized_id', $work_package->id)->where('custom_field_id', 39)->get();

                    if (!$custom_fields) {
                        $custom_fields = array(
                            array (
                                'customized_type' => 'WorkPackage',
                                'customized_id' => $work_package->id,
                                'custom_field_id' => 39,
                                'value' => $user_open_project->lastname . ' ' . $user_open_project->lastname
                                )
                            );

                        $custom_fields = CustomField::create( $custom_fields );

                        if ($custom_fields) {
                            DB::commit();
                        } else {
                            DB::rollback();
                            Log::error($e);
                            Log::error($custom_field);
                            Log::error($work_package);
                            Log::error($timesheet_task);

                            return response()->json(array('error' => Lang::get('general.error')));
                        }

                        $custom_fields = CustomField::where('customized_id', $work_package->id)->whereIn('custom_field_id', [38, 40])->get();

                        if ($custom_field->custom_field_id == 38) {
                            $custom_field->value = str_replace($user_open_project->lastname . ' ' . $user_open_project->lastname, '', str_replace(', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname, '', ($custom_field->value)));
                        } else if ($custom_field->custom_field_id == 40) {
                            $working_worked = json_decode($custom_field->value);

                            $key = array_search($custom_field->id, $working_worked['worked']);
                            unset($working_worked['working'][$key]);

                            $working_worked['worked'][] = $custom_field->id;

                            $custom_field->values = json_encode($working_worked);
                        }

                        if ($custom_field->save()) {
                            DB::commit();
                        } else {
                            DB::rollback();
                            Log::error($e);
                            Log::error($custom_field);
                            Log::error($work_package);
                            Log::error($timesheet_task);

                            return response()->json(array('error' => Lang::get('general.error')));
                        }
                    } else {
                        $custom_fields = CustomField::where('customized_id', $work_package->id)->whereIn('custom_field_id', [38, 39, 40])->get();

                        foreach ($custom_fields as $custom_field) {
                            if ($custom_field->custom_field_id == 38) {
                                $custom_field->value = str_replace($user_open_project->lastname . ' ' . $user_open_project->lastname, '', str_replace(', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname, '', ($custom_field->value)));
                            } else if ($custom_field->custom_field_id == 39) {
                                $custom_field->value = $custom_field->value . ', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname;
                            } else if ($custom_field->custom_field_id == 40) {
                                $working_worked = json_decode($custom_field->value);

                                $key = array_search($custom_field->id, $working_worked['worked']);
                                unset($working_worked['working'][$key]);

                                $working_worked['worked'][] = $custom_field->id;

                                $custom_field->values = json_encode($working_worked);
                            }

                            if ($custom_field->save()) {
                                DB::commit();
                            } else {
                                DB::rollback();
                                Log::error($e);
                                Log::error($custom_field);
                                Log::error($work_package);
                                Log::error($timesheet_task);

                                return response()->json(array('error' => Lang::get('general.error')));
                            }
                        }
                    }

                    $use_cases = array(
                        'timesheet_task_id' => $timesheet_task->id,
                        'ok' => $inputs['ok'],
                        'nok' => $inputs['nok'],
                        'impacted' => $inputs['impacted'],
                        'cancelled' => $inputs['cancelled']
                        );

                    $use_cases = UseCase::create ($use_cases);

                    if ($use_cases) {
                        DB::commit();
                    } else {
                        DB::rollback();
                        Log::error($e);
                        Log::error($use_cases);
                        Log::error($work_package);
                        Log::error($timesheet_task);

                        return response()->json(array('error' => Lang::get('general.error')));
                    }
                }

                if ($work_package->save()) {
                    DB::commit();
                    $this->journal($timesheet_task->work_package_id, 'WorkPackage', 'work_packages');

                    $this->notify($inputs, $timesheet_task->project_id);

                    return response()->json($this->line($timesheet_task, $work_package->type_id));
                } else {
                    DB::rollback();
                    Log::error($e);
                    Log::error($work_package);
                    Log::error($timesheet_task);

                    return response()->json(array('error' => Lang::get('general.error')));
                }
            } else {
                DB::rollback();
                Log::error($e);
                Log::error($work_package);
                Log::error($timesheet_task);

                return response()->json(array('error' => Lang::get('general.error')));
            }
        } catch (Exception $e) {
            Log::error($e);
            
        }
    }

    /**
     * Get all OK, NOK, Impacted and Cancelled tasks
     *
     * @return All time again
     */
    public function getUseCase(Request $request)
    {
        $inputs = $request->all();

        $use_cases = UseCase::where('timesheet_task_id', $inputs['id'])->get()->first();

        if ($use_cases)
            return $use_cases;
        else
            return null;
    }

    /**
     * Send request to all managers in the base
     *
     * @return All time again
     */
    public function RequestChangeDay(Request $request)
    {
        try {
            $inputs = $request->all();

            $managers_ids = RoleUser::where('role_id', Role::where('name', 'Gerente')->get()->first()->id)->get();

            $workday = Timesheet::find($inputs['workday_id']);

            foreach ($managers_ids as $manager_id) {
                $notification = array(
                    'user_id' => $manager_id->user_id,
                    'message' => htmlentities(Lang::get('timesheets.message-send_request', array('name' => Auth::user()->first_name, 'start' => $inputs['start'], 'lunch_start' => $inputs['lunch_start'], 'lunch_end' => $inputs['lunch_end'], 'end' => $inputs['end']))),
                    'faicon' => 'clock-o'
                    );
                $this->createNotification($manager_id->user_id, $notification);
            }

            $data['name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $data['email'] = Auth::user()->getEloquent()->email;
            $data['start'] = ($inputs['start'] != "" ? $inputs['start'] : '---');
            $data['lunch_start'] = ($inputs['lunch_start'] != "" ? $inputs['lunch_start'] : '---');
            $data['lunch_end'] = ($inputs['lunch_end'] != "" ? $inputs['lunch_end'] : '---');
            $data['end'] = ($inputs['end'] != "" ? $inputs['end'] : '---');
            $day = explode('-', $workday->workday);
            $data['day'] = $day[2] . '/' . $day[1] . '/' . $day[0];

            foreach ($managers_ids as $manager_id) {
                $manager = User::find($manager_id->user_id);

                $data['mail_send'] = $manager->email;
                $data['mail_name'] = $manager->first_name . ' ' . $manager_id->last_name;
                $this->mail($data, 'request');
            }

            $notification = array(
                'user_id' => Auth::user()->id,
                'message' => Lang::get('general.notification-request_success'),
                'faicon' => 'check-circle-o'
                );
            $this->createNotification(Auth::user()->id, $notification);

            return response()->json(array('success' => Lang::get('general.success')));
        } catch (Exception $e) {
            $notification = array(
                'user_id' => Auth::user()->id,
                'message' => Lang::get('general.notification-error'),
                'faicon' => 'times-circle-o'
                );
            $this->createNotification(Auth::user()->id, $notification);

            return response()->json(array('error' => Lang::get('general.error')));
        }
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
    public function saveImages(Request $request)
    {
        // Get all the inputs
        $inputs = $request->all();

        $destinationPath = public_path() . '/images/avatar/upload/';

        $file = str_replace('data:image/png;base64,', '', $inputs['image']);
        $img = str_replace(' ', '+', $file);
        $data = base64_decode($img);
        $filename = date('ymdhis') . '_croppedImage' . ".png";

        $returnData = 'images/avatar/upload/normal/' . $filename;
        $file = $destinationPath . 'normal/' . $filename;

        if (!is_dir($destinationPath)) {
            $result = File::makeDirectory($destinationPath, 0775, true);

            File::makeDirectory($destinationPath . 'normal', 0775, true);
            File::makeDirectory($destinationPath . '500x500', 0775, true);
            File::makeDirectory($destinationPath . '240x240', 0775, true);
            File::makeDirectory($destinationPath . '100x100', 0775, true);
        }

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
            return '../../' . str_replace('normal', '500x500', $returnData);
        else {
            return array(
                'valid' => false,
                'message' => Lang::get('general.cpf-wrong')
                );
        }
    }


    /**
     * Get user by rfid
     *
     * @return string with an rfid
     */
    public function rfidLogin(Request $request)
    {
        // Get all the inputs
        $inputs = $request->all();

        $rfid = UserRFID::where('rfid_code', $inputs['rfid'])->get()->first();

        $receive = array();

        if ($rfid) {
            $user = User::find($rfid->user_id);

            $today = new Carbon();

            // Get the workday
            $workday = Timesheet::where('user_id', $user->id)->where('workday', $today->toDateString())->orderBy('workday', 'desc')->get()->first();

            try {
                DB::beginTransaction();

                if (!$workday) {
                    $workday = array(
                        'user_id' => $user->id,
                        'workday' => $today->toDateString(),
                        'hours' => '00:00:00',
                        'start' => $today->toTimeString()
                        );

                    $workday = Timesheet::create($workday);

                    if ($workday) {
                        DB::commit();
                    }

                    $receive = array("status" => "200",
                        "rfid" => $inputs['rfid'],
                        "user" => $user->first_name,
                        "entrance" => $workday->start);
                } else {
                    $seconds = "00";

                    $diffTime = $today->diffInMinutes(new Carbon($workday->updated_at));

                    if ($diffTime < 1) {
                        $receive = array("status" => "200",
                            "rfid" => $inputs['rfid'],
                            "diffTime" => $diffTime,
                            "message" => "Already checked");
                        
                        return response()->json($receive);
                    }

                    if ($workday->lunch_start == "00:00:00") {
                        if (($today->hour >= 10 && $today->minute >= 30) && $today->hour <= 15) {
                            $workday->lunch_start = $today->toTimeString();

                            $timesheet_task = TimesheetTask::where('timesheet_id', $workday->id)->where('end', '00:00:00')->get()->first();

                            if ($timesheet_task) {
                                $timesheet_task->end = $today->toTimeString();

                                $seconds = '00';

                                $start = new Carbon($timesheet_task->start);

                                $diffTime = $start->diffInMinutes(new Carbon($timesheet_task->end));

                                $hours = floor($diffTime / 60);
                                $minutes = ($diffTime % 60);
                                $tminutes = (float)($minutes / 60);
                                $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

                                $user_open_project = UserOpenProject::where('login', 'LIKE', $user->username . '@%')->orWhere('mail', 'LIKE', $user->username . '@%')->get()->first();

                                $work_package = Task::find($timesheet_task->work_package_id);

                                $time_entry = array(
                                    'project_id' => $timesheet_task->project_id,
                                    'user_id' => $user_open_project->id,
                                    'work_package_id' => $timesheet_task->work_package_id,
                                    'hours' => (float) $hours + $tminutes,
                                    'comments' => 'Inserido pelo Timesheet',
                                    'activity_id' => TaskPermission::where('work_package_id', $timesheet_task->work_package_id)->get()->first()->enumeration_id,
                                    'spent_on' => $start->toDateString(),
                                    'tyear' => $start->year,
                                    'tmonth' => $start->month,
                                    'tweek' => $start->weekOfYear,
                                    'created_on' => Carbon::now(),
                                    'update_on' => Carbon::now()
                                    );

                                $time_entry = TimeEntry::create ($time_entry);

                                if ($timesheet_task->save()) {
                                    DB::commit();
                                    Log::info($timesheet_task);
                                } else {
                                    DB::rollback();
                                    Log::error($e);
                                    Log::error($time_entry);
                                    Log::error($work_package);
                                    Log::error($timesheet_task);

                                    $receive = array('error' => Lang::get('general.error'));
                                }

                                $timesheet_task->hours = $time;

                                if ($timesheet_task->save()) {
                                    DB::commit();

                                    if ($work_package->type_id == 1) {
                                        $status = 14;

                                        $work_package->status_id = $status;
                                    } else {
                                        $custom_fields = CustomField::where('customized_id', $work_package->id)->where('custom_field_id', 39)->get();

                                        if (!$custom_fields) {
                                            $custom_fields = array(
                                                array (
                                                    'customized_type' => 'WorkPackage',
                                                    'customized_id' => $work_package->id,
                                                    'custom_field_id' => 39,
                                                    'value' => $user_open_project->lastname . ' ' . $user_open_project->lastname
                                                    )
                                                );

                                            $custom_fields = CustomField::create( $custom_fields );

                                            if ($custom_fields) {
                                                DB::commit();
                                            } else {
                                                DB::rollback();
                                                Log::error($e);
                                                Log::error($custom_field);
                                                Log::error($work_package);
                                                Log::error($timesheet_task);

                                                $receive = array('error' => Lang::get('general.error'));
                                            }

                                            $custom_fields = CustomField::where('customized_id', $work_package->id)->whereIn('custom_field_id', [38, 40])->get();

                                            if ($custom_field->custom_field_id == 38) {
                                                $custom_field->value = str_replace($user_open_project->lastname . ' ' . $user_open_project->lastname, '', str_replace(', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname, '', ($custom_field->value)));
                                            } else if ($custom_field->custom_field_id == 40) {
                                                $working_worked = json_decode($custom_field->value);

                                                $key = array_search($custom_field->id, $working_worked['worked']);
                                                unset($working_worked['working'][$key]);

                                                $working_worked['worked'][] = $custom_field->id;

                                                $custom_field->values = json_encode($working_worked);
                                            }

                                            if ($custom_field->save()) {
                                                DB::commit();
                                            } else {
                                                DB::rollback();
                                                Log::error($e);
                                                Log::error($custom_field);
                                                Log::error($work_package);
                                                Log::error($timesheet_task);

                                                $receive = array('error' => Lang::get('general.error'));
                                            }
                                        } else {
                                            $custom_fields = CustomField::where('customized_id', $work_package->id)->whereIn('custom_field_id', [38, 39, 40])->get();

                                            foreach ($custom_fields as $custom_field) {
                                                if ($custom_field->custom_field_id == 38) {
                                                    $custom_field->value = str_replace($user_open_project->lastname . ' ' . $user_open_project->lastname, '', str_replace(', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname, '', ($custom_field->value)));
                                                } else if ($custom_field->custom_field_id == 39) {
                                                    $custom_field->value = $custom_field->value . ', ' . $user_open_project->lastname . ' ' . $user_open_project->lastname;
                                                } else if ($custom_field->custom_field_id == 40) {
                                                    $working_worked = json_decode($custom_field->value);

                                                    $key = array_search($custom_field->id, $working_worked['worked']);
                                                    unset($working_worked['working'][$key]);

                                                    $working_worked['worked'][] = $custom_field->id;

                                                    $custom_field->values = json_encode($working_worked);
                                                }

                                                if ($custom_field->save()) {
                                                    DB::commit();
                                                } else {
                                                    DB::rollback();
                                                    Log::error($e);
                                                    Log::error($custom_field);
                                                    Log::error($work_package);
                                                    Log::error($timesheet_task);

                                                    $receive = array('error' => Lang::get('general.error'));
                                                }
                                            }
                                        }

                                        $use_cases = array(
                                            'timesheet_task_id' => $timesheet_task->id,
                                            'ok' => 0,
                                            'nok' => 0,
                                            'impacted' => 0,
                                            'cancelled' => 0
                                            );

                                        $use_cases = UseCase::create ($use_cases);

                                        if ($use_cases) {
                                            DB::commit();
                                        } else {
                                            DB::rollback();
                                            Log::error($e);
                                            Log::error($use_cases);
                                            Log::error($work_package);
                                            Log::error($timesheet_task);

                                            $receive = array('error' => Lang::get('general.error'));
                                        }
                                    }

                                    if ($work_package->save()) {
                                        DB::commit();
                                        //$this->journal($timesheet_task->work_package_id, 'WorkPackage', 'work_packages');

                                        // $this->notify($inputs, $timesheet_task->project_id);
                                    } else {
                                        DB::rollback();
                                        Log::error($e);
                                        Log::error($work_package);
                                        Log::error($timesheet_task);

                                        $receive = array('error' => Lang::get('general.error'));
                                    }
                                } else {
                                    DB::rollback();
                                    Log::error($e);
                                    Log::error($work_package);
                                    Log::error($timesheet_task);

                                    $receive = array('error' => Lang::get('general.error'));
                                }
                            }
                        } else {
                            if ($diffTime < 1) {
                                $receive = array("status" => "200",
                                    "rfid" => $inputs['rfid'],
                                    "diffTime" => $diffTime,
                                    "lunch_time" => 'lunch_start',
                                    "message" => "Already checked");
                                
                                return response()->json($receive);
                            }
                        }
                    } else if ($workday->lunch_end == "00:00:00") {
                        if (($today->hour >= 10 && $today->minute >= 30) && $today->hour <= 15) {
                            $workday->lunch_end = $today->toTimeString();

                            $lunch_start = new Carbon($workday->lunch_start);
                            $diffTime = $lunch_start->diffInMinutes(new Carbon($workday->lunch_end));

                            $lunch_in_minute = $diffTime;

                            $hours = floor($diffTime / 60);
                            $minutes = ($diffTime % 60);
                            $tminutes = (float)($minutes / 60);
                            $lunch_time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;
                            
                            $workday->lunch_hours = $lunch_time;
                        } else {
                            if ($diffTime < 1) {
                                $receive = array("status" => "200",
                                    "rfid" => $inputs['rfid'],
                                    "diffTime" => $diffTime,
                                    "lunch_time" => 'lunch_end',
                                    "message" => "Already checked");
                                
                                return response()->json($receive);
                            }
                        }
                    } else if ($workday->end == "00:00:00") {
                        if (($today->hour >= 16 && $today->minute >= 30) && $today->hour <= 19) {
                            $workday->end = $today->toTimeString();
                            
                            $lunch_in_minute = 0;
                            list($hour, $minute) = explode(':', $workday->lunch_hours);
                            $lunch_in_minute += $hour * 60;
                            $lunch_in_minute += $minute;

                            $start = new Carbon($workday->start);
                            $diffTime = $start->diffInMinutes(new Carbon($workday->end));
                            $diffTime -= $lunch_in_minute;

                            $hours = floor($diffTime / 60);
                            $minutes = ($diffTime % 60);
                            $tminutes = (float)($minutes / 60);
                            $day_time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;
                            $workday->hours = $day_time;

                            $overtime = Overtime::where('user_id', $user->id)->get()->first();

                            if (!$overtime) {
                                $overtime = array (
                                    'user_id' => $this->user_id,
                                    'hours'   => '00:00:00'
                                    );


                                $overtime = Overtime::create ($overtime);

                                if (!$overtime) {
                                    DB::rollback();
                                    $import->status = 0;
                                    $import->error = $this->createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed');
                                    
                                    if ($import->save())
                                        DB::commit();
                                    
                                    $receive = array('return', $this->createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
                                }
                            }
                            
                            $overtime_in_minute = 0;

                            list($hour, $minute) = explode(':', $overtime->hours);
                            $overtime_in_minute += $hour * 60;
                            $overtime_in_minute += $minute;

                            $date = new Carbon($workday['workday']);
                            $day_of_the_week = $date->dayOfWeek;

                            $is_holiday = Holiday::where('day',$date->day)->where('month',$date->month)->get()->first();

                            $bussiness_day = 0;

                            if ($day_of_the_week != 0 && $day_of_the_week != 6 && !$is_holiday)
                                $bussiness_day = 480;

                            $total_time = $overtime_in_minute + $nightly_in_minute + ($day_in_minute - $bussiness_day);

                            $hours = floor($total_time / 60);
                            $minutes = ($total_time % 60);
                            $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

                            $overtime->hours = $time;

                            if (!$overtime->save()) {
                                DB::rollback();
                                $import->status = 0;
                                $import->error = $this->createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed');
                                
                                if ($import->save())
                                    DB::commit();

                                $receive = array('return', $this->createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
                            }

                            $workday->status = "P";
                        } else {
                            if ($diffTime < 1) {
                                $receive = array("status" => "200",
                                    "rfid" => $inputs['rfid'],
                                    "diffTime" => $diffTime,
                                    "message" => "Already checked");

                                return response()->json($receive);
                            }
                        }
                    }


                    if ($workday->save()) {
                        DB::commit();
                    }

                    $receive = array("status" => "200",
                        "rfid" => $inputs['rfid'],
                        "user" => $user->first_name,
                        "entrance" => $workday->start,
                        "lunch_start" => $workday->lunch_start,
                        "lunch_end" => $workday->lunch_end,
                        "exit" => $workday->end);
                }
            } catch (Exception $e) {
                Log::error($e);
                DB::rollback();
                $data['error'] =  Lang::get('general.error-day');

                $receive = array("status" => "500",
                    "rfid" => $inputs['rfid']);
            }
        } else {
            $receive = array("status" => "500",
                "rfid" => $inputs['rfid'],
                "message" => "RFID not found");
        }

        return response()->json($receive);
    }

    /**
    * Test mail
    *
    * @return Message OK/NOK
    */
    public function testMail(Request $request) {
        $inputs = $request->all();

        $data['email'] = $inputs['email'];

        d($this->mail($data, 'test'));
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
            PusherManager::trigger('presence-user-' . Auth::user()->id, 'new_notification', $notification_fail);
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

            $send['company']     = 'SVLabs';
            $send['email']       = $data->email;
            $send['year']        = Carbon::now()->format('Y');
            $send['name']        = $data->first_name;
            $send['url']         = URL::to('auth/confirm?ce=' . $data->confirmation_code);
            Mail::send('emails.signup', ['data' => $send], function ($message) use ($send) {
                $message->from('postmaster@svlabs.com.br', 'SVLabs | No Reply');
                $message->to($send['email'], $send['name'])->subject(Lang::get('emails.signup-title'));
            });
            break;
            case 'update':
            break;
            case 'delete':
            break;
            case 'notification':
            break;
            case 'request':
            $send = [];

            $send['company']     = 'SVLabs';
            $send['email']       = $data['email'];
            $send['year']        = Carbon::now()->format('Y');
            $send['name']        = $data['name'];
            $send['start']       = $data['start'];
            $send['lunch_start'] = $data['lunch_start'];
            $send['lunch_end']   = $data['lunch_end'];
            $send['end']         = $data['end'];
            $send['day']         = $data['day'];
            $send['mail_send']   = $data['mail_send'];
            $send['mail_name']   = $data['mail_name'];
            $send['user_id']     = Auth::user()->id;
            $send['subject']     = Lang::get('emails.request-title');
            Mail::send('emails.request', ['data' => $send], function ($message) use ($send) {
                $message->from('postmaster@svlabs.com.br', 'SVLabs | No Reply');
                $message->to($send['mail_send'], $send['mail_name'])->subject($send['subject']);
            });
            break;
            case 'test':
            $send = [];

            $send['email'] = $data['email'];
            d(Mail::send('emails.teste', ['data' => $send], function ($message) use ($send) {
                $message->from('postmaster@svlabs.com.br', 'Teste');
                $message->to($send['email'], "Teste")->subject(Lang::get('emails.signup-title'));
            }));
            break;
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
    public static function getInfo ($workday)
    {
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
            Log::error($e);
            DB::rollback();
            // Return the user view.
            return view('auth.confirm')->with('dbase', false);
        }
    }
}
