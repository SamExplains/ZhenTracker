<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToRdcreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rdcredits', function (Blueprint $table) {
          $table->string('study_year', 15)->nullable();
          $table->string('fees', 15)->nullable();
          $table->string('payment_date', 15)->nullable();
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
            $table->dropColumn('study_year');
            $table->dropColumn('fees');
            $table->dropColumn('payment_date');
        });
    }
}
