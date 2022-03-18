<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 128)->unique();
            $table->string('ein', 9)->unique();
            $table->date('business_start_date');
            $table->date('business_first_year_end_date');
            $table->date('first_income_year');
            $table->date('final_date_payroll_claim');  // first year end date + 5 years
            $table->char('company_type', 1);
            $table->string('email');
            $table->string('phone');
            $table->string('officer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company');
    }
}
