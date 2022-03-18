<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToStoredForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stored_forms', function (Blueprint $table) {
        $table->string('thirteen_h')->nullable();
        $table->string('thirteen_i')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stored_forms', function (Blueprint $table) {
            $table->dropColumn('thirteen_h');
            $table->dropColumn('thirteen_i');
        });
    }
}