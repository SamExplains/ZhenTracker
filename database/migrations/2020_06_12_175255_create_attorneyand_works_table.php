<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttorneyandWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attorneyand_works', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->text('file_one_url');
            $table->timestamps();
        });

      Schema::table('attorneyand_works', function($table) {
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
        Schema::dropIfExists('attorneyand_works');
    }
}
