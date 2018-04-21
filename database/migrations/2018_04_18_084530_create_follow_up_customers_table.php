<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowUpCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('follow_up_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('customer_id');
            $table->double('checkin_lat')->nullable();
            $table->double('checkin_lng')->nullable();
            $table->string('checkin_address')->nullable();
            $table->double('checkout_lat')->nullable();
            $table->double('checkout_lng')->nullable();
            $table->string('checkout_address')->nullable();
            $table->unsignedInteger('status_done')->default(0);
            $table->date('date_time');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('finish_time')->nullable();
            $table->unsignedInteger('status_color')->default(0);
            $table->string('description')->nullable();
            $table->string('report')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

            $table->foreign('user_id')
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
        Schema::dropIfExists('follow_up_customers');
    }
}
