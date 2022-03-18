<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoredForms8974sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stored_forms8974s', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('company_id');
            $table->string('form_name');
            $table->string('form_year');
            $table->string('eid'); // employee identification number
            $table->string('name'); // company name
            $table->integer('credit_checkbox'); // Can be 1,2,3
            $table->integer('quarter'); // Can be 1,2,3,4
            $table->string('part_one'); // Stores array of objects serialized
            $table->string('part_one_total');
            $table->string('seven');
            $table->string('eight');
            $table->string('nine');
            $table->string('ten');
            $table->string('eleven');
            $table->string('eleven_checkbox');
            $table->string('twelve');
        });

        Schema::table('stored_forms8974s', function($table) {
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
        Schema::dropIfExists('stored_forms8974s');
    }
}