<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::controllers([
	'auth'     => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Route::resource('messages', 'MessagesController', ['only' => ['index', 'store', 'show']]);

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'HomeController@index');

	Route::get('home', 'HomeController@index');

    Route::get('dashboard', 'DashboardController@index');

    Route::post('pusher/auth', 'PusherController@auth');

    Route::get('general/createNotificationJSON', 'GeneralController@createNotificationJSON');
    Route::get('general/createMessageJSON', 'GeneralController@createMessageJSON');
    Route::post('general/verifyEmailJSON', 'GeneralController@verifyEmailJSON');
    Route::post('general/verifyCPFJSON', 'GeneralController@verifyCPFJSON');

    Route::resource('projects', 'ProjectController');

    Route::resource('clients', 'ClientController');

    Route::resource('users', 'UserController');

    Route::resource('group-permissions', 'GroupPermissionController');
});