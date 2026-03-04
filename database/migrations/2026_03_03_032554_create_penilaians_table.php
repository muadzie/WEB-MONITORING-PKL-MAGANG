<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelompok_siswa_id')->constrained('kelompok_siswas')->onDelete('cascade');
            $table->enum('penilai', ['dosen', 'pt']);
            
            // Aspek Penilaian Dosen
            $table->integer('nilai_laporan')->nullable();
            $table->integer('nilai_presentasi')->nullable();
            $table->integer('nilai_sikap')->nullable();
            
            // Aspek Penilaian PT
            $table->integer('nilai_kinerja')->nullable();
            $table->integer('nilai_kedisiplinan')->nullable();
            $table->integer('nilai_kerjasama')->nullable();
            $table->integer('nilai_inisiatif')->nullable();
            
            $table->float('nilai_akhir')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('penilai_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};