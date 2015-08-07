<?php

use Illuminate\Database\Seeder;

class ProjectsTimesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('projects_times')->delete();
        
		DB::table('projects_times')->insert(array (
			0 => 
			array (
				'id' => 2,
				'project_id' => 2,
				'cycle' => 'Frente',
				'budget' => '100000.00',
				'schedule_time' => 100,
				'created_at' => '2015-07-30 20:24:28',
				'updated_at' => '2015-07-30 20:24:28',
			),
			1 => 
			array (
				'id' => 7,
				'project_id' => 4,
				'cycle' => 'Frente',
				'budget' => '100000.00',
				'schedule_time' => 100,
				'created_at' => '2015-07-30 20:28:50',
				'updated_at' => '2015-07-30 20:28:50',
			),
			2 => 
			array (
				'id' => 8,
				'project_id' => 4,
				'cycle' => 'Planejamento',
				'budget' => '100000.00',
				'schedule_time' => 200,
				'created_at' => '2015-07-30 20:28:50',
				'updated_at' => '2015-07-30 20:28:50',
			),
			3 => 
			array (
				'id' => 9,
				'project_id' => 4,
				'cycle' => 'Teste',
				'budget' => '100000.00',
				'schedule_time' => 200,
				'created_at' => '2015-07-30 20:28:50',
				'updated_at' => '2015-07-30 20:28:50',
			),
			4 => 
			array (
				'id' => 10,
				'project_id' => 4,
				'cycle' => 'Reteste',
				'budget' => '100000.00',
				'schedule_time' => 200,
				'created_at' => '2015-07-30 20:28:50',
				'updated_at' => '2015-07-30 20:28:50',
			),
			5 => 
			array (
				'id' => 13,
				'project_id' => 1,
				'cycle' => 'Frente',
				'budget' => '10000.00',
				'schedule_time' => 100,
				'created_at' => '2015-07-30 20:41:47',
				'updated_at' => '2015-07-30 20:41:47',
			),
			6 => 
			array (
				'id' => 14,
				'project_id' => 1,
				'cycle' => 'Planejamento',
				'budget' => '20000.00',
				'schedule_time' => 100,
				'created_at' => '2015-07-30 20:41:47',
				'updated_at' => '2015-07-30 20:41:47',
			),
		));
	}

}
