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
		\DB::table('projects_times_tasks')->delete();
        
		\DB::table('projects_times_tasks')->insert(array (
			0 => 
			array (
				'id' => 1,
				'project_time_id' => 1,
				'name' => 'Pagina de login',
				'description' => '',
				'teams' => '["2","3"]',
				'created_at' => '2015-08-31 10:54:32',
				'updated_at' => '2015-08-31 10:54:32',
			),
		));
	}

}
