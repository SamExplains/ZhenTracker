<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayrollAndTaxProvidersToCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company', function (Blueprint $table) {
            $table->string('payroll_provider_company_name', 75)->nullable();
            $table->string('payroll_provider_individual_name', 75)->nullable();
            $table->string('payroll_provider_email', 75)->nullable();
            $table->string('payroll_provider_phone', 15)->nullable();

            $table->string('tax_provider_company_name', 75)->nullable();
            $table->string('tax_provider_individual_name', 75)->nullable();
            $table->string('tax_provider_email', 75)->nullable();
            $table->string('tax_provider_phone', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn([
              'payroll_provider_company_name',
              'payroll_provider_individual_name',
              'payroll_provider_email',
              'payroll_provider_phone',
              'tax_provider_company_name',
              'tax_provider_individual_name',
              'tax_provider_email',
              'tax_provider_phone',
            ]);
        });
    }
}
