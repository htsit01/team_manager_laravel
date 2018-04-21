<?php

use App\Group;
use Illuminate\Database\Seeder;

class GroupsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $group = new Group();
        $group->name = "Group A";
        $group->save();

        $group = new Group();
        $group->name = "Group B";
        $group->save();
    }
}
