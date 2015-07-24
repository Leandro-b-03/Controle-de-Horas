<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use PusherManager;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PusherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function auth(Request $request)
    {
        $post = $request->all();

        $json = json_decode(PusherManager::presence_auth($post["channel_name"], $post["socket_id"], Auth::user()->id, array('name' => Auth::user()->first_name)));

        return response()->json($json);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
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
    }
}
