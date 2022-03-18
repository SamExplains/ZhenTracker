<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoredFormsScheduleBSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stored_forms_schedule_b_s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('company_id');
            $table->string('form_name');
            $table->string('form_year');
            // Form Fields for 941-2021
            /**
             * Form can have a total of (4) Variations because there can be
             * 4 forms due to 4 unique periods for filing within the year.
             * All data will be stored as Strings
             */
            $table->string('eid'); // employee identification number
            $table->string('name'); // company name
            $table->integer('quarter'); // Can be 1,2,3,4
            $table->string('month_one');
            $table->string('month_one_tax_liability');
            $table->string('month_two');
            $table->string('month_two_tax_liability');
            $table->string('month_three');
            $table->string('month_three_tax_liability');
            $table->string('total_liability');
        });

        Schema::table('stored_forms_schedule_b_s', function($table) {
          $table->foreign('company_id')->references('id')->on('company')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stored_forms_schedule_b_s');
    }
}