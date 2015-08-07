<?php

use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('teams')->delete();
        
		DB::table('teams')->insert(array (
			0 => 
			array (
				'id' => 1,
				'user_id' => 1,
				'name' => 'Bravo',
				'color' => '#727272',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			1 => 
			array (
				'id' => 2,
				'user_id' => 2,
				'name' => 'Alpha',
				'color' => '#AA0055',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			2 => 
			array (
				'id' => 3,
				'user_id' => 1,
				'name' => 'Charlie',
				'color' => '#88FF33',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
			3 => 
			array (
				'id' => 4,
				'user_id' => 2,
				'name' => 'Delta',
				'color' => '#1021EE',
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
