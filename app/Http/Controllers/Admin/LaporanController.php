<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\KelompokPkl;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Display a listing of all reports.
     */
    public function index(Request $request)
    {
        $query = Laporan::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.dosen', 'reviewer']);
        
        if ($request->filled('search')) {
            $query->where('judul_laporan', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('kelompok_id')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('kelompok_pkl_id', $request->kelompok_id);
            });
        }
        
        $laporans = $query->orderBy('created_at', 'desc')->paginate(15);
        $kelompoks = KelompokPkl::orderBy('nama_kelompok')->get();
        
        return view('admin.laporan.index', compact('laporans', 'kelompoks'));
    }

    /**
     * Display pending reports.
     */
    public function pending()
    {
        $laporans = Laporan::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.dosen'])
                    ->where('status', 'diajukan')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        
        return view('admin.laporan.pending', compact('laporans'));
    }

    /**
     * Display approved reports.
     */
    public function approved()
    {
        $laporans = Laporan::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.dosen'])
                    ->where('status', 'disetujui')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        
        return view('admin.laporan.approved', compact('laporans'));
    }

    /**
     * Display rejected reports.
     */
    public function rejected()
    {
        $laporans = Laporan::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.dosen'])
                    ->where('status', 'ditolak')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);
        
        return view('admin.laporan.rejected', compact('laporans'));
    }

    /**
     * Display the specified report.
     */
    public function show(Laporan $laporan)
    {
        $laporan->load(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.dosen', 'kelompokSiswa.kelompok.perusahaan', 'reviewer']);
        
        return view('admin.laporan.show', compact('laporan'));
    }

    /**
     * Download report file.
     */
    public function download(Laporan $laporan, $type)
    {
        $file = $type === 'laporan' ? $laporan->file_laporan : $laporan->file_presentasi;
        
        if (!$file || !Storage::disk('public')->exists($file)) {
            return back()->with('error', 'File tidak ditemukan.');
        }
        
        return Storage::disk('public')->download($file);
    }
}