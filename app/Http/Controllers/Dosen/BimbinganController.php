<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KelompokPkl;
use App\Models\Logbook;
use App\Models\Laporan;
use App\Models\KelompokSiswa;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BimbinganController extends Controller
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
        } else {
            abort(401, 'Silakan login terlebih dahulu');
        }
    }

  public function dashboard()
{
    $this->initDosen();
    
    $dosenId = $this->dosen->id;
    
    // Statistik
    $totalKelompok = KelompokPkl::where('dosen_id', $dosenId)->count();
    $kelompokAktif = KelompokPkl::where('dosen_id', $dosenId)
                      ->where('status', 'aktif')->count();
    $kelompokSelesai = KelompokPkl::where('dosen_id', $dosenId)
                       ->where('status', 'selesai')->count();
    
    $logbookPending = Logbook::whereHas('kelompokSiswa.kelompok', function($q) use ($dosenId) {
                            $q->where('dosen_id', $dosenId);
                        })->where('status', 'pending')->count();
    
    $logbookDisetujui = Logbook::whereHas('kelompokSiswa.kelompok', function($q) use ($dosenId) {
                            $q->where('dosen_id', $dosenId);
                        })->where('status', 'disetujui')->count();
    
    $laporanPending = Laporan::whereHas('kelompokSiswa.kelompok', function($q) use ($dosenId) {
                            $q->where('dosen_id', $dosenId);
                        })->whereIn('status', ['diajukan', 'direvisi'])->count();
    
    // Data untuk chart
    $chartData = [
        'kelompok' => [$kelompokAktif, $kelompokSelesai],
        'logbook' => [$logbookPending, $logbookDisetujui],
    ];
    
    // Data terbaru
    $kelompokTerbaru = KelompokPkl::with(['perusahaan', 'anggota'])
                        ->where('dosen_id', $dosenId)
                        ->latest()
                        ->limit(5)
                        ->get();
    
    $logbookTerbaru = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                        ->whereHas('kelompokSiswa.kelompok', function($q) use ($dosenId) {
                            $q->where('dosen_id', $dosenId);
                        })
                        ->latest()
                        ->limit(10)
                        ->get();
    
    return view('dosen.dashboard', compact(
        'totalKelompok', 'kelompokAktif', 'kelompokSelesai',
        'logbookPending', 'logbookDisetujui', 'laporanPending',
        'chartData', 'kelompokTerbaru', 'logbookTerbaru'
    ));
}

    public function index()
    {
        $this->initDosen();
        
        $kelompoks = KelompokPkl::with(['perusahaan', 'anggota.siswa'])
                     ->where('dosen_id', $this->dosen->id)
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
        
        return view('dosen.bimbingan.index', compact('kelompoks'));
    }

    public function show(KelompokPkl $kelompok)
    {
        $this->initDosen();
        
        if ($kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $kelompok->load(['perusahaan', 'anggota.siswa']);
        
        $logbooks = Logbook::whereHas('kelompokSiswa', function($q) use ($kelompok) {
                        $q->whereIn('siswa_id', $kelompok->anggota->pluck('siswa_id'));
                    })
                    ->orderBy('tanggal', 'desc')
                    ->paginate(15);
        
        $laporans = Laporan::whereHas('kelompokSiswa', function($q) use ($kelompok) {
                        $q->whereIn('siswa_id', $kelompok->anggota->pluck('siswa_id'));
                    })
                    ->get();
        
        return view('dosen.bimbingan.show', compact('kelompok', 'logbooks', 'laporans'));
    }

    public function logbookPending()
    {
        $this->initDosen();
        
        $logbooks = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                    ->whereHas('kelompokSiswa.kelompok', function($q) {
                        $q->where('dosen_id', $this->dosen->id);
                    })
                    ->where('status', 'pending')
                    ->orderBy('tanggal', 'asc')
                    ->paginate(15);
        
        return view('dosen.bimbingan.logbook-pending', compact('logbooks'));
    }

    public function reviewLogbook(Logbook $logbook)
    {
        $this->initDosen();
        
        if ($logbook->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $logbook->load(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.perusahaan']);
        
        return view('dosen.bimbingan.review-logbook', compact('logbook'));
    }

    public function approveLogbook(Request $request, Logbook $logbook)
    {
        $this->initDosen();
        
        if ($logbook->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $request->validate([
            'catatan' => 'nullable|string',
        ]);
        
        $logbook->update([
            'status' => $request->action === 'approve' ? 'disetujui' : 'ditolak',
            'catatan_dosen' => $request->catatan,
            'approved_by_dosen' => Auth::id(),
            'approved_at_dosen' => now(),
        ]);
        
        return redirect()->route('dosen.logbook.pending')
            ->with('success', 'Logbook berhasil direview.');
    }

    public function laporanIndex(Request $request)
{
    $this->initDosen();
    
    $dosenId = $this->dosen->id;
    
    // Ambil semua kelompok dosen
    $kelompokIds = KelompokPkl::where('dosen_id', $dosenId)->pluck('id');
    
    // Ambil semua siswa dari kelompok tersebut
    $siswaIds = KelompokSiswa::whereIn('kelompok_pkl_id', $kelompokIds)->pluck('id');
    
    // Ambil laporan berdasarkan siswa
    $query = Laporan::whereIn('kelompok_siswa_id', $siswaIds)
                ->with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok']);
    
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    if ($request->filled('search')) {
        $query->where('judul_laporan', 'like', '%' . $request->search . '%');
    }
    
    $laporans = $query->orderBy('created_at', 'desc')->paginate(15);
    
    return view('dosen.bimbingan.laporan-index', compact('laporans'));
}

    public function reviewLaporan(Laporan $laporan)
    {
        $this->initDosen();
        
        if ($laporan->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $laporan->load(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.perusahaan']);
        
        return view('dosen.bimbingan.review-laporan', compact('laporan'));
    }

    public function submitReviewLaporan(Request $request, Laporan $laporan)
    {
        $this->initDosen();
        
        if ($laporan->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $request->validate([
            'status' => 'required|in:setujui,revisi,tolak',
            'catatan_revisi' => 'required_if:status,revisi|nullable|string',
        ]);
        
        $statusMap = [
            'setujui' => 'disetujui',
            'revisi' => 'direvisi',
            'tolak' => 'ditolak',
        ];
        
        $laporan->update([
            'status' => $statusMap[$request->status],
            'catatan_revisi' => $request->catatan_revisi,
            'reviewer_dosen_id' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        
        return redirect()->route('dosen.laporan.index')
            ->with('success', 'Review laporan berhasil disimpan.');
    }

    public function downloadLaporan(Laporan $laporan, $type)
    {
        $this->initDosen();
        
        if ($laporan->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $file = $type === 'laporan' ? $laporan->file_laporan : $laporan->file_presentasi;
        
        if (!$file || !Storage::disk('public')->exists($file)) {
            return back()->with('error', 'File tidak ditemukan.');
        }
        
        return Storage::disk('public')->download($file);
    }
}