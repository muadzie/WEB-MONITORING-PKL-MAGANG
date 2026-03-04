<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_siswa_id')->constrained('kelompok_siswas')->onDelete('cascade');
            $table->string('judul_laporan');
            $table->text('abstrak');
            $table->string('file_laporan');
            $table->string('file_presentasi')->nullable();
            $table->enum('status', ['draft', 'diajukan', 'direview', 'direvisi', 'disetujui', 'ditolak'])->default('draft');
            $table->text('catatan_revisi')->nullable();
            $table->foreignId('reviewer_dosen_id')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};