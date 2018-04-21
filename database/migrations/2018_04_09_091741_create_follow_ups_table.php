<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowUpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->double('checkin_lat')->nullable();
            $table->double('checkin_lng')->nullable();
            $table->string('checkin_address')->nullable();
            $table->double('checkout_lat')->nullable();
            $table->double('checkout_lng')->nullable();
            $table->double('checkout_address')->nullable();
            $table->string('name');
            $table->string('address');
            $table->unsignedInteger('status_done')->default(0);
            $table->date('date_time');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('finish_time')->nullable();
            $table->unsignedInteger('stadtus_color')->default(0);
            $table->string('description')->nullable();
            $table->string('report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.mai
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow_ups');
    }
}
