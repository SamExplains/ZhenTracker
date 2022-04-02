<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->mediumText('description');
            $table->string('start_time');
            $table->string('end_time');
            $table->mediumText('first_image')->nullable();
            $table->mediumText('second_image')->nullable();
            $table->string('address');
            $table->string('city');
            $table->string('zip');
            $table->boolean('public_private');
            $table->boolean('on_off_line');
            $table->boolean('check_in');
            $table->string('capacity');
            $table->string('url');
            $table->string('additional_items');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->mediumText('qrcode');
            $table->longText('registered')->nullable();
            $table->longText('checked_in')->nullable();
            $table->unsignedInteger('creator_id');
            $table->string('event_key');

        });

        Schema::table('events', function ($table) {
            $table->foreign('creator_id')->references('id')->on('standard_signups')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}