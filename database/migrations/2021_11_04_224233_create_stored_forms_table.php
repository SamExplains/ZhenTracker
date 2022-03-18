<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoredFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stored_forms', function (Blueprint $table) {
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
            $table->string('trade_name')->nullable(); // trade name , nullable
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zip');
            $table->string('foreign_country_name')->nullable();
            $table->string('foreign_country_providence')->nullable();
            $table->string('foreign_country_postal_code')->nullable();
            $table->integer('quarter'); // Can be 1,2,3,4
            $table->string('one');
            $table->string('two');
            $table->string('three');
            $table->string('four'); // stored as `checked` or `not-checked`
            $table->string('five_a')->nullable();
            $table->string('five_aa')->nullable();
            $table->string('five_aaa')->nullable();
            $table->string('five_b')->nullable();
            $table->string('five_c')->nullable();
            $table->string('five_d')->nullable();
            $table->string('five_e');
            $table->string('five_f')->nullable();
            $table->string('six');
            $table->string('seven')->nullable();
            $table->string('eight')->nullable();
            $table->string('nine')->nullable();
            $table->string('ten');
            $table->string('eleven_a')->nullable();
            $table->string('eleven_b')->nullable();
            $table->string('eleven_c')->nullable();
            $table->string('eleven_d')->nullable();
            $table->string('eleven_g')->nullable();
            $table->string('twelve');
            $table->string('thirteen');
            $table->string('thirteen_b')->nullable();
            $table->string('thirteen_c')->nullable();
            $table->string('thirteen_d')->nullable();
            $table->string('thirteen_e')->nullable();
            $table->string('thirteen_f')->nullable();
            $table->string('thirteen_g')->nullable();
            $table->string('fourteen');
            $table->string('fifteen');
            $table->integer('fifteen_checkbox');
            /**
             * #16
             * This will have 3 columns. One for each option where (B) has 3 fields.
             * All these are nullable
             */
            $table->boolean('sixteen_a')->nullable();
            $table->boolean('sixteen_b')->nullable();
            $table->string('sixteen_b_month_1')->nullable();
            $table->string('sixteen_b_month_2')->nullable();
            $table->string('sixteen_b_month_3')->nullable();
            $table->string('sixteen_b_sum')->nullable();
            $table->boolean('sixteen_c')->nullable();


        });

        Schema::table('stored_forms', function($table) {
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
        Schema::dropIfExists('stored_forms');
    }
}
