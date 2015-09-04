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
		\DB::table('projects_times')->delete();
        
		\DB::table('projects_times')->insert(array (
			0 => 
			array (
				'id' => 2,
				'project_id' => 1,
				'cycle' => 'Frente',
				'budget' => '1021100.00',
				'schedule_time' => 150,
				'created_at' => '2015-09-03 19:04:05',
				'updated_at' => '2015-09-03 19:04:05',
			),
			1 => 
			array (
				'id' => 3,
				'project_id' => 1,
				'cycle' => 'Planejamento',
				'budget' => '1000000.00',
				'schedule_time' => 200,
				'created_at' => '2015-09-03 19:04:05',
				'updated_at' => '2015-09-03 19:04:05',
			),
		));
	}

}
