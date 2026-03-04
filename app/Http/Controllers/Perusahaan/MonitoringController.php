<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KelompokPkl;
use App\Models\Logbook;
use App\Models\Laporan;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    protected $perusahaan;
    
    /**
     * Constructor - tidak perlu middleware di sini untuk Laravel 11
     */
    public function __construct()
    {
        // Middleware didefinisikan di routes, tidak perlu di sini
    }
    
    /**
     * Initialize perusahaan data
     */
    protected function initPerusahaan()
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Cek apakah user adalah PT
            if ($user->role !== 'pt') {
                abort(403, 'Anda bukan PT');
            }
            
            // Ambil data perusahaan dari relasi
            $this->perusahaan = $user->perusahaan;
            
            // Jika tidak ada data perusahaan, tampilkan error
            if (!$this->perusahaan) {
                abort(404, 'Data perusahaan tidak ditemukan. Silakan hubungi admin.');
            }
        } else {
            abort(401, 'Silakan login terlebih dahulu');
        }
    }
    
    /**
     * Dashboard untuk PT.
     */
    public function dashboard()
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        $totalKelompok = KelompokPkl::where('perusahaan_id', $perusahaanId)->count();
        $kelompokAktif = KelompokPkl::where('perusahaan_id', $perusahaanId)
                          ->where('status', 'aktif')->count();
        $kelompokSelesai = KelompokPkl::where('perusahaan_id', $perusahaanId)
                            ->where('status', 'selesai')->count();
        
        $logbookPending = Logbook::whereHas('kelompokSiswa.kelompok', function($q) use ($perusahaanId) {
                                $q->where('perusahaan_id', $perusahaanId);
                            })->where('status', 'pending')->count();
        
        $logbookDisetujui = Logbook::whereHas('kelompokSiswa.kelompok', function($q) use ($perusahaanId) {
                                $q->where('perusahaan_id', $perusahaanId);
                            })->where('status', 'disetujui')->count();
        
        $kelompokTerbaru = KelompokPkl::with(['dosen', 'anggota.siswa'])
                            ->where('perusahaan_id', $perusahaanId)
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
        
        $logbookTerbaru = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                            ->whereHas('kelompokSiswa.kelompok', function($q) use ($perusahaanId) {
                                $q->where('perusahaan_id', $perusahaanId);
                            })
                            ->orderBy('created_at', 'desc')
                            ->limit(10)
                            ->get();
        
        return view('pt.dashboard', compact(
            'totalKelompok', 'kelompokAktif', 'kelompokSelesai',
            'logbookPending', 'logbookDisetujui',
            'kelompokTerbaru', 'logbookTerbaru'
        ));
    }
    
    /**
     * Display a listing of monitoring.
     */
    public function index(Request $request)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        $query = KelompokPkl::with(['dosen', 'anggota.siswa'])
                 ->where('perusahaan_id', $perusahaanId);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->where('nama_kelompok', 'like', '%' . $request->search . '%');
        }
        
        $kelompoks = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('pt.monitoring.index', compact('kelompoks'));
    }
    
    /**
     * Display the specified monitoring.
     */
    public function show(KelompokPkl $kelompok)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        // Cek kepemilikan
        if ($kelompok->perusahaan_id != $perusahaanId) {
            abort(403, 'Anda tidak memiliki akses ke kelompok ini');
        }
        
        $kelompok->load(['dosen', 'anggota.siswa']);
        
        $logbooks = Logbook::whereHas('kelompokSiswa', function($q) use ($kelompok) {
                        $q->whereIn('siswa_id', $kelompok->anggota->pluck('siswa_id'));
                    })
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        
        return view('pt.monitoring.show', compact('kelompok', 'logbooks'));
    }
    
    /**
     * Display logbook index.
     */
    public function logbookIndex(Request $request)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        $query = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                 ->whereHas('kelompokSiswa.kelompok', function($q) use ($perusahaanId) {
                     $q->where('perusahaan_id', $perusahaanId);
                 });
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('kelompok_id')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('kelompok_pkl_id', $request->kelompok_id);
            });
        }
        
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        
        $logbooks = $query->orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        
        $kelompoks = KelompokPkl::where('perusahaan_id', $perusahaanId)
                     ->orderBy('nama_kelompok')
                     ->get();
        
        return view('pt.logbook.index', compact('logbooks', 'kelompoks'));
    }
    
    /**
     * Display pending logbooks.
     */
    public function logbookPending()
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        $logbooks = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                    ->whereHas('kelompokSiswa.kelompok', function($q) use ($perusahaanId) {
                        $q->where('perusahaan_id', $perusahaanId);
                    })
                    ->where('status', 'pending')
                    ->orderBy('tanggal', 'asc')
                    ->paginate(15);
        
        return view('pt.logbook.pending', compact('logbooks'));
    }
    
    /**
     * Review a logbook.
     */
    public function reviewLogbook(Logbook $logbook)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        // Cek kepemilikan
        if ($logbook->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403, 'Anda tidak memiliki akses ke logbook ini');
        }
        
        $logbook->load(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.dosen']);
        
        return view('pt.logbook.review', compact('logbook'));
    }
    
    /**
     * Download logbook attachment.
     */
    public function downloadLogbook(Logbook $logbook)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        if ($logbook->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403, 'Anda tidak memiliki akses ke file ini');
        }
        
        if (!$logbook->dokumentasi) {
            return back()->with('error', 'Tidak ada file dokumentasi.');
        }
        
        return Storage::disk('public')->download($logbook->dokumentasi);
    }
    
    /**
     * Approve a logbook.
     */
    public function approveLogbook(Request $request, Logbook $logbook)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        if ($logbook->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403);
        }
        
        $request->validate([
            'catatan' => 'nullable|string',
        ]);
        
        $logbook->update([
            'status' => 'disetujui',
            'catatan_pt' => $request->catatan,
            'approved_by_pt' => Auth::id(),
            'approved_at_pt' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Logbook berhasil disetujui.');
    }
    
    /**
     * Reject a logbook.
     */
    public function rejectLogbook(Request $request, Logbook $logbook)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        if ($logbook->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403);
        }
        
        $request->validate([
            'catatan' => 'required|string',
        ]);
        
        $logbook->update([
            'status' => 'ditolak',
            'catatan_pt' => $request->catatan,
            'approved_by_pt' => Auth::id(),
            'approved_at_pt' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Logbook ditolak.');
    }
    
    /**
     * Display laporan index.
     */
    public function laporanIndex(Request $request)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        $laporans = Laporan::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                    ->whereHas('kelompokSiswa.kelompok', function($q) use ($perusahaanId) {
                        $q->where('perusahaan_id', $perusahaanId);
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        
        return view('pt.laporan.index', compact('laporans'));
    }
    
    /**
     * View a laporan.
     */
    public function viewLaporan(Laporan $laporan)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        if ($laporan->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403);
        }
        
        return view('pt.laporan.show', compact('laporan'));
    }
    
    /**
     * Download laporan file.
     */
    public function downloadLaporan(Laporan $laporan)
    {
        $this->initPerusahaan();
        
        $perusahaanId = $this->perusahaan->id;
        
        if ($laporan->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403);
        }
        
        if (!$laporan->file_laporan) {
            return back()->with('error', 'File tidak ditemukan.');
        }
        
        return Storage::disk('public')->download($laporan->file_laporan);
    }
}