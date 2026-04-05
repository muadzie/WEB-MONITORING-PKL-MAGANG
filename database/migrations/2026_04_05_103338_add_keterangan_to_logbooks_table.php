<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            // Cek apakah kolom status_hari sudah ada
            if (!Schema::hasColumn('logbooks', 'status_hari')) {
                $table->enum('status_hari', ['normal', 'izin', 'sakit'])->default('normal')->after('status');
            }
            
            // Cek apakah kolom ijin_sakit_id sudah ada
            if (!Schema::hasColumn('logbooks', 'ijin_sakit_id')) {
                $table->unsignedBigInteger('ijin_sakit_id')->nullable()->after('status_hari');
            }
        });
    }

    public function down(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table->dropColumn(['status_hari', 'ijin_sakit_id']);
        });
    }
};