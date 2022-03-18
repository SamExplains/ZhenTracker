<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('uid');
        $table->string('name');
        $table->string('email')->unique();
        $table->longText('photoURL')->nullable();
        $table->longText('description')->nullable();
        $table->bigInteger('registration_date');
        $table->bigInteger('points')->default(0);
        $table->string('status');
        $table->boolean('online')->default(0);
        $table->string('password')->default('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); // password
        $table->string('signup_procedure')->default('app');
        $table->string('disabled')->nullable();
        $table->timestamp('email_verified_at')->nullable();
        $table->rememberToken();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
