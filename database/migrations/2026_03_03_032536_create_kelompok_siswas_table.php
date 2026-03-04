<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_pkl_id')->constrained('kelompok_pkls')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('users');
            $table->string('nim')->unique();
            $table->string('kelas');
            $table->string('prodi');
            $table->enum('status_anggota', ['ketua', 'anggota'])->default('anggota');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_siswas');
    }
};