<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ijin_sakit')) {
            Schema::create('ijin_sakit', function (Blueprint $table) {
                $table->id();
                $table->foreignId('siswa_id')->constrained('users');
                $table->foreignId('kelompok_siswa_id')->constrained('kelompok_siswas');
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->enum('jenis', ['izin', 'sakit']);
                $table->text('alasan');
                $table->string('bukti_foto')->nullable();
                $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
                $table->text('catatan_dosen')->nullable();
                $table->foreignId('approved_by')->nullable()->constrained('users');
                $table->timestamp('approved_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ijin_sakit');
    }
};