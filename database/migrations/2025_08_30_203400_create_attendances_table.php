<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('status'); // Hadir, Terlambat, Absen, WFH, Cuti
            $table->string('location');
            $table->date('date');
            $table->string('photo_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}