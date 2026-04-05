<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\KelompokPkl;
use App\Models\User;
use App\Models\KelompokSiswa;
use App\Models\Notifikasi;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiExport;

class AbsensiDosenController extends Controller
{
    protected $dosen;

    protected function initDosen()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role !== 'dosen') {
                abort(403, 'Anda bukan dosen');
            }
            $this->dosen = $user->dosen;
            if (!$this->dosen) {
                abort(404, 'Data dosen tidak ditemukan.');
            }
        }
    }

    public function index(Request $request)
    {
        $this->initDosen();
        
        $dosenId = $this->dosen->id;
        
        $query = KelompokPkl::with(['anggota.siswa'])
                 ->where('dosen_id', $dosenId);
        
        if ($request->filled('kelompok_id')) {
            $query->where('id', $request->kelompok_id);
        }
        
        $kelompoks = $query->get();
        
        $selectedKelompok = null;
        $siswas = collect();
        
        if ($request->filled('kelompok_id')) {
            $selectedKelompok = KelompokPkl::with(['anggota.siswa'])->find($request->kelompok_id);
            $siswas = $selectedKelompok->anggota->map(function($item) {
                $item->siswa->absensi_hari_ini = Absensi::where('siswa_id', $item->siswa_id)
                                                    ->whereDate('tanggal', Carbon::today())
                                                    ->first();
                return $item->siswa;
            });
        }
        
        return view('dosen.absensi.index', compact('kelompoks', 'selectedKelompok', 'siswas'));
    }

    public function absenSiswa(Request $request, $siswaId)
    {
        $this->initDosen();
        
        $siswa = User::findOrFail($siswaId);
        $kelompokSiswa = KelompokSiswa::where('siswa_id', $siswaId)->first();
        
        if (!$kelompokSiswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan dalam kelompok'], 400);
        }
        
        $today = Carbon::today();
        $existing = Absensi::where('siswa_id', $siswaId)
                    ->whereDate('tanggal', $today)
                    ->first();
        
        if ($existing) {
            return response()->json(['error' => 'Siswa sudah absen hari ini'], 400);
        }
        
        $absensi = Absensi::create([
            'siswa_id' => $siswaId,
            'kelompok_siswa_id' => $kelompokSiswa->id,
            'tanggal' => $today,
            'jam_masuk' => now(),
            'dosen_id' => $this->dosen->id,
            'dosen_absen_at' => now(),
            'status' => 'hadir',
            'is_valid_location' => true,
        ]);
        
        // Notifikasi ke siswa
        Notifikasi::create([
            'user_id' => $siswaId,
            'judul' => 'Absensi oleh Dosen',
            'pesan' => 'Anda telah diabsensi oleh dosen pembimbing pada hari ini',
            'tipe' => 'success',
            'url' => route('siswa.absensi.index'),
        ]);
        
        return response()->json(['success' => true, 'message' => 'Absen berhasil']);
    }

    public function rekap(Request $request)
    {
        $this->initDosen();
        
        $dosenId = $this->dosen->id;
        
        $kelompokIds = KelompokPkl::where('dosen_id', $dosenId)->pluck('id');
        $siswaIds = KelompokSiswa::whereIn('kelompok_pkl_id', $kelompokIds)->pluck('siswa_id');
        
        $query = Absensi::with(['siswa', 'kelompokSiswa.kelompok'])
                 ->whereIn('siswa_id', $siswaIds);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }
        
        $absensis = $query->orderBy('tanggal', 'desc')->paginate(20);
        
        $siswas = User::whereIn('id', $siswaIds)->orderBy('name')->get();
        
        $statistik = [
            'total_hadir' => $query->where('status', 'hadir')->count(),
            'total_izin' => $query->where('status', 'izin')->count(),
            'total_sakit' => $query->where('status', 'sakit')->count(),
            'total_alpha' => $query->where('status', 'alpha')->count(),
        ];
        
        return view('dosen.absensi.rekap', compact('absensis', 'siswas', 'statistik'));
    }

   public function exportExcel(Request $request)
{
    $this->initDosen();
    
    $dosenId = $this->dosen->id;
    $kelompokIds = KelompokPkl::where('dosen_id', $dosenId)->pluck('id');
    $siswaIds = KelompokSiswa::whereIn('kelompok_pkl_id', $kelompokIds)->pluck('siswa_id');
    
    $query = Absensi::with(['siswa', 'kelompokSiswa.kelompok'])
             ->whereIn('siswa_id', $siswaIds);
    
    if ($request->filled('tanggal_mulai')) {
        $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
    }
    
    if ($request->filled('tanggal_selesai')) {
        $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
    }
    
    if ($request->filled('siswa_id')) {
        $query->where('siswa_id', $request->siswa_id);
    }
    
    $absensis = $query->orderBy('tanggal', 'desc')->get();
    
    $filename = 'rekap-absensi-' . date('Y-m-d') . '.csv';
    
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];
    
    $callback = function() use ($absensis) {
        $handle = fopen('php://output', 'w');
        
        // Header CSV (UTF-8 BOM for Excel compatibility)
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($handle, [
            'No', 'Nama Siswa', 'NIM', 'Kelompok', 'Tanggal', 
            'Jam Masuk', 'Jam Keluar', 'Status', 'Keterangan', 'Validasi Lokasi'
        ]);
        
        foreach ($absensis as $index => $absen) {
            fputcsv($handle, [
                $index + 1,
                $absen->siswa->name,
                $absen->siswa->nomor_induk,
                $absen->kelompokSiswa->kelompok->nama_kelompok,
                \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y'),
                $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i:s') : '-',
                $absen->jam_keluar ? \Carbon\Carbon::parse($absen->jam_keluar)->format('H:i:s') : '-',
                ucfirst($absen->status),
                $absen->keterangan ?? '-',
                $absen->is_valid_location ? 'Valid' : 'Tidak Valid'
            ]);
        }
        
        fclose($handle);
    };
    
    return response()->stream($callback, 200, $headers);
}
}