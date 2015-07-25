<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use PusherManager;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ActivityController;

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
    public function chat(Request $request)
    {
        $post = $request->all();

        $chat_info = $post['chat_info'];
        $options = $this->sanitise_input($chat_info);

        $activity = new ActivityController('chat-message', $options['text'], $options);

        $data = $activity->getMessage();
        $response = PusherManager::trigger($chat_info['channel_name'], 'chat_message', $data, null, true);

        $result = array('activity' => $data, 'pusherResponse' => $response);
        return response()->json($result);
    }

    /**
     *
     */
    public function get_channel_name($http_referer) {
        // not allowed :, / % #
        $pattern = "/(\W)+/";
        $channel_name = preg_replace($pattern, '-', $http_referer);
        return $channel_name;
    }

    /**
     *
     */
    public function sanitise_input($chat_info) {
        $email = isset($chat_info['email']) ? $chat_info['email'] : '';
        
        $options = array();
        $options['displayName'] = substr(htmlspecialchars($chat_info['nickname']), 0, 30);
        $options['text'] = substr(htmlspecialchars($chat_info['text']), 0, 300);
        $options['email'] = substr(htmlspecialchars($email), 0, 100);

        return $options;
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
