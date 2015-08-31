<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('permissions')->delete();
        
		\DB::table('permissions')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'god-mode',
				'display_name' => 'Modo faz tudo',
				'description' => NULL,
				'created_at' => '2015-08-25 20:23:59',
				'updated_at' => '2015-08-25 20:23:59',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'ProposalController@index',
				'display_name' => 'Visualizar ProposalController',
				'description' => 'Visualizar os ProposalController',
				'created_at' => '2015-08-25 20:25:21',
				'updated_at' => '2015-08-25 20:25:21',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'ProjectController@index',
				'display_name' => 'Visualizar ProjectController',
				'description' => 'Visualizar os ProjectController',
				'created_at' => '2015-08-25 20:25:22',
				'updated_at' => '2015-08-25 20:25:22',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'TaskController@index',
				'display_name' => 'Visualizar TaskController',
				'description' => 'Visualizar os TaskController',
				'created_at' => '2015-08-25 20:25:22',
				'updated_at' => '2015-08-25 20:25:22',
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'ClientController@index',
				'display_name' => 'Visualizar ClientController',
				'description' => 'Visualizar os ClientController',
				'created_at' => '2015-08-25 20:25:22',
				'updated_at' => '2015-08-25 20:25:22',
			),
			5 => 
			array (
				'id' => 6,
				'name' => 'ClientGroupController@index',
				'display_name' => 'Visualizar ClientGroupController',
				'description' => 'Visualizar os ClientGroupController',
				'created_at' => '2015-08-25 20:25:22',
				'updated_at' => '2015-08-25 20:25:22',
			),
			6 => 
			array (
				'id' => 7,
				'name' => 'UserController@index',
				'display_name' => 'Visualizar UserController',
				'description' => 'Visualizar os UserController',
				'created_at' => '2015-08-25 20:25:22',
				'updated_at' => '2015-08-25 20:25:22',
			),
			7 => 
			array (
				'id' => 8,
				'name' => 'TimesheetController@index',
				'display_name' => 'Visualizar TimesheetController',
				'description' => 'Visualizar os TimesheetController',
				'created_at' => '2015-08-25 20:25:22',
				'updated_at' => '2015-08-25 20:25:22',
			),
			8 => 
			array (
				'id' => 9,
				'name' => 'TeamController@index',
				'display_name' => 'Visualizar TeamController',
				'description' => 'Visualizar os TeamController',
				'created_at' => '2015-08-25 20:25:22',
				'updated_at' => '2015-08-25 20:25:22',
			),
			9 => 
			array (
				'id' => 10,
				'name' => 'GroupPermissionController@index',
				'display_name' => 'Visualizar GroupPermissionController',
				'description' => 'Visualizar os GroupPermissionController',
				'created_at' => '2015-08-25 20:25:22',
				'updated_at' => '2015-08-25 20:25:22',
			),
			10 => 
			array (
				'id' => 11,
				'name' => 'ProposalController@create',
				'display_name' => 'Criar ProposalController',
				'description' => 'Criar novo ProposalController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			11 => 
			array (
				'id' => 12,
				'name' => 'ProposalController@edit',
				'display_name' => 'Editar ProposalController',
				'description' => 'Editar novo ProposalController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			12 => 
			array (
				'id' => 13,
				'name' => 'ProposalController@delete',
				'display_name' => 'Deletar ProposalController',
			'description' => 'Deletar o(s) ProposalController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			13 => 
			array (
				'id' => 14,
				'name' => 'ProjectController@create',
				'display_name' => 'Criar ProjectController',
				'description' => 'Criar novo ProjectController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			14 => 
			array (
				'id' => 15,
				'name' => 'ProjectController@edit',
				'display_name' => 'Editar ProjectController',
				'description' => 'Editar novo ProjectController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			15 => 
			array (
				'id' => 16,
				'name' => 'ProjectController@delete',
				'display_name' => 'Deletar ProjectController',
			'description' => 'Deletar o(s) ProjectController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			16 => 
			array (
				'id' => 17,
				'name' => 'TaskController@create',
				'display_name' => 'Criar TaskController',
				'description' => 'Criar novo TaskController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			17 => 
			array (
				'id' => 18,
				'name' => 'TaskController@edit',
				'display_name' => 'Editar TaskController',
				'description' => 'Editar novo TaskController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			18 => 
			array (
				'id' => 19,
				'name' => 'TaskController@delete',
				'display_name' => 'Deletar TaskController',
			'description' => 'Deletar o(s) TaskController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			19 => 
			array (
				'id' => 20,
				'name' => 'ClientController@create',
				'display_name' => 'Criar ClientController',
				'description' => 'Criar novo ClientController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			20 => 
			array (
				'id' => 21,
				'name' => 'ClientController@edit',
				'display_name' => 'Editar ClientController',
				'description' => 'Editar novo ClientController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			21 => 
			array (
				'id' => 22,
				'name' => 'ClientController@delete',
				'display_name' => 'Deletar ClientController',
			'description' => 'Deletar o(s) ClientController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			22 => 
			array (
				'id' => 23,
				'name' => 'ClientGroupController@create',
				'display_name' => 'Criar ClientGroupController',
				'description' => 'Criar novo ClientGroupController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			23 => 
			array (
				'id' => 24,
				'name' => 'ClientGroupController@edit',
				'display_name' => 'Editar ClientGroupController',
				'description' => 'Editar novo ClientGroupController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			24 => 
			array (
				'id' => 25,
				'name' => 'ClientGroupController@delete',
				'display_name' => 'Deletar ClientGroupController',
			'description' => 'Deletar o(s) ClientGroupController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			25 => 
			array (
				'id' => 26,
				'name' => 'UserController@create',
				'display_name' => 'Criar UserController',
				'description' => 'Criar novo UserController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			26 => 
			array (
				'id' => 27,
				'name' => 'UserController@edit',
				'display_name' => 'Editar UserController',
				'description' => 'Editar novo UserController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			27 => 
			array (
				'id' => 28,
				'name' => 'UserController@delete',
				'display_name' => 'Deletar UserController',
			'description' => 'Deletar o(s) UserController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			28 => 
			array (
				'id' => 29,
				'name' => 'TimesheetController@create',
				'display_name' => 'Criar TimesheetController',
				'description' => 'Criar novo TimesheetController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			29 => 
			array (
				'id' => 30,
				'name' => 'TimesheetController@edit',
				'display_name' => 'Editar TimesheetController',
				'description' => 'Editar novo TimesheetController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			30 => 
			array (
				'id' => 31,
				'name' => 'TimesheetController@delete',
				'display_name' => 'Deletar TimesheetController',
			'description' => 'Deletar o(s) TimesheetController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			31 => 
			array (
				'id' => 32,
				'name' => 'TeamController@create',
				'display_name' => 'Criar TeamController',
				'description' => 'Criar novo TeamController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			32 => 
			array (
				'id' => 33,
				'name' => 'TeamController@edit',
				'display_name' => 'Editar TeamController',
				'description' => 'Editar novo TeamController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			33 => 
			array (
				'id' => 34,
				'name' => 'TeamController@delete',
				'display_name' => 'Deletar TeamController',
			'description' => 'Deletar o(s) TeamController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			34 => 
			array (
				'id' => 35,
				'name' => 'GroupPermissionController@create',
				'display_name' => 'Criar GroupPermissionController',
				'description' => 'Criar novo GroupPermissionController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			35 => 
			array (
				'id' => 36,
				'name' => 'GroupPermissionController@edit',
				'display_name' => 'Editar GroupPermissionController',
				'description' => 'Editar novo GroupPermissionController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
			36 => 
			array (
				'id' => 37,
				'name' => 'GroupPermissionController@delete',
				'display_name' => 'Deletar GroupPermissionController',
			'description' => 'Deletar o(s) GroupPermissionController',
				'created_at' => '2015-08-25 20:25:43',
				'updated_at' => '2015-08-25 20:25:43',
			),
		));
	}

}
