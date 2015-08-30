<?php

use Illuminate\Database\Seeder;

class ProposalsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('proposals')->delete();
        
		\DB::table('proposals')->insert(array (
			0 => 
			array (
				'id' => 1,
				'user_id' => 1,
				'client_id' => 1,
				'client_group_id' => 2,
				'proposal_type_id' => 3,
				'name' => 'APL',
				'description' => 'Teste1',
				'status' => 0,
				'created_at' => '2015-08-25 20:28:29',
				'updated_at' => '2015-08-29 14:41:26',
			),
			1 => 
			array (
				'id' => 2,
				'user_id' => 1,
				'client_id' => 1,
				'client_group_id' => 2,
				'proposal_type_id' => 3,
				'name' => 'Teste',
				'description' => 'Teste',
				'status' => 0,
				'created_at' => '2015-08-30 12:16:44',
				'updated_at' => '2015-08-30 12:16:44',
			),
		));
	}

}
