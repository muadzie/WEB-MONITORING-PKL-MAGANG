<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table->enum('approval_dosen', ['pending', 'disetujui', 'ditolak'])->default('pending')->after('status');
            $table->enum('approval_pt', ['pending', 'disetujui', 'ditolak'])->default('pending')->after('approval_dosen');
        });
    }

    public function down(): void
    {
        Schema::table('logbooks', function (Blueprint $table) {
            $table->dropColumn(['approval_dosen', 'approval_pt']);
        });
    }
};