<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call('UserTableSeeder');

        Model::reguard();
    	$this->call('TeamsTableSeeder');
		$this->call('ClientsTableSeeder');
		$this->call('RoleUserTableSeeder');
        $this->call('ClientsGroupsTableSeeder');
        $this->call('ProposalsTypesTableSeeder');
		$this->call('ProposalsTableSeeder');
		$this->call('PermissionsTableSeeder');
		$this->call('PermissionRoleTableSeeder');
		$this->call('ProposalsVersionsTableSeeder');
        $this->call('ProjectsTableSeeder');
		// $this->call('ProjectsTimesTasksTableSeeder');
		$this->call('ProjectsTimesTableSeeder');
	}
}
