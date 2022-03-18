<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditsAdvancedToRdcreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rdcredits', function (Blueprint $table) {
            $table->string('credits_advanced');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rdcredits', function (Blueprint $table) {
            //
            $table->dropIfExists('credits_advanced');
        });
    }
}