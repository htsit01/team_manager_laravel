<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomerAreasDatabaseSeeder::class);
        $this->call(GroupsDatabaseSeeder::class);
        $this->call(RolesDatabaseSeeder::class);
        $this->call(UsersDatabaseSeeder::class);
        $this->call(CustomersDatabaseSeeder::class);
    }
}
