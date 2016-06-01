<?php

use Illuminate\Database\Seeder;

class ClientsGroupsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('clients_groups')->delete();
        
		\DB::table('clients_groups')->insert(array (
			0 => 
			array (
				'id' => 2,
				'client_id' => 1,
				'name' => 'Teste',
				'description' => 'Teste para segmento',
				'created_at' => '2015-08-26 20:43:25',
				'updated_at' => '2015-08-29 13:39:47',
			),
		));
	}

}
