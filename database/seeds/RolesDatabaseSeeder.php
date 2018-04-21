<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = "Director";
        $role->save();

        $role = new Role();
        $role->name = "Retail Manager";
        $role->save();

        $role = new Role();
        $role->name = "Project Manager";
        $role->save();

        $role = new Role();
        $role->name = "Surveyor Manager";
        $role->save();

        $role = new Role();
        $role->name = "Retail Salesman";
        $role->save();

        $role = new Role();
        $role->name = "Project Salesman";
        $role->save();

        $role = new Role();
        $role->name = "Surveyor";
        $role->save();
    }
}
