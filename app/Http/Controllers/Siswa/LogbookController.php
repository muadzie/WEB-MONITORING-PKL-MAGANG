<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Logbook;
use App\Models\KelompokSiswa;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LogbookController extends Controller
{
    /**
     * Display a listing of the logbook.
     */
    public function index(Request $request)
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return view('siswa.logbook.index', [
                'logbooks' => collect(),
                'kelompokSiswa' => null
            ]);
        }
        
        $query = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }
        
        // Search by kegiatan
        if ($request->filled('search')) {
            $query->where('kegiatan', 'like', '%' . $request->search . '%');
        }
        
        $logbooks = $query->orderBy('tanggal', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('siswa.logbook.index', compact('logbooks', 'kelompokSiswa'));
    }

        
    /**
     * Show the form for creating a new logbook.
     */
  // Di method create dan store
public function create()
{
    $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
    
    if (!$kelompokSiswa) {
        return redirect()->route('siswa.dashboard')
            ->with('error', 'Anda belum terdaftar dalam kelompok PKL.');
    }
    
    // Cek apakah hari ini sedang izin/sakit
    if (!Logbook::canCreateLogbook(Auth::id())) {
        return redirect()->route('siswa.logbook.index')
            ->with('error', 'Anda sedang dalam masa izin/sakit, tidak dapat mengisi logbook.');
    }
    
    return view('siswa.logbook.create', compact('kelompokSiswa'));
}
    /**
     * Store a newly created logbook in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'kegiatan' => 'required|string|max:255',
        'deskripsi' => 'required|string|min:10',
        'jam_mulai' => 'required',
        'jam_selesai' => 'required|after:jam_mulai',
        'dokumentasi' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // Max 5MB
    ]);
    
    $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
    
    if (!$kelompokSiswa) {
        return redirect()->route('siswa.dashboard')
            ->with('error', 'Anda belum terdaftar dalam kelompok PKL.');
    }
    
    // Upload dokumentasi
    $dokumentasiPath = null;
    if ($request->hasFile('dokumentasi')) {
        $file = $request->file('dokumentasi');
        $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
        $dokumentasiPath = $file->storeAs('logbook-dokumentasi', $filename, 'public');
        
        // Debug: cek apakah file tersimpan
        \Log::info('File uploaded to: ' . $dokumentasiPath);
    }
    
    $logbook = Logbook::create([
        'kelompok_siswa_id' => $kelompokSiswa->id,
        'tanggal' => $request->tanggal,
        'kegiatan' => $request->kegiatan,
        'deskripsi' => $request->deskripsi,
        'jam_mulai' => $request->jam_mulai,
        'jam_selesai' => $request->jam_selesai,
        'dokumentasi' => $dokumentasiPath,
        'status' => 'pending',
    ]);
    
    return redirect()->route('siswa.logbook.index')
        ->with('success', 'Logbook berhasil ditambahkan.');
}

    /**
     * Display the specified logbook.
     */
    public function show(Logbook $logbook)
    {
        // Cek kepemilikan
        if ($logbook->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke logbook ini');
        }
        
        return view('siswa.logbook.show', compact('logbook'));
    }

    /**
     * Show the form for editing the specified logbook.
     */
    public function edit(Logbook $logbook)
    {
        // Cek kepemilikan
        if ($logbook->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke logbook ini');
        }
        
        // Cek status (hanya bisa edit jika masih pending)
        if ($logbook->status != 'pending') {
            return redirect()->route('siswa.logbook.index')
                ->with('error', 'Logbook sudah diproses dan tidak dapat diedit.');
        }
        
        return view('siswa.logbook.edit', compact('logbook'));
    }

    /**
     * Update the specified logbook in storage.
     */
    public function update(Request $request, Logbook $logbook)
    {
        // Cek kepemilikan
        if ($logbook->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke logbook ini');
        }
        
        // Cek status
        if ($logbook->status != 'pending') {
            return redirect()->route('siswa.logbook.index')
                ->with('error', 'Logbook sudah diproses dan tidak dapat diedit.');
        }
        
        $request->validate([
            'tanggal' => 'required|date',
            'kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:10',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'dokumentasi' => 'nullable|image|max:2048',
        ]);
        
        $data = [
            'tanggal' => $request->tanggal,
            'kegiatan' => $request->kegiatan,
            'deskripsi' => $request->deskripsi,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ];
        
        // Upload dokumentasi baru jika ada
        if ($request->hasFile('dokumentasi')) {
            // Hapus file lama
            if ($logbook->dokumentasi) {
                Storage::disk('public')->delete($logbook->dokumentasi);
            }
            
            $data['dokumentasi'] = $request->file('dokumentasi')
                ->store('logbook-dokumentasi', 'public');
        }
        
        $logbook->update($data);
        
        return redirect()->route('siswa.logbook.index')
            ->with('success', 'Logbook berhasil diperbarui.');
    }

    /**
     * Remove the specified logbook from storage.
     */
    public function destroy(Logbook $logbook)
    {
        // Cek kepemilikan
        if ($logbook->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke logbook ini');
        }
        
        // Cek status (hanya bisa hapus jika masih pending)
        if ($logbook->status != 'pending') {
            return redirect()->route('siswa.logbook.index')
                ->with('error', 'Logbook sudah diproses dan tidak dapat dihapus.');
        }
        
        // Hapus file dokumentasi
        if ($logbook->dokumentasi) {
            Storage::disk('public')->delete($logbook->dokumentasi);
        }
        
        $logbook->delete();
        
        return redirect()->route('siswa.logbook.index')
            ->with('success', 'Logbook berhasil dihapus.');
    }

    /**
     * Dashboard for siswa (if needed separate from main dashboard).
     */
    public function dashboard()
    {
        $user = Auth::user();
        $kelompokSiswa = $user->kelompokSiswa()->first();
        
        $totalLogbook = 0;
        $logbookDisetujui = 0;
        $logbookPending = 0;
        $logbookDitolak = 0;
        
        if ($kelompokSiswa) {
            $totalLogbook = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)->count();
            $logbookDisetujui = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                                ->where('status', 'disetujui')->count();
            $logbookPending = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                              ->where('status', 'pending')->count();
            $logbookDitolak = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                              ->where('status', 'ditolak')->count();
        }
        
        return view('siswa.dashboard', compact(
            'totalLogbook', 
            'logbookDisetujui', 
            'logbookPending', 
            'logbookDitolak'
        ));
    }

    /**
     * Export logbook data (optional).
     */
    public function export(Request $request)
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return redirect()->route('siswa.logbook.index')
                ->with('error', 'Anda belum terdaftar dalam kelompok PKL.');
        }
        
        $logbooks = Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                    ->orderBy('tanggal', 'desc')
                    ->get();
        
        // Logic untuk export (CSV/PDF)
        // Bisa ditambahkan nanti
        
        return redirect()->route('siswa.logbook.index')
            ->with('info', 'Fitur export belum tersedia');
    }

    /**
     * Print logbook (optional).
     */
    public function print(Logbook $logbook)
    {
        // Cek kepemilikan
        if ($logbook->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403);
        }
        
        // Logic untuk print
        return view('siswa.logbook.print', compact('logbook'));
    }

    /**
     * Get logbook statistics (optional).
     */
    public function statistik()
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return response()->json(['error' => 'No group found'], 404);
        }
        
        $statistik = [
            'total' => Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)->count(),
            'disetujui' => Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                          ->where('status', 'disetujui')->count(),
            'pending' => Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                        ->where('status', 'pending')->count(),
            'ditolak' => Logbook::where('kelompok_siswa_id', $kelompokSiswa->id)
                        ->where('status', 'ditolak')->count(),
        ];
        
        return response()->json($statistik);
    }
}