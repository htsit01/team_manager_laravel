<?php

use App\Customer;
use Illuminate\Database\Seeder;

class CustomersDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shop = new Customer();
        $shop->lat=3.594276;
        $shop->lng=98.687040;
        $shop->name="Harmoni";
        $shop->billing_address="Jalan Sumba No. 6";
        $shop->shipping_address="Jalan Sumba No. 6";
        $shop->phone = "06145688755";
        $shop->fax = "06145688755";
        $shop->customer_area_id= 1;
        $shop->save();

        $shop = new Customer();
        $shop->lat=3.589802;
        $shop->lng=98.692327;
        $shop->name="Sumatra";
        $shop->billing_address="Jalan Sumba No. 6";
        $shop->shipping_address="Jalan Sumba No. 6";
        $shop->phone = "06145688755";
        $shop->fax = "06145688755";
        $shop->customer_area_id= 4;
        $shop->save();

        $shop = new Customer();
        $shop->lat=3.588319;
        $shop->lng=98.698620;
        $shop->name="Wahidin";
        $shop->billing_address="Jalan Sumba No. 6";
        $shop->shipping_address="Jalan Sumba No. 6";
        $shop->phone = "06145688755";
        $shop->fax = "06145688755";
        $shop->customer_area_id= 3;
        $shop->save();

        $shop = new Customer();
        $shop->lat=3.585061;
        $shop->lng=98.700817;
        $shop->name="Besi";
        $shop->billing_address="Jalan Sumba No. 6";
        $shop->shipping_address="Jalan Sumba No. 6";
        $shop->phone = "06145688755";
        $shop->fax = "06145688755";
        $shop->customer_area_id= 2;
        $shop->save();
    }
}
