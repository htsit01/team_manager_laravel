<?php

use App\CustomerArea;
use Illuminate\Database\Seeder;

class CustomerAreasDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $region = new CustomerArea();
        $region->name = "Medan02";
        $region->code = "";
        $region->save();

        $region = new CustomerArea();
        $region->name = "DS";
        $region->code = "";
        $region->save();

        $region = new CustomerArea();
        $region->name = "Medan05";
        $region->code = "";
        $region->save();

        $region = new CustomerArea();
        $region->name = "DS ProyInd";
        $region->code = "";
        $region->save();

        $region = new CustomerArea();
        $region->name = "DS PJK";
        $region->code = "";
        $region->save();

        $region = new CustomerArea();
        $region->name = "S13";
        $region->code = "";
        $region->save();

        $region = new CustomerArea();
        $region->name = "S17";
        $region->code = "";
        $region->save();
    }
}
