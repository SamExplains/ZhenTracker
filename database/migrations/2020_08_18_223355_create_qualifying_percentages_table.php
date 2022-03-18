<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualifyingPercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualifying_percentages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('company_id');
            $table->unsignedInteger('qq_id');
            $table->mediumText('projects')->nullable();
            $table->mediumText('allocations')->nullable();
            $table->timestamps();
        });

        Schema::table('qualifying_percentages', function($table) {
          $table->foreign('qq_id')->references('id')->on('qualifying_questions_years')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qualifying_percentages');
    }
}
