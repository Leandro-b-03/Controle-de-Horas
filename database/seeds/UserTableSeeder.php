<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'Admin',
            'first_name' => 'Admin',
            'last_name' => 'SVLabs',
            'email' => 'admin@svlabs.com.br',
            'photo' => '../uploads/users/photos/user_admin_1.jpg',
            'phone' => '(11) 99890-9909'
            'rg' => '12.345.678-X',
            'cpf' => '123.456.789-09',
            'birthday' => '1990-10-04',
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'username' => 'Admin 2',
            'first_name' => 'Admin',
            'last_name' => 'SVLabs',
            'email' => 'admin2@svlabs.com.br',
            'photo' => '../uploads/users/photos/user_admin_1.jpg',
            'phone' => '(11) 99890-9909'
            'rg' => '12.345.678-X',
            'cpf' => '123.456.789-19',
            'birthday' => '1990-10-04',
            'password' => bcrypt('123456'),
        ]);
    }
}
