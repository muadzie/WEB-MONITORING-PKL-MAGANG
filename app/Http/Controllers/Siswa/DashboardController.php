<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KelompokSiswa;
use App\Models\Logbook;
use App\Models\Laporan;
use App\Models\Penilaian;

class DashboardController extends Controller
{
    /**
     * Display the siswa dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data kelompok siswa
        $kelompokSiswa = KelompokSiswa::with(['kelompok.dosen', 'kelompok.perusahaan'])
                          ->where('siswa_id', $user->id)
                          ->first();
        
        $kelompok = $kelompokSiswa ? $kelompokSiswa->kelompok : null;
        
        // Statistik logbook
        $totalLogbook = 0;
        $logbookDisetujui = 0;
        $logbookPending = 0;
        $logbookDitolak = 0;
        
        if ($kelompokSiswa) {
            $totalLogbook = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)->count();
            $logbookDisetujui = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                                ->where('status', 'disetujui')
                                ->count();
            $logbookPending = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                              ->where('status', 'pending')
                              ->count();
            $logbookDitolak = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                              ->where('status', 'ditolak')
                              ->count();
        }
        
        // Ambil laporan
        $laporan = null;
        if ($kelompokSiswa) {
            $laporan = Laporan::where('kelompok_siswa_id', $kelompokSiswa->id)->first();
        }
        
        // Ambil penilaian
        $penilaianDosen = null;
        $penilaianPt = null;
        
        if ($kelompokSiswa) {
            $penilaianDosen = Penilaian::where('kelompok_siswa_id', $kelompokSiswa->id)
                              ->where('penilai', 'dosen')
                              ->first();
            
            $penilaianPt = Penilaian::where('kelompok_siswa_id', $kelompokSiswa->id)
                           ->where('penilai', 'pt')
                           ->first();
        }
        
        // Logbook terbaru
        $logbooksTerbaru = [];
        if ($kelompokSiswa) {
            $logbooksTerbaru = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                               ->orderBy('tanggal', 'desc')
                               ->orderBy('created_at', 'desc')
                               ->limit(5)
                               ->get();
        }
        
        return view('siswa.dashboard', compact(
            'user',
            'kelompok',
            'kelompokSiswa',
            'totalLogbook',
            'logbookDisetujui',
            'logbookPending',
            'logbookDitolak',
            'laporan',
            'penilaianDosen',
            'penilaianPt',
            'logbooksTerbaru'
        ));
    }
}