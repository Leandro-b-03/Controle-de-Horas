<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('projects')->delete();
        
		DB::table('projects')->insert(array (
			0 => 
			array (
				'id' => 1,
				'user_id' => 2,
				'proposal_id' => 1,
				'name' => 'ATEAAA1',
				'budget' => '30000.00',
				'schedule_time' => 200,
				'description' => 'Lorem ipsum suite.',
				'long_description' => 'Lorem ipsum suite.',
				'status' => 'A',
				'created_at' => '2015-07-30 20:21:46',
				'updated_at' => '2015-07-30 20:41:47',
			),
			1 => 
			array (
				'id' => 2,
				'user_id' => 2,
				'proposal_id' => 1,
				'name' => 'ATEAAA1',
				'budget' => '0.00',
				'schedule_time' => 700,
				'description' => 'Lorem ipsum suite.',
				'long_description' => 'Lorem ipsum suite.',
				'status' => 'A',
				'created_at' => '2015-07-30 20:24:28',
				'updated_at' => '2015-07-30 20:24:28',
			),
			2 => 
			array (
				'id' => 3,
				'user_id' => 2,
				'proposal_id' => 1,
				'name' => 'ATEAAA1',
				'budget' => '0.00',
				'schedule_time' => 700,
				'description' => 'Lorem ipsum suite.',
				'long_description' => 'Lorem ipsum suite.',
				'status' => 'A',
				'created_at' => '2015-07-30 20:25:24',
				'updated_at' => '2015-07-30 20:25:24',
			),
			3 => 
			array (
				'id' => 4,
				'user_id' => 2,
				'proposal_id' => 1,
				'name' => 'ATEAAA1',
				'budget' => '0.00',
				'schedule_time' => 700,
				'description' => 'Lorem ipsum suite.',
				'long_description' => 'Lorem ipsum suite.',
				'status' => 'A',
				'created_at' => '2015-07-30 20:25:56',
				'updated_at' => '2015-07-30 20:25:56',
			),
		));
	}

}
