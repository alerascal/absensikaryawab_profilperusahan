<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_fulltime')->default(false); // Flag for full-time schedule
            $table->unsignedBigInteger('shift_id')->nullable(); // Reference to shift
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('schedule_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('schedule_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_user');
        Schema::dropIfExists('schedules');
    }
}