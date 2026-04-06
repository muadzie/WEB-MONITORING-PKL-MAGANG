<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom dosen_id menjadi nullable
        Schema::table('kelompok_pkls', function (Blueprint $table) {
            $table->unsignedBigInteger('dosen_id')->nullable()->change();
        });
        
        // Ubah juga kolom perusahaan_id menjadi nullable (opsional)
        Schema::table('kelompok_pkls', function (Blueprint $table) {
            $table->unsignedBigInteger('perusahaan_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('kelompok_pkls', function (Blueprint $table) {
            $table->unsignedBigInteger('dosen_id')->nullable(false)->change();
            $table->unsignedBigInteger('perusahaan_id')->nullable(false)->change();
        });
    }
};