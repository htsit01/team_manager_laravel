<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mac_address')->unique();
            $table->string('password');
            $table->string('code');
            $table->string('phone');
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('group_id')->nullable();
            $table->unsignedInteger('customer_area_id')->nullable();
            $table->timestamps();


            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

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
        Schema::dropIfExists('users');
    }
}
