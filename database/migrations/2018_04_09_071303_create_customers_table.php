<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->double('lat');
            $table->double('lng');
            $table->string('name');
            $table->string('billing_address');
            $table->string('shipping_address')->nullable();
            $table->string('phone');
            $table->string('fax')->nullable();
            $table->unsignedInteger('customer_area_id');
            $table->unsignedInteger('soft_delete')->default(1);
            $table->string('ktp_img')->default('/');
            $table->string('shop_img')->default('/');
            $table->timestamps();

            $table->foreign('customer_area_id')
                ->references('id')
                ->on('customer_areas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}