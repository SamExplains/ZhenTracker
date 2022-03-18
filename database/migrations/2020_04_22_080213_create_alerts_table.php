<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('company_id');
            $table->string('company_name', 125);
            $table->string('company_ein', 9);
            $table->string('title', 125);
            $table->string('body', 256);
        });

      Schema::table('alerts', function($table) {
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
        Schema::dropIfExists('alerts');
    }
}
