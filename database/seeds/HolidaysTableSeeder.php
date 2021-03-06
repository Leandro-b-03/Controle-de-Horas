<?php

use Illuminate\Database\Seeder;

class HolidaysTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('holidays')->delete();
        
		\DB::table('holidays')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Ano Novo',
				'day' => 1,
				'month' => 1,
				'holiday_type' => 'Obrigatório',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Carnaval',
				'day' => 17,
				'month' => 2,
				'holiday_type' => 'Obrigatório',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'Páscoa',
				'day' => 5,
				'month' => 3,
				'holiday_type' => 'Obrigatório',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'Tiradentes',
				'day' => 21,
				'month' => 3,
				'holiday_type' => 'Obrigatório',
			),
			4 => 
			array (
				'id' => 5,
				'name' => 'Dia do Trabalho',
				'day' => 1,
				'month' => 5,
				'holiday_type' => 'Obrigatório',
			),
			5 => 
			array (
				'id' => 6,
				'name' => 'Corpus Christi',
				'day' => 4,
				'month' => 6,
				'holiday_type' => 'Obrigatório',
			),
			6 => 
			array (
				'id' => 7,
				'name' => 'Independência do Brasil',
				'day' => 7,
				'month' => 9,
				'holiday_type' => 'Obrigatório',
			),
			7 => 
			array (
				'id' => 8,
				'name' => 'Nossa Senhora Aparecida',
				'day' => 12,
				'month' => 10,
				'holiday_type' => 'Obrigatório',
			),
			8 => 
			array (
				'id' => 9,
				'name' => 'Finados',
				'day' => 2,
				'month' => 11,
				'holiday_type' => 'Obrigatório',
			),
			9 => 
			array (
				'id' => 10,
				'name' => 'Proclamação da República',
				'day' => 15,
				'month' => 11,
				'holiday_type' => 'Obrigatório',
			),
			10 => 
			array (
				'id' => 11,
				'name' => 'Natal',
				'day' => 25,
				'month' => 12,
				'holiday_type' => 'Obrigatório',
			),
		));
	}

}
