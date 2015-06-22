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

Route::group(['middleware' => 'auth'], function () {
	Route::get('/', 'HomeController@index');

	Route::get('home', 'HomeController@index');

    Route::get('dashboard', 'DashboardController@index');

    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', ['as' => 'projects', 'uses' => 'ProjectController@index']);
        Route::get('create', ['as' => 'projects.create', 'uses' => 'ProjectController@create']);
        Route::post('/', ['as' => 'projects.store', 'uses' => 'ProjectController@store']);
        Route::get('{id}', ['as' => 'projects.show', 'uses' => 'ProjectController@show']);
        Route::put('{id}', ['as' => 'projects.update', 'uses' => 'ProjectController@update']);
    });

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', ['as' => 'clients', 'uses' => 'ClientController@index']);
        Route::get('create', ['as' => 'clients.create', 'uses' => 'ClientController@create']);
        Route::post('/', ['as' => 'clients.store', 'uses' => 'ClientController@store']);
        Route::get('{id}', ['as' => 'clients.show', 'uses' => 'ClientController@show']);
        Route::put('{id}', ['as' => 'clients.update', 'uses' => 'ClientController@update']);
    });

    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
        Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
        Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
        Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
        Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
    });
});