<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KelompokPkl;
use App\Models\Logbook;
use App\Models\Laporan;
use App\Models\Dosen;

class BimbinganController extends Controller
{
    protected $dosen;
    
    /**
     * Constructor - untuk Laravel 11 tidak perlu middleware di sini
     * karena middleware sudah didefinisikan di routes
     */
    public function __construct()
    {
        // Tidak perlu memanggil $this->middleware() di Laravel 11
        // Cukup inisialisasi properti jika diperlukan
    }
    
    /**
     * Initialize dosen data - panggil di setiap method yang membutuhkan
     */
    protected function initDosen()
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Cek apakah user adalah dosen
            if ($user->role !== 'dosen') {
                abort(403, 'Anda bukan dosen');
            }
            
            // Ambil data dosen dari relasi
            $this->dosen = $user->dosen;
            
            // Jika tidak ada data dosen, tampilkan error
            if (!$this->dosen) {
                abort(404, 'Data dosen tidak ditemukan. Silakan hubungi admin.');
            }
        } else {
            abort(401, 'Silakan login terlebih dahulu');
        }
    }
    
    /**
     * Display a listing of bimbingan.
     */
   public function dashboard()
{
    $this->initDosen();
    
    $dosenId = $this->dosen->id;
    
    $totalKelompok = KelompokPkl::where('dosen_id', $dosenId)->count();
    $kelompokAktif = KelompokPkl::where('dosen_id', $dosenId)
                      ->where('status', 'aktif')->count();
    
    $logbookPending = Logbook::whereHas('kelompokSiswa.kelompok', function($q) use ($dosenId) {
                            $q->where('dosen_id', $dosenId);
                        })->where('status', 'pending')->count();
    
    $laporanPending = Laporan::whereHas('kelompokSiswa.kelompok', function($q) use ($dosenId) {
                            $q->where('dosen_id', $dosenId);
                        })->whereIn('status', ['diajukan', 'direvisi'])->count();
    
    // Tambahkan data untuk tabel terbaru
    $kelompokTerbaru = KelompokPkl::with(['perusahaan', 'anggota'])
                        ->where('dosen_id', $dosenId)
                        ->orderBy('created_at', 'desc')
                        ->limit(5)
                        ->get();
    
    $logbookTerbaru = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                        ->whereHas('kelompokSiswa.kelompok', function($q) use ($dosenId) {
                            $q->where('dosen_id', $dosenId);
                        })
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get();
    
    return view('dosen.dashboard', compact(
        'totalKelompok', 
        'kelompokAktif', 
        'logbookPending', 
        'laporanPending',
        'kelompokTerbaru',  // Tambahkan ini
        'logbookTerbaru'    // Tambahkan ini
    ));
}
    
    /**
     * Display list of bimbingan.
     */
    public function index()
    {
        $this->initDosen();
        
        $kelompoks = KelompokPkl::with(['perusahaan', 'anggota.siswa'])
                     ->where('dosen_id', $this->dosen->id)
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
        
        return view('dosen.bimbingan.index', compact('kelompoks'));
    }
    
    /**
     * Display the specified bimbingan.
     */
    public function show(KelompokPkl $kelompok)
    {
        $this->initDosen();
        
        // Cek kepemilikan
        if ($kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $kelompok->load(['perusahaan', 'anggota.siswa']);
        
        $logbooks = Logbook::whereHas('kelompokSiswa', function($q) use ($kelompok) {
                        $q->whereIn('siswa_id', $kelompok->anggota->pluck('siswa_id'));
                    })
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        
        $laporans = Laporan::whereHas('kelompokSiswa', function($q) use ($kelompok) {
                        $q->whereIn('siswa_id', $kelompok->anggota->pluck('siswa_id'));
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('dosen.bimbingan.show', compact('kelompok', 'logbooks', 'laporans'));
    }
    
    /**
     * Display pending logbooks.
     */
    public function logbookPending()
    {
        $this->initDosen();
        
        $logbooks = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                    ->whereHas('kelompokSiswa.kelompok', function($q) {
                        $q->where('dosen_id', $this->dosen->id);
                    })
                    ->where('status', 'pending')
                    ->orderBy('tanggal', 'asc')
                    ->orderBy('created_at', 'asc')
                    ->paginate(15);
        
        return view('dosen.bimbingan.logbook-pending', compact('logbooks'));
    }
    
    /**
     * Review a logbook.
     */
    public function reviewLogbook(Logbook $logbook)
    {
        $this->initDosen();
        
        // Cek kepemilikan
        if ($logbook->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $logbook->load(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.perusahaan']);
        
        return view('dosen.bimbingan.review-logbook', compact('logbook'));
    }
    
    /**
     * Display laporan index.
     */
    /**
 * Display laporan index.
 */
public function laporanIndex(Request $request)

{
    $this->initDosen();
    
    $dosenId = $this->dosen->id;
    
    $query = Laporan::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
             ->whereHas('kelompokSiswa.kelompok', function($q) use ($dosenId) {
                 $q->where('dosen_id', $dosenId);
             });
    
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    if ($request->filled('search')) {
        $query->where('judul_laporan', 'like', '%' . $request->search . '%');
    }
    
    $laporans = $query->orderBy('created_at', 'desc')->paginate(15);
    
    return view('dosen.bimbingan.laporan-index', compact('laporans'));
}
    
    /**
     * Review a laporan.
     */
   /**
 * Review a laporan.
 */
public function reviewLaporan(Laporan $laporan)
{
    $this->initDosen();
    
    $dosenId = $this->dosen->id;
    
    // Cek kepemilikan
    if ($laporan->kelompokSiswa->kelompok->dosen_id != $dosenId) {
        abort(403, 'Anda tidak memiliki akses ke laporan ini');
    }
    
    $laporan->load(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.perusahaan']);
    
    return view('dosen.bimbingan.review-laporan', compact('laporan'));
}

/**
 * Download laporan file.
 */
public function downloadLaporan(Laporan $laporan, $type)
{
    $this->initDosen();
    
    $dosenId = $this->dosen->id;
    
    if ($laporan->kelompokSiswa->kelompok->dosen_id != $dosenId) {
        abort(403, 'Anda tidak memiliki akses ke file ini');
    }
    
    $file = $type === 'laporan' ? $laporan->file_laporan : $laporan->file_presentasi;
    
    if (!$file) {
        return back()->with('error', 'File tidak ditemukan.');
    }
    
    return Storage::disk('public')->download($file);
}
    
    public function downloadLogbook(Logbook $logbook)
    {
        $this->initDosen();
        
        if ($logbook->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        if (!$logbook->dokumentasi) {
            return back()->with('error', 'Tidak ada file dokumentasi.');
        }
        
        return Storage::disk('public')->download($logbook->dokumentasi);
    }
}