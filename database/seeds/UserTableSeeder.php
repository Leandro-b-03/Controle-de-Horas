<?php

use App\User;
use App\Role;
use App\Permission;
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
            'username'          => 'Admin',
            'first_name'        => 'Admin',
            'last_name'         => 'SVLabs',
            'email'             => 'admin@svlabs.com.br',
            'photo'             => '../uploads/users/photos/user_admin_1.jpg',
            'phone'             => '(11) 99890-9909',
            'rg'                => '12.345.678-X',
            'cpf'               => '123.456.789-09',
            'birthday'          => '1990-10-04',
            'password'          => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'username'          => 'Admin 2',
            'first_name'        => 'Admin',
            'last_name'         => 'SVLabs',
            'email'             => 'admin2@svlabs.com.br',
            'photo'             => '../uploads/users/photos/user_admin_1.jpg',
            'phone'             => '(11) 99890-9909',
            'rg'                => '12.345.678-X',
            'cpf'               => '123.456.789-19',
            'birthday'          => '1990-10-04',
            'password'          => bcrypt('123456'),
        ]);

        $admin                  = new Role;
        $admin->name            = 'Godless-Admin';
        $admin->display_name    = 'Godless Admin';
        $admin->description     = 'Godless Admin can do anything, literally anything';
        $admin->save();

        $god_mode = new Permission;
        $god_mode->name         = 'god-mode';
        $god_mode->display_name = 'Modo faz tudo';
        $god_mode->save();

        $admin->perms()->sync(array($god_mode->id));

        $user = User::where('username', '=', 'Admin')->first();
        $user->attachRole($admin);

        $user2 = User::where('username', '=', 'Admin 2')->first();
        $user2->attachRole($admin);
    }
}
