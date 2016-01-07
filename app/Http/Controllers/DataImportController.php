<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Excel;
use App\Task;
use App\Project;
use App\Http\Requests;
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
        // Return the imports view.
        return view('import.index');
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

        try {
            if($inputs) {
                ini_set('memory_limit','1024M');
                $file = urldecode(str_replace('..\\', '', str_replace('/', '\\', $inputs['xlsx'])));

                $data = array();

                Excel::load($file, function($reader) {
                    // Getting all results
                    $results = $reader->get();

                    foreach ($results as $sheet) {
                        $i = 0;
                        foreach ($sheet as $row) {
                            if ($sheet->getTitle() == 'Projetos' || $sheet->getTitle() == 'Projeto') {
                                $data['sheets']['title'][$sheet->getTitle()][$i]['propostaprojeto'] = $row->propostaprojeto;

                                if ($row->op == 'S')
                                    $data['sheets']['title'][$sheet->getTitle()][$i]['id_op'] = $row->id_op;
                                else
                                    $data['sheets']['title'][$sheet->getTitle()][$i]['id_op'] = '00';

                            } else {
                                foreach ($row as $index => $value) {
                                    $data['sheets']['title'][$sheet->getTitle()][$i][$index] = $value;
                                }
                            }

                            $i++;
                        }
                    }
                });

                foreach ($data['sheets'] as $sheets) {
                    
                }
                
                die(d('a'));

            } else {
                DB::rollback();
                return redirect('imports/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
        } catch (Exception $e){
            DB::rollback();
            die(d($e));
            return redirect('imports/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
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
