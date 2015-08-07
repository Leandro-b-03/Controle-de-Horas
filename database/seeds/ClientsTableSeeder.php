<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('clients')->delete();
        
		DB::table('clients')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Alelo',
				'responsible' => 'José da Silva',
				'email' => 'jose@alelo.com',
				'phone' => '(11) 99875-412',
				'description' => '',
				'created_at' => '2015-07-30 20:12:24',
				'updated_at' => '2015-07-30 20:12:24',
			),
		));
	}

}
