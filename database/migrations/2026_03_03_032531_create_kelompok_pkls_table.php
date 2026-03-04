<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_pkls', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok');
            $table->foreignId('dosen_id')->constrained('dosens');
            $table->foreignId('perusahaan_id')->constrained('perusahaans');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['pending', 'aktif', 'selesai', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_pkls');
    }
};