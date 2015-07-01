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

    Route::get('general/createMessageJSON', 'GeneralController@createMessageJSON');

    Route::group(['prefix' => 'projects'], function () {
        Route::get('/', ['as' => 'projects', 'uses' => 'ProjectController@index']);
        Route::get('create', ['as' => 'projects.create', 'uses' => 'ProjectController@create']);
        Route::get('{id}/edit', ['as' => 'projects.edit', 'uses' => 'ProjectController@edit']);
        Route::post('/', ['as' => 'projects.store', 'uses' => 'ProjectController@store']);
        Route::delete('/', ['as' => 'projects.delete', 'uses' => 'ProjectController@delete']);
        // Route::delete('/', ['as' => 'projects.destroy', 'uses' => 'ProjectController@destroy']);
        Route::get('{id}', ['as' => 'projects.show', 'uses' => 'ProjectController@show']);
        Route::put('{id}', ['as' => 'projects.update', 'uses' => 'ProjectController@update']);
    });

    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', ['as' => 'clients', 'uses' => 'ClientController@index']);
        Route::get('create', ['as' => 'clients.create', 'uses' => 'ClientController@create']);
        Route::get('{id}/edit', ['as' => 'clients.edit', 'uses' => 'ClientController@edit']);
        Route::post('/', ['as' => 'clients.store', 'uses' => 'ClientController@store']);
        Route::delete('/', ['as' => 'clients.delete', 'uses' => 'ClientController@delete']);
        // Route::delete('/', ['as' => 'clients.destroy', 'uses' => 'ClientController@destroy']);
        Route::get('{id}', ['as' => 'clients.show', 'uses' => 'ClientController@show']);
        Route::put('{id}', ['as' => 'clients.update', 'uses' => 'ClientController@update']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', ['as' => 'users', 'uses' => 'UserController@index']);
        Route::get('create', ['as' => 'users.create', 'uses' => 'UserController@create']);
        Route::get('{id}/edit', ['as' => 'users.edit', 'uses' => 'UserController@edit']);
        Route::post('/', ['as' => 'users.store', 'uses' => 'UserController@store']);
        Route::delete('/', ['as' => 'users.delete', 'uses' => 'UserController@delete']);
        // Route::delete('/', ['as' => 'users.destroy', 'uses' => 'UserController@destroy']);
        Route::get('{id}', ['as' => 'users.show', 'uses' => 'UserController@show']);
        Route::put('{id}', ['as' => 'users.update', 'uses' => 'UserController@update']);
    });

    Route::group(['prefix' => 'group-permissions'], function () {
        Route::get('/', ['as' => 'group-permissions', 'uses' => 'GroupPermissionController@index']);
        Route::get('create', ['as' => 'group-permissions.create', 'uses' => 'GroupPermissionController@create']);
        Route::get('{id}/edit', ['as' => 'group-permissions.edit', 'uses' => 'GroupPermissionController@edit']);
        Route::post('/', ['as' => 'group-permissions.store', 'uses' => 'GroupPermissionController@store']);
        Route::delete('/', ['as' => 'group-permissions.delete', 'uses' => 'GroupPermissionController@delete']);
        // Route::delete('/', ['as' => 'group-permissions.destroy', 'uses' => 'GroupPermissionController@destroy']);
        Route::get('{id}', ['as' => 'group-permissions.show', 'uses' => 'GroupPermissionController@show']);
        Route::put('{id}', ['as' => 'group-permissions.update', 'uses' => 'GroupPermissionController@update']);
    });

    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', ['as' => 'messages', 'uses' => 'MessagesController@index']);
        Route::get('create', ['as' => 'messages.create', 'uses' => 'MessagesController@create']);
        Route::post('/', ['as' => 'messages.store', 'uses' => 'MessagesController@store']);
        Route::get('{id}', ['as' => 'messages.show', 'uses' => 'MessagesController@show']);
        Route::put('{id}', ['as' => 'messages.update', 'uses' => 'MessagesController@update']);
    });
});