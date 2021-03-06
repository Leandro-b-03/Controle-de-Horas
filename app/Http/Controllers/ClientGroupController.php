<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Lang;
use App\Client;
use App\ClientGroup;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class ClientGroupController extends Controller
{
    private $controller_name = 'ClientGroupController';

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the client-groups
        $client_groups = ClientGroup::All();
        $data['client-groups'] = $client_groups;

        // Return the client-groups view.
        return view('client-group.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Get all clients
        $clients = Client::all();
        $data['clients'] = $clients;

        // Return the client-view.
        return view('client-group.create')->with('data', $data);
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

        try {
            if($validator) {
                if (ClientGroup::create( $inputs )) {
                    return redirect('client-groups')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'create'));
                } else {
                    DB::rollback();
                    return redirect('client-groups/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create'));
                }
            } else {
                DB::rollback();
                return redirect('client-groups/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
            }
        } catch (Exception $e){
            DB::rollback();
            return redirect('client-groups/create')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'create-failed'));
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
        // Get all clients
        $clients = Client::all();
        $data['clients'] = $clients;

        // Retrive the client-with param $id
        $client_group = ClientGroup::find($id);
        $data['client_group'] = $client_group;

        // Return the dashboard view.
        return view('client-group.create')->with('data', $data);
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

        // Get client-with param $id
        $client_group = ClientGroup::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        try {
            foreach($inputs as $input => $value) {
                if($client_group->{$input})
                    $client_group->{$input} = $value;
            }

            if ($client_group->save()) {
                DB::commit();
                return redirect('client-groups')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'update'));
            } else {
                DB::rollback();
                return redirect('client-groups/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('client-groups/' . $id . '/edit')->withInput()->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'update'));
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
            if (ClientGroup::destroy($ids)) {
                DB::commit();
                return redirect('client-groups')->with('return', GeneralController::createMessage('success', Lang::get('general.' . $this->controller_name), 'delete'));
            } else {
                DB::rollback();
                return redirect('client-groups')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
            }
        } catch (Exception $e) {
            DB::rollback();
            return redirect('client-groups')->with('return', GeneralController::createMessage('failed', Lang::get('general.' . $this->controller_name), 'delete'));
        }
    }
}
