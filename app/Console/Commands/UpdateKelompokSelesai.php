<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KelompokPkl;
use Carbon\Carbon;

class UpdateKelompokSelesai extends Command
{
    protected $signature = 'pkl:selesaikan';
    protected $description = 'Mengubah status kelompok PKL menjadi Selesai jika tanggal selesai sudah lewat';

    public function handle()
    {
        $today = Carbon::today();

        $kelompokExpired = KelompokPkl::where('tanggal_selesai', '<', $today)
                                      ->where('status', 'aktif')
                                      ->get();

        if ($kelompokExpired->isEmpty()) {
            $this->info('Tidak ada kelompok yang perlu diselesaikan.');
            return;
        }

        $count = 0;
        foreach ($kelompokExpired as $kelompok) {
            $kelompok->update(['status' => 'selesai']);
            $count++;
        }

        $this->info("Berhasil menyelesaikan {$count} kelompok PKL.");
    }
}