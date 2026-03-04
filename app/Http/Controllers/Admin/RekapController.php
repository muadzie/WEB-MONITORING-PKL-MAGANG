<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Perusahaan;
use App\Models\KelompokPkl;
use App\Models\Logbook;
use App\Models\Laporan;
use App\Models\Penilaian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class RekapController extends Controller
{
    /**
     * Rekap data siswa.
     */
    public function siswa(Request $request)
    {
        $query = User::where('role', 'siswa')
                ->with(['kelompokSiswa.kelompok']);
        
        if ($request->filled('angkatan')) {
            $query->whereYear('created_at', $request->angkatan);
        }
        
        if ($request->filled('prodi')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('prodi', 'like', '%' . $request->prodi . '%');
            });
        }
        
        $siswas = $query->get();
        
        $total = $siswas->count();
        $sudahKelompok = $siswas->filter(function($siswa) {
            return $siswa->kelompokSiswa->isNotEmpty();
        })->count();
        
        $belumKelompok = $total - $sudahKelompok;
        
        $statistik = [
            'total' => $total,
            'sudah_kelompok' => $sudahKelompok,
            'belum_kelompok' => $belumKelompok,
        ];
        
        return view('admin.rekap.siswa', compact('siswas', 'statistik'));
    }

    /**
     * Rekap data kelompok.
     */
    public function kelompok(Request $request)
{
    $query = KelompokPkl::with(['dosen', 'perusahaan', 'anggota'])
            ->withCount('anggota');
    
    if ($request->filled('tahun')) {
        $query->whereYear('created_at', $request->tahun);
    }
    
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    $kelompoks = $query->paginate(15)->withQueryString();
    
    $statistik = [
        'total' => KelompokPkl::count(),
        'aktif' => KelompokPkl::where('status', 'aktif')->count(),
        'pending' => KelompokPkl::where('status', 'pending')->count(),
        'selesai' => KelompokPkl::where('status', 'selesai')->count(),
        'dibatalkan' => KelompokPkl::where('status', 'dibatalkan')->count(),
    ];
    
    return view('admin.rekap.kelompok', compact('kelompoks', 'statistik'));
}

    /**
     * Rekap data logbook.
     */
    public function logbook(Request $request)
    {
        $query = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok']);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $logbooks = $query->orderBy('tanggal', 'desc')->get();
        
        $statistik = [
            'total' => $logbooks->count(),
            'pending' => $logbooks->where('status', 'pending')->count(),
            'disetujui' => $logbooks->where('status', 'disetujui')->count(),
            'ditolak' => $logbooks->where('status', 'ditolak')->count(),
        ];
        
        return view('admin.rekap.logbook', compact('logbooks', 'statistik'));
    }

    /**
     * Rekap data nilai.
     */
    public function nilai(Request $request)
    {
        $query = Penilaian::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok', 'penilaiUser']);
        
        if ($request->filled('kelompok_id')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('kelompok_pkl_id', $request->kelompok_id);
            });
        }
        
        if ($request->filled('penilai')) {
            $query->where('penilai', $request->penilai);
        }
        
        $penilaians = $query->get();
        
        // Hitung statistik nilai
        $nilaiDosen = $penilaians->where('penilai', 'dosen');
        $nilaiPt = $penilaians->where('penilai', 'pt');
        
        $statistik = [
            'total_penilaian' => $penilaians->count(),
            'total_dosen' => $nilaiDosen->count(),
            'total_pt' => $nilaiPt->count(),
            'rata_dosen' => $nilaiDosen->avg('nilai_akhir'),
            'rata_pt' => $nilaiPt->avg('nilai_akhir'),
        ];
        
        return view('admin.rekap.nilai', compact('penilaians', 'statistik'));
    }

    /**
     * Rekap data perusahaan.
     */
    public function perusahaan(Request $request)
    {
        $query = Perusahaan::withCount('kelompokPkls');
        
        if ($request->filled('bidang_usaha')) {
            $query->where('bidang_usaha', 'like', '%' . $request->bidang_usaha . '%');
        }
        
        $perusahaans = $query->get();
        
        $statistik = [
            'total' => $perusahaans->count(),
            'aktif' => $perusahaans->where('is_active', true)->count(),
            'nonaktif' => $perusahaans->where('is_active', false)->count(),
            'total_kelompok' => $perusahaans->sum('kelompok_pkls_count'),
        ];
        
        return view('admin.rekap.perusahaan', compact('perusahaans', 'statistik'));
    }

    /**
     * Rekap tahunan.
     */
    public function tahunan(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');
        
        // Data per bulan
        $kelompokPerBulan = KelompokPkl::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', $tahun)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();
        
        $logbookPerBulan = Logbook::select(
            DB::raw('MONTH(tanggal) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('tanggal', $tahun)
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();
        
        // Statistik umum
        $statistik = [
            'tahun' => $tahun,
            'total_siswa' => User::where('role', 'siswa')->whereYear('created_at', $tahun)->count(),
            'total_kelompok' => KelompokPkl::whereYear('created_at', $tahun)->count(),
            'total_logbook' => Logbook::whereYear('created_at', $tahun)->count(),
            'total_laporan' => Laporan::whereYear('created_at', $tahun)->count(),
        ];
        
        return view('admin.rekap.tahunan', compact('tahun', 'statistik', 'kelompokPerBulan', 'logbookPerBulan'));
    }

    /**
     * Export rekap data.
     */
    public function export($type)
    {
        // Logika export sesuai tipe
        $filename = 'rekap-' . $type . '-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $handle = fopen('php://output', 'w');
        
        switch ($type) {
            case 'siswa':
                fputcsv($handle, ['No', 'NIM', 'Nama', 'Email', 'Telepon', 'Kelompok', 'Status']);
                $siswas = User::where('role', 'siswa')->with('kelompokSiswa.kelompok')->get();
                foreach ($siswas as $index => $siswa) {
                    fputcsv($handle, [
                        $index + 1,
                        $siswa->nomor_induk,
                        $siswa->name,
                        $siswa->email,
                        $siswa->phone ?? '-',
                        $siswa->kelompokSiswa->first()?->kelompok->nama_kelompok ?? '-',
                        $siswa->is_active ? 'Aktif' : 'Nonaktif'
                    ]);
                }
                break;
                
            case 'kelompok':
                fputcsv($handle, ['No', 'Nama Kelompok', 'Dosen', 'Perusahaan', 'Jumlah Anggota', 'Periode', 'Status']);
                $kelompoks = KelompokPkl::with(['dosen', 'perusahaan', 'anggota'])->get();
                foreach ($kelompoks as $index => $k) {
                    fputcsv($handle, [
                        $index + 1,
                        $k->nama_kelompok,
                        $k->dosen->nama_dosen ?? '-',
                        $k->perusahaan->nama_perusahaan ?? '-',
                        $k->anggota->count(),
                        $k->tanggal_mulai->format('d/m/Y') . ' - ' . $k->tanggal_selesai->format('d/m/Y'),
                        ucfirst($k->status)
                    ]);
                }
                break;
        }
        
        fclose($handle);
        return Response::make('', 200, $headers);
    }
}