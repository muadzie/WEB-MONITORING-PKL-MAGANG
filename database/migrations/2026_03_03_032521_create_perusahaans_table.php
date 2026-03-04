<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perusahaans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');
            $table->string('alamat');
            $table->string('telepon');
            $table->string('email')->unique();
            $table->string('bidang_usaha');
            $table->text('deskripsi')->nullable();
            $table->string('kontak_person');
            $table->string('jabatan_kontak');
            $table->string('logo')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perusahaans');
    }
};