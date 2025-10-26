<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Pastikan kolom location ada dulu
            if (Schema::hasColumn('attendances', 'location')) {
                $table->string('location')->default('Tidak diketahui')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (Schema::hasColumn('attendances', 'location')) {
                $table->string('location')->nullable(false)->default(null)->change();
            }
        });
    }
};
