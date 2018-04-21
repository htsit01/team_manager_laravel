<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditFormSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credit_form_suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('credit_form_id');
            $table->string('supplier_name');
            $table->unsignedInteger('omset_estimation'); //perkiraan omset
            $table->unsignedInteger('credit_term');
            $table->string('information');
            $table->timestamps();

            $table->foreign('credit_form_id')
                ->references('id')
                ->on('credit_forms')
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
        Schema::dropIfExists('credit_form_suppliers');
    }
}
