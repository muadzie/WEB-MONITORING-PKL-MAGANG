<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Perusahaan;
use App\Models\KelompokPkl;
use App\Models\KelompokSiswa;
use App\Models\Logbook;
use App\Models\Laporan;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            DosenSeeder::class,
            PerusahaanSeeder::class,
            KelompokSeeder::class,
          //  LogbookSeeder::class, // Tambahkan jika perlu
            LaporanSeeder::class,  // Tambahkan jika perlu
              PenilaianSeeder::class,
               NotifikasiSeeder::class,
        ]);
    }
}