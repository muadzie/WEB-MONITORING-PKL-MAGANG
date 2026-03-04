<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_siswa_id')->constrained('kelompok_siswas')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('kegiatan');
            $table->text('deskripsi');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('dokumentasi')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_dosen')->nullable();
            $table->text('catatan_pt')->nullable();
            $table->foreignId('approved_by_dosen')->nullable()->constrained('users');
            $table->foreignId('approved_by_pt')->nullable()->constrained('users');
            $table->timestamp('approved_at_dosen')->nullable();
            $table->timestamp('approved_at_pt')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};