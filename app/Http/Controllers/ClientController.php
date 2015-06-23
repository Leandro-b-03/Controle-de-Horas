<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Client;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
        // Return the dashboard view.
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
            Client::create( $input );
            return redirect('clients');
        } else {
            return view('clients.create')->withInput();
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
    public function update($id)
    {
        //
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
}
