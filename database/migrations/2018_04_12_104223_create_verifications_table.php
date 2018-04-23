<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifications', function (Blueprint $table) {
            $table->increments('id');
//            $table->unsignedInteger('user_one_id');
//            $table->unsignedInteger('user_two_id');
//            $table->dateTime('date_time');
//            $table->unsignedInteger('isSeen');
//            $table->timestamps();
//
//            $table->foreign('user_one_id')
//                ->references('id')
//                ->on('users')
//                ->onDelete('cascade');
//
//            $table->foreign('user_two_id')
//                ->references('id')
//                ->on('users')
//                ->onDelete('cascade');
            $table->unsignedInteger('visit_plan_id');
            $table->unsignedInteger('user_id');
            $table->dateTime('date_time');
            $table->unsignedInteger('is_seen');
            $table->unsignedInteger('is_verify'); //change status when manager verify

            $table->foreign('visit_plan_id')
                ->references('id')
                ->on('visit_plans')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('verifications');
    }
}
