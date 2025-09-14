<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAttendancesTableWithGpsMetadata extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Tambah kolom metadata GPS
            $table->decimal('latitude', 10, 8)->nullable()->after('location');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->float('gps_accuracy', 8, 2)->nullable()->after('longitude')->comment('GPS accuracy in meters');
            $table->float('distance_to_location', 8, 2)->nullable()->after('gps_accuracy')->comment('Distance to nearest attendance location in meters');
            $table->float('altitude', 8, 2)->nullable()->after('distance_to_location')->comment('Altitude in meters');
            $table->float('heading', 5, 2)->nullable()->after('altitude')->comment('Heading/bearing in degrees (0-360)');
            $table->float('speed', 6, 2)->nullable()->after('heading')->comment('Speed in m/s');

            // Tambah index untuk mempercepat query berdasarkan koordinat
            $table->index(['latitude', 'longitude'], 'idx_attendance_coordinates');
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropIndex('idx_attendance_coordinates');
            $table->dropColumn([
                'latitude',
                'longitude',
                'gps_accuracy',
                'distance_to_location',
                'altitude',
                'heading',
                'speed',
            ]);
        });
    }
}
