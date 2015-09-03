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
		\DB::table('projects')->delete();
        
		\DB::table('projects')->insert(array (
			0 => 
			array (
				'id' => 1,
				'user_id' => 2,
				'proposal_id' => 1,
				'name' => 'PAL123',
				'name_complement' => '-ALELO-DESK-DESK-APL-08/15 V1',
				'budget' => '10000.00',
				'schedule_time' => 100,
				'description' => 'Teste de Projeto',
				'long_description' => 'Teste de projeto para o teste!',
				'status' => 'A',
				'created_at' => '2015-08-31 10:53:25',
				'updated_at' => '2015-08-31 10:53:25',
			),
		));
	}

}
