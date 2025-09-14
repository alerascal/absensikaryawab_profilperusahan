<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Add GPS-related columns if they don't exist
            if (!Schema::hasColumn('attendances', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('photo_path');
            }
            if (!Schema::hasColumn('attendances', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('attendances', 'accuracy')) {
                $table->decimal('accuracy', 8, 2)->nullable()->after('longitude');
            }
            if (!Schema::hasColumn('attendances', 'altitude')) {
                $table->decimal('altitude', 8, 2)->nullable()->after('accuracy');
            }
            if (!Schema::hasColumn('attendances', 'heading')) {
                $table->decimal('heading', 5, 2)->nullable()->after('altitude');
            }
            if (!Schema::hasColumn('attendances', 'speed')) {
                $table->decimal('speed', 6, 2)->nullable()->after('heading');
            }
            if (!Schema::hasColumn('attendances', 'notes')) {
                $table->text('notes')->nullable()->after('speed');
            }
            
            // Add index for better performance
            $table->index(['user_id', 'date']);
            $table->index(['attendance_location_id']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude', 
                'accuracy',
                'altitude',
                'heading',
                'speed',
                'notes'
            ]);
            
            $table->dropIndex(['user_id', 'date']);
            $table->dropIndex(['attendance_location_id']);
            $table->dropIndex(['status']);
        });
    }
};