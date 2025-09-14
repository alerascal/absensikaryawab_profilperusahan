<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttendanceLocationIdToAttendances extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('attendance_location_id')->nullable()->after('schedule_id');

            $table->foreign('attendance_location_id')
                  ->references('id')
                  ->on('attendance_locations')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['attendance_location_id']);
            $table->dropColumn('attendance_location_id');
        });
    }
}
