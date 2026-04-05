<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('absensis')) {
            Schema::create('absensis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('siswa_id')->constrained('users');
                $table->foreignId('kelompok_siswa_id')->constrained('kelompok_siswas');
                $table->date('tanggal');
                $table->time('jam_masuk')->nullable();
                $table->time('jam_keluar')->nullable();
                $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('hadir');
                $table->text('keterangan')->nullable();
                $table->string('bukti_foto')->nullable();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->string('lokasi_absen')->nullable();
                $table->boolean('is_valid_location')->default(false);
                $table->foreignId('dosen_id')->nullable()->constrained('dosens');
                $table->timestamp('dosen_absen_at')->nullable();
                $table->timestamps();
                
                $table->unique(['siswa_id', 'tanggal']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};