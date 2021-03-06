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

/*
 * Login
 */
Route::controllers([
	'auth'     => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('email/confirm', 'GeneralController@confirm');

Route::get('email/test', 'GeneralController@testMail');

// Route::post('user/rfid_login', 'GeneralController@rfidLogin');
Route::get('user/rfid_login', 'GeneralController@rfidLogin');

/*
 * Access
 */
Route::group(['middleware' => 'auth'], function () {
    Route::resource('lock', 'LockscreenController');

    Route::group(['middleware' => 'App\Http\Middleware\LunchTime'], function () {
    	Route::get('/', 'HomeController@index');

        Route::get('home', 'HomeController@index');

        Route::get('dashboard', 'DashboardController@index');

        Route::get('dashboard/getUsersTasks', 'DashboardController@getUsersTasks');

        Route::get('autocomplete/users', 'GeneralController@getUserAutocomplete');

        Route::get('autocomplete/team', 'GeneralController@getTeamAutocomplete');

        Route::get('general/createNotificationJSON', 'GeneralController@createNotificationJSON');

        Route::get('general/createMessageJSON', 'GeneralController@createMessageJSON');

        Route::get('general/projectName', 'GeneralController@projectNameJSON');

        Route::get('general/getUser', 'GeneralController@getUser');

        Route::get('general/getProjectTimes', 'GeneralController@getProjectTimes');

        Route::get('general/getClientGroup', 'GeneralController@getClientGroup');

        Route::get('general/saveSettings', 'GeneralController@saveSettings');

        Route::get('general/changeDay', 'GeneralController@changeDay');

        Route::get('general/changeTaskDay', 'GeneralController@changeTaskDay');

        Route::get('general/saveLocalization', 'GeneralController@saveLocalization');
            
        Route::get('general/getTasks', 'GeneralController@getTasks');

        Route::get('general/getTasksDay', 'GeneralController@getTasksDay');

        Route::get('general/getUseCase', 'GeneralController@getUseCase');

        Route::get('general/getTasksEditDay', 'GeneralController@getTasksEditDay');

        Route::get('general/getAllNotifications', 'GeneralController@getAllNotifications');

        Route::post('pusher/auth', 'PusherController@auth');

        Route::post('pusher/chat', 'PusherController@chat');

        Route::post('general/verifyEmailJSON', 'GeneralController@verifyEmailJSON');

        Route::post('general/verifyCPFJSON', 'GeneralController@verifyCPFJSON');
        
        Route::post('general/saveImages', 'GeneralController@saveImages');
        
        Route::post('general/RequestChangeDay', 'GeneralController@RequestChangeDay');
        
        Route::get('register', function() {
            if (\Auth::user()->getEloquent() == null)
                return view('auth.register');
            else
                return redirect()->to('dashboard');
        });

        Route::get('profile/{id}', 'UserController@show');

        Route::resource('proposals', 'ProposalController');
        Entrust::routeNeedsPermission('proposals', 'ProposalController@index');
        Entrust::routeNeedsPermission('proposals/create', 'ProposalController@create');
        Entrust::routeNeedsPermission('proposals/*/edit', 'ProposalController@edit');
        Entrust::routeNeedsPermission('proposals/delete', 'ProposalController@delete');

        Route::resource('projects', 'ProjectController');
        Entrust::routeNeedsPermission('projects', 'ProjectController@index');
        Entrust::routeNeedsPermission('projects/create', 'ProjectController@create');
        Entrust::routeNeedsPermission('projects/*/edit', 'ProjectController@edit');
        Entrust::routeNeedsPermission('projects/delete', 'ProjectController@delete');

        Route::resource('tasks', 'TaskController');
        Entrust::routeNeedsPermission('tasks', 'TaskController@index');
        Entrust::routeNeedsPermission('tasks/create', 'TaskController@create');
        Entrust::routeNeedsPermission('tasks/*/edit', 'TaskController@edit');
        Entrust::routeNeedsPermission('tasks/delete', 'TaskController@delete');

        Route::resource('clients', 'ClientController');
        Entrust::routeNeedsPermission('clients', 'ClientController@index');
        Entrust::routeNeedsPermission('clients/create', 'ClientController@create');
        Entrust::routeNeedsPermission('clients/*/edit', 'ClientController@edit');
        Entrust::routeNeedsPermission('clients/delete', 'ClientController@delete');

        Route::resource('client-groups', 'ClientGroupController');
        Entrust::routeNeedsPermission('client-groups', 'ClientGroupController@index');
        Entrust::routeNeedsPermission('client-groups/create', 'ClientGroupController@create');
        Entrust::routeNeedsPermission('client-groups/*/edit', 'ClientGroupController@edit');
        Entrust::routeNeedsPermission('client-groups/delete', 'ClientGroupController@delete');

        Route::resource('timesheets', 'TimesheetController');
        Entrust::routeNeedsPermission('timesheets', 'TimesheetController@index');
        Entrust::routeNeedsPermission('timesheets/create', 'TimesheetController@create');
        Entrust::routeNeedsPermission('timesheets/*/edit', 'TimesheetController@edit');
        Entrust::routeNeedsPermission('timesheets/delete', 'TimesheetController@delete');

        Route::resource('teams', 'TeamController');
        Entrust::routeNeedsPermission('teams', 'TeamController@index');
        Entrust::routeNeedsPermission('teams/create', 'TeamController@create');
        Entrust::routeNeedsPermission('teams/*/edit', 'TeamController@edit');
        Entrust::routeNeedsPermission('teams/delete', 'TeamController@delete');

        Route::resource('group-permissions', 'GroupPermissionController');
        Entrust::routeNeedsPermission('group-permissions', 'GroupPermissionController@index');
        Entrust::routeNeedsPermission('group-permissions/create', 'GroupPermissionController@create');
        Entrust::routeNeedsPermission('group-permissions/*/edit', 'GroupPermissionController@edit');
        Entrust::routeNeedsPermission('group-permissions/delete', 'GroupPermissionController@delete');

        Route::resource('import', 'DataImportController');
        Entrust::routeNeedsPermission('import', 'DataImportController@index');
        Entrust::routeNeedsPermission('import/create', 'DataImportController@create');
        Entrust::routeNeedsPermission('import/*/edit', 'DataImportController@edit');
        Entrust::routeNeedsPermission('import/delete', 'DataImportController@delete');

        Route::resource('settings', 'SettingsController');
        Entrust::routeNeedsPermission('settings', 'SettingsController@index');
        Entrust::routeNeedsPermission('settings/create', 'SettingsController@create');
        Entrust::routeNeedsPermission('settings/*/edit', 'SettingsController@edit');
        Entrust::routeNeedsPermission('settings/delete', 'SettingsController@delete');
    });

    Route::resource('users', 'UserController');
    Route::get('users/{id}/timesheet', 'UserController@timesheet');
    //Entrust::routeNeedsPermission('users', 'UserController@index');
    //Entrust::routeNeedsPermission('users/create', 'UserController@create');
    //Entrust::routeNeedsPermission('users/*/edit', 'UserController@edit');
    //Entrust::routeNeedsPermission('users/delete', 'UserController@delete');
    Entrust::routeNeedsPermission('users/{id}/timesheet', 'UserController@edit');
});

Route::group(['middleware' => 'guest'], function () {
    Redirect::to('/');
});