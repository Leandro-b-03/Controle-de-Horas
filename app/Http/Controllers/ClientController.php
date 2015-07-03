<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GeneralController;

class ClientController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // Get all the clients
        $clients = Client::All();
        $data['clients'] = $clients;

        // Return the clients view.
        return view('client.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        // Return the client view.
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        
        // Validation of the fields
        $validator = Validator::make(
            [
                $input
            ],
            [
                'name' => 'required',
                'password' => 'required|min:8',
                'email' => 'required|email|unique:users'
            ]
        );

        if($validator) {
            if (Client::create( $input )) {
                return redirect('clients')->with('return', GeneralController::createMessage('success', 'Cliente', 'create'));
            } else {
                DB::rollback();
                return view('clients.create')->withInput()->with('return', GeneralController::createMessage('failed', 'Cliente', 'create'));
            }
        } else {
            DB::rollback();
            return view('clients.create')->withInput()->with('return', GeneralController::createMessage('failed', 'Cliente', 'create-failed'));
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
        // Retrive the client with param $id
        $client = Client::find($id);
        $data['client'] = $client;

        // Return the dashboard view.
        return view('client.create')->with('data', $data);
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

        // Get client with param $id
        $client = Client::find($id);

        // Get all the input from update.
        $inputs = $request->all();

        foreach($inputs as $input => $value) {
            if($client->{$input})
                $client->{$input} = $value;
        }

        if ($client->save()) {
            DB::commit();
            return redirect('clients')->with('return', GeneralController::createMessage('success', 'Cliente', 'update'));
        } else {
            DB::rollback();
            return view('clients.create')->withInput()->with('return', GeneralController::createMessage('failed', 'Cliente', 'update'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
        return response()->json(['status' => 'Ok', 'message' => 'Return correct']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function delete(Request $request)
    {
        DB::beginTransaction();
        
        // Get all the input data received.
        $input = $request->all();

        $ids = explode(',', $input['id']);

        if (Client::destroy($ids)) {
            DB::commit();
            return redirect('clients')->with('return', GeneralController::createMessage('success', 'Cliente', 'delete'));
        } else {
            DB::rollback();
            return redirect('clients')->with('return', GeneralController::createMessage('failed', 'Cliente', 'delete'));
        }
    }
}
