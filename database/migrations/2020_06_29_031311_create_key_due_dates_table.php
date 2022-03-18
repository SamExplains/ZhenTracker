<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeyDueDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('key_due_dates', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->string('date', 15);
            $table->string('title', 125);
            $table->string('description', 125);
            $table->timestamps();
        });

      Schema::table('key_due_dates', function($table) {
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
        Schema::dropIfExists('key_due_dates');
    }
}
