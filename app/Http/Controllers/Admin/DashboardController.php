<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KelompokPkl;
use App\Models\Logbook;
use App\Models\Laporan;
use App\Models\Perusahaan;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalDosen = User::where('role', 'dosen')->count();
        $totalPT = User::where('role', 'pt')->count();
        $totalPerusahaan = Perusahaan::count();
        
        // Statistik Kelompok
        $totalKelompok = KelompokPkl::count();
        $kelompokAktif = KelompokPkl::where('status', 'aktif')->count();
        $kelompokPending = KelompokPkl::where('status', 'pending')->count();
        $kelompokSelesai = KelompokPkl::where('status', 'selesai')->count();
        
        // Statistik Logbook
        $logbookPending = Logbook::where('status', 'pending')->count();
        $logbookDisetujui = Logbook::where('status', 'disetujui')->count();
        $logbookDitolak = Logbook::where('status', 'ditolak')->count();
        
        // Statistik Laporan
        $laporanDiajukan = Laporan::where('status', 'diajukan')->count();
        $laporanDireview = Laporan::where('status', 'direview')->count();
        $laporanDisetujui = Laporan::where('status', 'disetujui')->count();
        
        // Grafik Pendaftaran per Bulan
        $pendaftaranPerBulan = KelompokPkl::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();
        
        // 5 Kelompok Terbaru
        $kelompokTerbaru = KelompokPkl::with(['dosen', 'perusahaan'])
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
        
        // 5 Logbook Terbaru
        $logbookTerbaru = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                          ->orderBy('created_at', 'desc')
                          ->limit(5)
                          ->get();
        
        return view('admin.dashboard', compact(
            'totalSiswa', 'totalDosen', 'totalPT', 'totalPerusahaan',
            'totalKelompok', 'kelompokAktif', 'kelompokPending', 'kelompokSelesai',
            'logbookPending', 'logbookDisetujui', 'logbookDitolak',
            'laporanDiajukan', 'laporanDireview', 'laporanDisetujui',
            'pendaftaranPerBulan', 'kelompokTerbaru', 'logbookTerbaru'
        ));
    }
}