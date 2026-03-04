<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\KelompokPkl;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LogbookController extends Controller
{
    public function index(Request $request)
    {
        $query = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok.dosen', 'kelompokSiswa.kelompok.perusahaan']);
        
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
        
        if ($request->filled('siswa_id')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('siswa_id', $request->siswa_id);
            });
        }
        
        $logbooks = $query->orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
        
        $kelompoks = KelompokPkl::orderBy('nama_kelompok')->get();
        $siswas = User::where('role', 'siswa')->orderBy('name')->get();
        
        $statistik = [
            'total' => Logbook::count(),
            'pending' => Logbook::where('status', 'pending')->count(),
            'disetujui' => Logbook::where('status', 'disetujui')->count(),
            'ditolak' => Logbook::where('status', 'ditolak')->count(),
        ];
        
        return view('admin.logbook.index', compact('logbooks', 'kelompoks', 'siswas', 'statistik'));
    }
}