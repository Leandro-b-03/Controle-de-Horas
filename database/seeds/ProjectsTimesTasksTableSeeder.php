<?php

use Illuminate\Database\Seeder;

class ProjectsTimesTasksTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('projects_times_tasks')->delete();
        
		DB::table('projects_times_tasks')->insert(array (
			0 => 
			array (
				'id' => 1,
				'project_time_id' => 10,
				'name' => 'Testar Frente',
				'description' => '',
				'teams' => '["1","2","4","3"]',
				'created_at' => '2015-08-05 19:47:33',
				'updated_at' => '2015-08-05 19:47:33',
			),
		));
	}

}
