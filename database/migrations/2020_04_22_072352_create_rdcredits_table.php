<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRdcreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdcredits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('company_id');
            $table->string('return_type', 5);
            $table->string('quarter', 2);
            $table->string('year');
            $table->date('period');
            $table->date('date_return_filed');
            $table->string('credit_amount');
            $table->string('credit_claimed');
            $table->string('credit_available');
            $table->string('credit_received');


        });

        Schema::table('rdcredits', function($table) {
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
        Schema::dropIfExists('rdcredits');
    }
}
