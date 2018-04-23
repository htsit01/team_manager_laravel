<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('visit_plan_id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('status_done')->default(0); //0 not done, 1=checkin, 2=checkout(done)
            $table->date('date_time');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('finish_time')->nullable();
            $table->unsignedInteger('type');  //0 daily 1 weekly
            $table->unsignedInteger('status_color')->default(0); //0: red 1: green 2:orange 3: gray
            $table->string('description')->nullable();
            $table->string('report')->nullable();
            $table->timestamps();


            $table->foreign('visit_plan_id')
                ->references('id')
                ->on('visit_plans')
                ->onDelete('cascade');

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
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
        Schema::dropIfExists('list_plans');
    }
}
