<?php

use Illuminate\Database\Seeder;

class UsersTeamsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users_teams')->delete();
        
	}

}
