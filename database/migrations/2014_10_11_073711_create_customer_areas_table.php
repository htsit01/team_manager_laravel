<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->timestamps();
        });

        Schema::create('customer_area_users',function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('customer_area_id');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('customer_area_users');
        Schema::dropIfExists('customer_areas');
    }
}
