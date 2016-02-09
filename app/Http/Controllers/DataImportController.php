<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Lang;
use Excel;
use App\Task;
use App\Import;
use App\Project;
use App\Holiday;
use App\Overtime;
use App\Timesheet;
use Carbon\Carbon;
use App\CustomField;
use App\Http\Requests;
use App\UserOpenProject;
use App\Http\Controllers\Controller;

class DataImportController extends Controller
{
    private $controller_name = 'DataImporterController';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the imports done
        $imports = Import::paginate(20);
        $data['imports'] = $imports;

        // Return the imports view.
        return view('import.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Get all projects
        $projects = Project::all();
        $data['projects'] = $projects;

        // Get all projects
        $teams = Team::all();
        $data['teams'] = $teams;

        // Return the import view.
        return view('import.create')->with('data', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        DB::beginTransaction();

        $import = array(
            'file' => urldecode(str_replace('..\\', '', str_replace('/', '\\', $inputs['xlsx']))),
            'user_id' => Auth::user()->id,
            'status' => 1,
            'error' => 'Sem erros'
        );

        $import = Import::create ( $import );

        if ($import) {
            DB::commit();
        }

        if ($inputs['type'] == 'WP') {
            try {
                if($inputs) {
                    ini_set('memory_limit','1024M');
                    ini_set('MAX_EXECUTION_TIME', -1);
                    set_time_limit(0);
                    $file = urldecode(str_replace('..\\', '', str_replace('/', '\\', $inputs['xlsx'])));

                    $this->data = [];

                    Excel::load($file, function($reader) {
                        // Getting all results
                        $results = $reader->get();

                        foreach ($results as $sheet) {
                            $i = 0;
                            foreach ($sheet as $row) {
                                if ($sheet->getTitle() == 'Projetos' || $sheet->getTitle() == 'Projeto') {
                                    $this->data['sheets'][$sheet->getTitle()][$i]['propostaprojeto'] = $row->propostaprojeto;

                                    if ($row->op == 'S')
                                        $this->data['sheets'][$sheet->getTitle()][$i]['id_op'] = $row->id_op;
                                    else
                                        $this->data['sheets'][$sheet->getTitle()][$i]['id_op'] = '00';
                                } else {
                                    foreach ($row as $index => $value) {
                                        $this->data['sheets'][$sheet->getTitle()][$i][$index] = $value;
                                    }
                                }

                                $i++;
                            }
                        }
                    });

                    $title_type = null;

                    foreach ($this->data['sheets'] as $title => $sheet) {
                        if ($title == 'Projetos' || $title == 'Projeto') {
                            $title_type = $title;
                        }

                        if ($title != 'Projetos' && $title != 'Projeto') {
                            foreach ($sheet as $row) {
                                $project = null;
                                if ($title_type == 'Projetos') {
                                    $key = array_search($row['propostaprojeto'], array_column($this->data['sheets']['Projetos'], 'propostaprojeto'));
                                    $project = $this->data['sheets']['Projetos'][$key]['id_op'];
                                } else {
                                    $key = array_search($row['propostaprojeto'], $this->data['sheets']['Projeto']);
                                    $project = $this->data['sheets']['Projetos'][$key]['id_op'];
                                }

                                $front = null;
                                $subfront = null;

                                if (isset($row['frente'])) {
                                    $front = Task::where('subject', $row['frente'])->where('project_id', $project)->where('type_id', 3)->get()->first();

                                    if (!$front) {
                                        $front = array(
                                            'type_id' => 3,
                                            'project_id' => $project,
                                            'subject' => $row['frente'],
                                            'description' => $row['frente'],
                                            'status_id' => 1,
                                            'author_id' => 1,
                                            'priority_id' => 8,
                                            'lock_version' => 1,
                                            'lft' => 1,
                                            'rgt' => 2,
                                            'position' => 1
                                        );

                                        $front = Task::create( $front );

                                        if ($front) {
                                            $front->root_id = $front->id;

                                            if ($front->save()) {
                                                DB::commit();
                                            } else {
                                                DB::rolback();
                                            }
                                        } else {
                                            DB::rolback();
                                        }
                                    }
                                }

                                if (isset($row['subfrente'])) {
                                    $subfront = Task::where('subject', $row['subfrente'])->where('project_id', $project)->where('type_id', 4)->get()->first();

                                    if (!$subfront) {
                                        $subfront = array(
                                            'type_id' => 4,
                                            'project_id' => $project,
                                            'subject' => $row['subfrente'],
                                            'description' => $row['subfrente'],
                                            'status_id' => 1,
                                            'author_id' => 1,
                                            'priority_id' => 8,
                                            'lock_version' => 1,
                                            'parent_id' => $front->id,
                                            'root_id' => $front->id,
                                            'lft' => 1,
                                            'rgt' => 2,
                                            'position' => 1
                                        );

                                        $subfront = Task::create( $subfront );

                                        if ($subfront) {
                                            if ($subfront->save()) {
                                                DB::commit();
                                            } else {
                                                DB::rolback();
                                            }
                                        } else {
                                            DB::rolback();
                                        }
                                    }
                                }

                                $name = explode(' ', $row['analista_executor']);

                                $user = UserOpenProject::where('firstname', $name[0])->where('lastname', 'like', '%' . $name[count($name) - 1])->get()->first();

                                $task = array(
                                    'type_id' => 1,
                                    'project_id' => $project,
                                    'subject' => (isset($row['caso_de_teste'])) ? $row['caso_de_teste'] : 'Não possui nome',
                                    'description' => (isset($row['caso_de_teste'])) ? $row['caso_de_teste'] : 'Não possui nome',
                                    'status_id' => 1,
                                    'assigned_to_id' => ($user != null) ? $user->id : null,
                                    'author_id' => 1,
                                    'priority_id' => 8,
                                    'lock_version' => 1,
                                    'parent_id' => ($subfront) ? $subfront->id : null,
                                    'root_id' => ($front) ? $front->id : null,
                                    'lft' => 1,
                                    'rgt' => 2,
                                    'position' => 1
                                );

                                $task = Task::create( $task );

                                if ($task) {
                                    if ($front == null){
                                        $task->root_id = $task->id;

                                        if ($task->save()) {
                                            DB::commit();
                                        } else {
                                            DB::rolback();
                                        }
                                    } else {
                                        DB::commit();
                                    }
                                } else {
                                    DB::rolback();
                                }

                                $custom_fields['pre_condicao'] = array(
                                    'customized_type' => 'WorkPackage',
                                    'customized_id' => $task->id,
                                    'custom_field_id' => 10,
                                    'value' => $row['pre_condicao']
                                );

                                $custom_fields['procedimento'] = array(
                                    'customized_type' => 'WorkPackage',
                                    'customized_id' => $task->id,
                                    'custom_field_id' => 11,
                                    'value' => $row['procedimento']
                                );

                                $custom_fields['resultado_esperado'] = array(
                                    'customized_type' => 'WorkPackage',
                                    'customized_id' => $task->id,
                                    'custom_field_id' => 12,
                                    'value' => $row['resultado_esperado']
                                );

                                $custom_fields['evidencias_chave'] = array(
                                    'customized_type' => 'WorkPackage',
                                    'customized_id' => $task->id,
                                    'custom_field_id' => 13,
                                    'value' => $row['evidencias_chave']
                                );

                                $custom_fields['resultado_obtido'] = array(
                                    'customized_type' => 'WorkPackage',
                                    'customized_id' => $task->id,
                                    'custom_field_id' => 14,
                                    'value' => $row['resultado_obtido']
                                );

                                $custom_fields['mantis'] = array(
                                    'customized_type' => 'WorkPackage',
                                    'customized_id' => $task->id,
                                    'custom_field_id' => 16,
                                    'value' => $row['mantis']
                                );

                                if ($row['wsdl'] != null) {
                                    $custom_fields['wsdl'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 20,
                                        'value' => $row['wsdl']
                                    );

                                    $custom_fields['servico'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 21,
                                        'value' => $row['servico']
                                    );

                                    $custom_fields['parametros'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 22,
                                        'value' => $row['parametros']
                                    );

                                    $custom_fields['origem'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 23,
                                        'value' => $row['origem']
                                    );

                                    $custom_fields['destino_1'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 24,
                                        'value' => $row['destino_1']
                                    );

                                    $custom_fields['destino_2'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 25,
                                        'value' => $row['destino_2']
                                    );

                                    $custom_fields['nome_do_servico_operacao'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 26,
                                        'value' => $row['nome_do_servico_operacao']
                                    );

                                    $custom_fields['atributos_do_servico_envio'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 27,
                                        'value' => $row['atributos_do_servico_envio']
                                    );

                                    $custom_fields['atributos_do_servico_retorno'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 28,
                                        'value' => $row['atributos_do_servico_retorno']
                                    );

                                    $custom_fields['tipo_de_interface'] = array(
                                        'customized_type' => 'WorkPackage',
                                        'customized_id' => $task->id,
                                        'custom_field_id' => 29,
                                        'value' => $row['tipo_de_interface']
                                    );
                                }

                                foreach ($custom_fields as $custom_field) {
                                    $custom_field = CustomField::create( $custom_field );

                                    if ($custom_fields) {
                                        DB::commit();
                                    } else {
                                        DB::rolback();
                                        $import->status = 0;
                                        $import->error = GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed');
                                        
                                        if ($import->save())
                                            DB::commit();
                                    }
                                }
                            }
                        }
                    }
                } else {
                    DB::rollback();
                    $import->status = 0;
                    $import->error = GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed');
                    
                    if ($import->save())
                        DB::commit();

                    return redirect('import')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
                }
            } catch (Exception $e){
                DB::rollback();
                $import->status = 0;
                $import->error = $e->getMessage();
                
                if ($import->save())
                    DB::commit();

                return redirect('import')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
        } else if ($inputs['type'] == 'TS') {
            try {
                $file = urldecode(str_replace('..\\', '', str_replace('/', '\\', $inputs['xlsx'])));

                $this->data = [];

                Excel::load($file, function($reader) {
                    // Getting all results
                    $results = $reader->get();

                    foreach ($results as $sheet) {
                        foreach ($sheet as $row) {
                            if ($row->first() != null) {
                                if ($row['entrada'] || $row['almoco_entrada']) {
                                    $workday = Timesheet::where('user_id', Auth::user()->getEloquent()->id)->where('workday', $row['data']->toDateString())->orderBy('workday', 'desc')->get()->first();
                                    if (!$workday) {
                                        $workday = array();

                                        if ($row['saida'] && $row['entrada']) {
                                            $workday = array (
                                                'user_id' => Auth::user()->id,
                                                'workday' => ($row['data'] != null) ? $row['data']->toDateString() : null,
                                                'start' => ($row['entrada'] != null) ? $row['entrada']->toTimeString() : null,
                                                'lunch_start' => ($row['almoco_saida'] != null) ? $row['almoco_saida']->toTimeString() : '00:00:00',
                                                'lunch_end' => ($row['almoco_entrada'] != null) ? $row['almoco_entrada']->toTimeString() : '00:00:00',
                                                'lunch_hours' => 0,
                                                'end' => ($row['saida'] != null) ? $row['saida']->toTimeString() : null,
                                                'hours' => 0,
                                                'nightly_start' => ($row['noturno_entrada'] != null) ? $row['noturno_entrada']->toTimeString() : '00:00:00',
                                                'nightly_end' => ($row['noturno_saida'] != null) ? $row['noturno_saida']->toTimeString() : '00:00:00',
                                                'nightly_hours' => 0,
                                                'status' => 'P'
                                            );
                                        } else if ($row['almoco_saida'] && $row['almoco_entrada'] == null) {
                                            $workday = array (
                                                'user_id' => Auth::user()->id,
                                                'workday' => ($row['data'] != null) ? $row['data']->toDateString() : null,
                                                'start' => ($row['entrada'] != null) ? $row['entrada']->toTimeString() : null,
                                                'lunch_start' => '00:00:00',
                                                'lunch_end' => '00:00:00',
                                                'end' => ($row['almoco_saida'] != null) ? $row['almoco_saida']->toTimeString() : '00:00:00',
                                                'hours' => 0,
                                                'nightly_start' => ($row['noturno_entrada'] != null) ? $row['noturno_entrada']->toTimeString() : '00:00:00',
                                                'nightly_end' => ($row['noturno_saida'] != null) ? $row['noturno_saida']->toTimeString() : '00:00:00',
                                                'nightly_hours' => 0,
                                                'status' => 'P'
                                            );
                                        } else if ($row['almoco_entrada']) {
                                            $workday = array (
                                                'user_id' => Auth::user()->id,
                                                'workday' => ($row['data'] != null) ? $row['data']->toDateString() : null,
                                                'start' => ($row['almoco_entrada'] != null) ? $row['almoco_entrada']->toTimeString() : null,
                                                'lunch_start' => '00:00:00',
                                                'lunch_end' => '00:00:00',
                                                'end' => ($row['saida'] != null) ? $row['saida']->toTimeString() : null,
                                                'hours' => 0,
                                                'nightly_start' => ($row['noturno_entrada'] != null) ? $row['noturno_entrada']->toTimeString() : '00:00:00',
                                                'nightly_end' => ($row['noturno_saida'] != null) ? $row['noturno_saida']->toTimeString() : '00:00:00',
                                                'nightly_hours' => 0,
                                                'status' => 'P'
                                            );
                                        }

                                        $lunch_in_minute = 0;

                                        if ($workday['lunch_end'] != null && $workday['lunch_start'] != null) {
                                            $start = new Carbon($workday['lunch_start']);

                                            $diffTime = $start->diffInMinutes(new Carbon($workday['lunch_end']));

                                            $lunch_in_minute = $diffTime;

                                            $seconds = '00';

                                            $hours = floor($diffTime / 60);
                                            $minutes = ($diffTime % 60);
                                            $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

                                            $workday['lunch_hours'] = $time;
                                        }

                                        $day_in_minute = 0;

                                        if ($workday['end'] != '00:00:00' && $workday['start'] != '00:00:00') {
                                            $start = new Carbon($workday['start']);

                                            $diffTime = $start->diffInMinutes(new Carbon($workday['end']));

                                            $diffTime -= $lunch_in_minute;

                                            $day_in_minute = $diffTime;

                                            $seconds = '00';

                                            $hours = floor($diffTime / 60);
                                            $minutes = ($diffTime % 60);
                                            $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

                                            $workday['hours'] = $time;
                                        }

                                        $nightly_in_minute = 0;

                                        if ($workday['nightly_end'] != null && $workday['nightly_start'] != null) {
                                            if ($workday['nightly_end'] != '00:00:00') {
                                                $start = new Carbon($workday['nightly_start']);

                                                $end = new Carbon($workday['nightly_end']);

                                                if ($start->hour > $end->hour)
                                                    $diffTime = $start->diffInMinutes($end->addDay());
                                                else
                                                    $diffTime = $start->diffInMinutes($end);

                                                $nightly_in_minute = $diffTime;

                                                $seconds = '00';

                                                $hours = floor($diffTime / 60);
                                                $minutes = ($diffTime % 60);
                                                $time = (($hours <= 9 ? "0" . $hours : $hours) . ":" . ($minutes <= 9 ? "0" . $minutes : $minutes)) . ":" . $seconds;

                                                $workday['nightly_hours'] = $time;
                                            } else {
                                                $workday['nightly_hours'] = '00:00:00';
                                            }
                                        }

                                        $overtime = Overtime::where('user_id', Auth::user()->id)->get()->first();

                                        if (!$overtime) {
                                            $overtime = array (
                                                'user_id' => Auth::user()->id,
                                                'hours'   => '00:00:00'
                                            );


                                            $overtime = Overtime::create ($overtime);

                                            if (!$overtime) {
                                                DB::rollback();
                                                $import->status = 0;
                                                $import->error = GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed');
                                                
                                                if ($import->save())
                                                    DB::commit();
                                                return redirect('import')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
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
                                            $import->error = GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed');
                                            
                                            if ($import->save())
                                                DB::commit();
                                            return redirect('import')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
                                        }

                                        $workday = Timesheet::create( $workday );

                                        if ($workday) {
                                            DB::commit();
                                        } else {
                                            DB::rollback();
                                            $import->status = 0;
                                            $import->error = GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed');
                                            
                                            if ($import->save())
                                                DB::commit();
                                            return redirect('import')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
                                        }
                                    }
                                }
                            }
                        }
                    }
                });
            } catch (Exception $e){
                DB::rollback();
                $import->status = 0;
                $import->error = $e->getMessage();
                
                if ($import->save())
                    DB::commit();
                return redirect('import')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }

            return redirect()->to('import');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id, Request $request)
    {
        //
    }
}
