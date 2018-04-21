<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_forms', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('user_id');
            $table->string('work_field');
            $table->date('since');
            $table->string('owner_name');
            $table->string('resident_card_id');
            $table->string('npwp_pkp');
            $table->string('owner_address');
            $table->unsignedInteger('customer_status'); //0 milik atau 1 sewa
            $table->string('recommended_by');
            $table->unsignedInteger('credit_term');
            $table->unsignedInteger('credit_plafon');
            $table->string('other_supported_invoice');
            $table->unsignedInteger('status')->default(0); //status ada 3, 0 means pending 1 means acc 2 means rejected.. rejected means customer will be delete.;
            $table->timestamps();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
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
        Schema::dropIfExists('credit_forms');
    }
}
