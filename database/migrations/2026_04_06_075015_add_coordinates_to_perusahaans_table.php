<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perusahaans', function (Blueprint $table) {
            if (!Schema::hasColumn('perusahaans', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('perusahaans', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
        });
    }

    public function down(): void
    {
        Schema::table('perusahaans', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};