<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dosens', function (Blueprint $table) {
            if (!Schema::hasColumn('dosens', 'jurusan')) {
                $table->string('jurusan')->nullable();
            }
            if (!Schema::hasColumn('dosens', 'fakultas')) {
                $table->string('fakultas')->nullable();
            }
            if (!Schema::hasColumn('dosens', 'gelar_depan')) {
                $table->string('gelar_depan')->nullable();
            }
            if (!Schema::hasColumn('dosens', 'gelar_belakang')) {
                $table->string('gelar_belakang')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('dosens', function (Blueprint $table) {
            $table->dropColumn(['jurusan', 'fakultas', 'gelar_depan', 'gelar_belakang']);
        });
    }
};