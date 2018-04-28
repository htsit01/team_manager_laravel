<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "User Satu";
        $user->email = "user1@gmail.com";
        $user->password = bcrypt('secret');
        $user->mac_address = "02:00:00:44:55:66";
        $user->role_id = 2;
        $user->group_id = 1;
        $user->code="US";
        $user->phone="0215546662";
        $user->save();

        $user = new User();
        $user->name = "User Dua";
        $user->email = "user2@gmail.com";
        $user->password = bcrypt('secret');
        $user->mac_address = "00:00:00:02";
        $user->role_id = 5;
        $user->group_id = 1;
        $user->code="US";
        $user->phone="0215546662";
        $user->customer_area_id = 2;
        $user->save();

        $user = new User();
        $user->name = "User Tiga";
        $user->email = "user3@gmail.com";
        $user->password = bcrypt('secret');
        $user->mac_address = "00:00:00:03";
        $user->role_id = 5;
        $user->group_id = 1;
        $user->code="US";
        $user->phone="0215546662";
        $user->customer_area_id = 3;
        $user->save();

        $user = new User();
        $user->name = "User Empat";
        $user->email = "user4@gmail.com";
        $user->password = bcrypt('secret');
        $user->mac_address = "00:00:00:04";
        $user->role_id = 2;
        $user->group_id = 2;
        $user->code="US";
        $user->phone="0215546662";
        $user->customer_area_id = 4;
        $user->save();
    }
}
