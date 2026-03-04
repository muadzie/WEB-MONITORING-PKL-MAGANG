<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penilaian;
use App\Models\KelompokSiswa;
use App\Models\KelompokPkl;
use App\Models\Notifikasi;

class PenilaianPtController extends Controller
{
    protected $perusahaan;
    
    public function __construct()
    {
        // Tidak perlu middleware di sini untuk Laravel 11
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
     * Display a listing of penilaian.
     */
    public function index(Request $request)
    {
        $this->initPerusahaan(); // PASTIKAN DIPANGGIL
        
        $perusahaanId = $this->perusahaan->id;
        
        $query = Penilaian::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok'])
                 ->where('penilai', 'pt')
                 ->whereHas('kelompokSiswa.kelompok', function($q) use ($perusahaanId) {
                     $q->where('perusahaan_id', $perusahaanId);
                 });
        
        if ($request->filled('kelompok_id')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('kelompok_pkl_id', $request->kelompok_id);
            });
        }
        
        $penilaians = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $kelompoks = KelompokPkl::where('perusahaan_id', $perusahaanId)
                     ->where('status', 'selesai')
                     ->orderBy('nama_kelompok')
                     ->get();
        
        return view('pt.penilaian.index', compact('penilaians', 'kelompoks'));
    }
    
    /**
     * Show the form for creating a new penilaian.
     */
    public function create(Request $request)
    {
        $this->initPerusahaan(); // PASTIKAN DIPANGGIL
        
        $perusahaanId = $this->perusahaan->id;
        $kelompokSiswaId = $request->kelompok_siswa_id;
        
        if ($kelompokSiswaId) {
            $kelompokSiswa = KelompokSiswa::with(['siswa', 'kelompok'])
                              ->findOrFail($kelompokSiswaId);
            
            // Cek kepemilikan
            if ($kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
                abort(403);
            }
            
            // Cek apakah sudah dinilai
            $existing = Penilaian::where('kelompok_siswa_id', $kelompokSiswaId)
                        ->where('penilai', 'pt')
                        ->first();
            
            if ($existing) {
                return redirect()->route('pt.penilaian.edit', $existing->id)
                    ->with('info', 'Siswa ini sudah dinilai. Silakan edit nilai yang ada.');
            }
            
            return view('pt.penilaian.create', compact('kelompokSiswa'));
        }
        
        // Tampilkan pilihan siswa
        $kelompoks = KelompokPkl::with(['anggota.siswa'])
                     ->where('perusahaan_id', $perusahaanId)
                     ->where('status', 'selesai')
                     ->get();
        
        return view('pt.penilaian.pilih-siswa', compact('kelompoks'));
    }
    
    /**
     * Store a newly created penilaian in storage.
     */
    public function store(Request $request)
    {
        $this->initPerusahaan(); // PASTIKAN DIPANGGIL
        
        $request->validate([
            'kelompok_siswa_id' => 'required|exists:kelompok_siswas,id',
            'nilai_kinerja' => 'required|numeric|min:0|max:100',
            'nilai_kedisiplinan' => 'required|numeric|min:0|max:100',
            'nilai_kerjasama' => 'required|numeric|min:0|max:100',
            'nilai_inisiatif' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        
        $kelompokSiswa = KelompokSiswa::findOrFail($request->kelompok_siswa_id);
        $perusahaanId = $this->perusahaan->id;
        
        // Cek kepemilikan
        if ($kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403);
        }
        
        // Hitung nilai akhir
        $nilaiAkhir = ($request->nilai_kinerja + $request->nilai_kedisiplinan + 
                      $request->nilai_kerjasama + $request->nilai_inisiatif) / 4;
        
        $penilaian = Penilaian::create([
            'kelompok_siswa_id' => $request->kelompok_siswa_id,
            'penilai' => 'pt',
            'nilai_kinerja' => $request->nilai_kinerja,
            'nilai_kedisiplinan' => $request->nilai_kedisiplinan,
            'nilai_kerjasama' => $request->nilai_kerjasama,
            'nilai_inisiatif' => $request->nilai_inisiatif,
            'nilai_akhir' => round($nilaiAkhir, 2),
            'catatan' => $request->catatan,
            'penilai_id' => Auth::id(),
        ]);
        
        // Notifikasi ke siswa
        Notifikasi::create([
            'user_id' => $kelompokSiswa->siswa_id,
            'judul' => 'Penilaian dari PT',
            'pesan' => 'Nilai PKL dari pembimbing PT telah diinput.',
            'tipe' => 'success',
            'url' => route('siswa.penilaian.index'),
        ]);
        
        return redirect()->route('pt.penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan.');
    }
    
    /**
     * Display the specified penilaian.
     */
    public function show(Penilaian $penilaian)
    {
        $this->initPerusahaan(); // PASTIKAN DIPANGGIL
        
        $perusahaanId = $this->perusahaan->id;
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403);
        }
        
        return view('pt.penilaian.show', compact('penilaian'));
    }
    
    /**
     * Show the form for editing the specified penilaian.
     */
    public function edit(Penilaian $penilaian)
    {
        $this->initPerusahaan(); // PASTIKAN DIPANGGIL
        
        $perusahaanId = $this->perusahaan->id;
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403);
        }
        
        if ($penilaian->penilai != 'pt') {
            abort(403);
        }
        
        return view('pt.penilaian.edit', compact('penilaian'));
    }
    
    /**
     * Update the specified penilaian in storage.
     */
    public function update(Request $request, Penilaian $penilaian)
    {
        $this->initPerusahaan(); // PASTIKAN DIPANGGIL
        
        $perusahaanId = $this->perusahaan->id;
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403);
        }
        
        $request->validate([
            'nilai_kinerja' => 'required|numeric|min:0|max:100',
            'nilai_kedisiplinan' => 'required|numeric|min:0|max:100',
            'nilai_kerjasama' => 'required|numeric|min:0|max:100',
            'nilai_inisiatif' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        
        // Hitung nilai akhir
        $nilaiAkhir = ($request->nilai_kinerja + $request->nilai_kedisiplinan + 
                      $request->nilai_kerjasama + $request->nilai_inisiatif) / 4;
        
        $penilaian->update([
            'nilai_kinerja' => $request->nilai_kinerja,
            'nilai_kedisiplinan' => $request->nilai_kedisiplinan,
            'nilai_kerjasama' => $request->nilai_kerjasama,
            'nilai_inisiatif' => $request->nilai_inisiatif,
            'nilai_akhir' => round($nilaiAkhir, 2),
            'catatan' => $request->catatan,
        ]);
        
        return redirect()->route('pt.penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }
    
    /**
     * Remove the specified penilaian from storage.
     */
    public function destroy(Penilaian $penilaian)
    {
        $this->initPerusahaan(); // PASTIKAN DIPANGGIL
        
        $perusahaanId = $this->perusahaan->id;
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->kelompok->perusahaan_id != $perusahaanId) {
            abort(403);
        }
        
        $penilaian->delete();
        
        return redirect()->route('pt.penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}