<?php

use Illuminate\Database\Seeder;

class ProposalsVersionsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('proposals_versions')->delete();
        
		\DB::table('proposals_versions')->insert(array (
			0 => 
			array (
				'id' => 1,
				'proposal_id' => 1,
				'proposal' => 'lorem ipsum',
				'version' => 'v1',
				'send' => 0,
				'date_send' => '0000-00-00',
				'date_return' => '0000-00-00',
				'authorise' => 0,
				'data_authorise' => '0000-00-00',
				'signing_board' => 0,
				'date_signing_board' => '0000-00-00',
				'active' => 1,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '0000-00-00 00:00:00',
			),
		));
	}

}
