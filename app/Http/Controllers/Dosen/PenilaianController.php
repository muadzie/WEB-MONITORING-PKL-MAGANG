<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penilaian;
use App\Models\KelompokSiswa;
use App\Models\KelompokPkl;
use App\Models\Notifikasi;
use App\Models\Dosen;

class PenilaianController extends Controller
{
    protected $dosen;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // Tidak perlu middleware di sini untuk Laravel 11
    }
    
    /**
     * Initialize dosen data
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
     * Display a listing of penilaian.
     */
    public function index(Request $request)
    {
        $this->initDosen();
        
        $dosenId = $this->dosen->id;
        
        $query = Penilaian::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                 ->where('penilai', 'dosen')
                 ->whereHas('kelompokSiswa.kelompok', function($q) use ($dosenId) {
                     $q->where('dosen_id', $dosenId);
                 });
        
        if ($request->filled('kelompok_id')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('kelompok_pkl_id', $request->kelompok_id);
            });
        }
        
        $penilaians = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $kelompoks = KelompokPkl::where('dosen_id', $dosenId)
                     ->where('status', 'selesai')
                     ->orderBy('nama_kelompok')
                     ->get();
        
        return view('dosen.penilaian.index', compact('penilaians', 'kelompoks'));
    }
    
    /**
     * Show the form for creating a new penilaian.
     */
    public function create(Request $request)
    {
        $this->initDosen();
        
        $dosenId = $this->dosen->id;
        $kelompokSiswaId = $request->kelompok_siswa_id;
        
        if ($kelompokSiswaId) {
            $kelompokSiswa = KelompokSiswa::with(['siswa', 'kelompok'])
                              ->findOrFail($kelompokSiswaId);
            
            // Cek kepemilikan
            if ($kelompokSiswa->kelompok->dosen_id != $dosenId) {
                abort(403);
            }
            
            // Cek apakah sudah dinilai
            $existing = Penilaian::where('kelompok_siswa_id', $kelompokSiswaId)
                        ->where('penilai', 'dosen')
                        ->first();
            
            if ($existing) {
                return redirect()->route('dosen.penilaian.edit', $existing->id)
                    ->with('info', 'Siswa ini sudah dinilai. Silakan edit nilai yang ada.');
            }
            
            return view('dosen.penilaian.create', compact('kelompokSiswa'));
        }
        
        // Tampilkan pilihan siswa
        $kelompoks = KelompokPkl::with(['anggota.siswa'])
                     ->where('dosen_id', $dosenId)
                     ->where('status', 'selesai')
                     ->get();
        
        return view('dosen.penilaian.pilih-siswa', compact('kelompoks'));
    }
    
    /**
     * Store a newly created penilaian in storage.
     */
    public function store(Request $request)
    {
        $this->initDosen();
        
        $request->validate([
            'kelompok_siswa_id' => 'required|exists:kelompok_siswas,id',
            'nilai_laporan' => 'required|numeric|min:0|max:100',
            'nilai_presentasi' => 'required|numeric|min:0|max:100',
            'nilai_sikap' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        
        $kelompokSiswa = KelompokSiswa::findOrFail($request->kelompok_siswa_id);
        $dosenId = $this->dosen->id;
        
        // Cek kepemilikan
        if ($kelompokSiswa->kelompok->dosen_id != $dosenId) {
            abort(403);
        }
        
        // Hitung nilai akhir
        $nilaiAkhir = ($request->nilai_laporan + $request->nilai_presentasi + $request->nilai_sikap) / 3;
        
        $penilaian = Penilaian::create([
            'kelompok_siswa_id' => $request->kelompok_siswa_id,
            'penilai' => 'dosen',
            'nilai_laporan' => $request->nilai_laporan,
            'nilai_presentasi' => $request->nilai_presentasi,
            'nilai_sikap' => $request->nilai_sikap,
            'nilai_akhir' => round($nilaiAkhir, 2),
            'catatan' => $request->catatan,
            'penilai_id' => Auth::id(),
        ]);
        
        // Notifikasi ke siswa
        Notifikasi::create([
            'user_id' => $kelompokSiswa->siswa_id,
            'judul' => 'Penilaian Dosen',
            'pesan' => 'Nilai PKL dari dosen pembimbing telah diinput.',
            'tipe' => 'success',
            'url' => route('siswa.penilaian.index'),
        ]);
        
        return redirect()->route('dosen.penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan.');
    }
    
    /**
     * Display the specified penilaian.
     */
    public function show(Penilaian $penilaian)
    {
        $this->initDosen();
        
        $dosenId = $this->dosen->id;
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->kelompok->dosen_id != $dosenId) {
            abort(403);
        }
        
        return view('dosen.penilaian.show', compact('penilaian'));
    }
    
    /**
     * Show the form for editing the specified penilaian.
     */
    public function edit(Penilaian $penilaian)
    {
        $this->initDosen();
        
        $dosenId = $this->dosen->id;
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->kelompok->dosen_id != $dosenId) {
            abort(403);
        }
        
        if ($penilaian->penilai != 'dosen') {
            abort(403);
        }
        
        return view('dosen.penilaian.edit', compact('penilaian'));
    }
    
    /**
     * Update the specified penilaian in storage.
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        $this->initDosen();
        
        $dosenId = $this->dosen->id;
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->kelompok->dosen_id != $dosenId) {
            abort(403);
        }
        
        $request->validate([
            'nilai_laporan' => 'required|numeric|min:0|max:100',
            'nilai_presentasi' => 'required|numeric|min:0|max:100',
            'nilai_sikap' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        
        // Hitung nilai akhir
        $nilaiAkhir = ($request->nilai_laporan + $request->nilai_presentasi + $request->nilai_sikap) / 3;
        
        $penilaian->update([
            'nilai_laporan' => $request->nilai_laporan,
            'nilai_presentasi' => $request->nilai_presentasi,
            'nilai_sikap' => $request->nilai_sikap,
            'nilai_akhir' => round($nilaiAkhir, 2),
            'catatan' => $request->catatan,
        ]);
        
        return redirect()->route('dosen.penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }
    
    /**
     * Remove the specified penilaian from storage.
     */
    public function destroy(Penilaian $penilaian)
    {
        $this->initDosen();
        
        $dosenId = $this->dosen->id;
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->kelompok->dosen_id != $dosenId) {
            abort(403);
        }
        
        $penilaian->delete();
        
        return redirect()->route('dosen.penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}