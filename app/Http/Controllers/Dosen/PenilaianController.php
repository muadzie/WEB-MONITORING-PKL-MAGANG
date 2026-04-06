<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penilaian;
use App\Models\KelompokSiswa;
use App\Models\KelompokPkl;
use App\Models\Notifikasi;

class PenilaianController extends Controller
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

    public function create(Request $request)
    {
        $this->initDosen();
        
        $dosenId = $this->dosen->id;
        $kelompokSiswaId = $request->kelompok_siswa_id;
        
        if ($kelompokSiswaId) {
            $kelompokSiswa = KelompokSiswa::with(['siswa', 'kelompok'])->findOrFail($kelompokSiswaId);
            
            if ($kelompokSiswa->kelompok->dosen_id != $dosenId) {
                abort(403);
            }
            
            $existing = Penilaian::where('kelompok_siswa_id', $kelompokSiswaId)
                        ->where('penilai', 'dosen')
                        ->first();
            
            if ($existing) {
                return redirect()->route('dosen.penilaian.edit', $existing->id)
                    ->with('info', 'Siswa ini sudah dinilai.');
            }
            
            return view('dosen.penilaian.create', compact('kelompokSiswa'));
        }
        
        $kelompoks = KelompokPkl::with(['anggota.siswa'])
                     ->where('dosen_id', $dosenId)
                     ->where('status', 'selesai')
                     ->get();
        
        return view('dosen.penilaian.pilih-siswa', compact('kelompoks'));
    }

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
        
        if ($kelompokSiswa->kelompok->dosen_id != $dosenId) {
            abort(403);
        }
        
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

    public function show(Penilaian $penilaian)
    {
        $this->initDosen();
        
        if ($penilaian->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        return view('dosen.penilaian.show', compact('penilaian'));
    }

    public function edit(Penilaian $penilaian)
    {
        $this->initDosen();
        
        if ($penilaian->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        return view('dosen.penilaian.edit', compact('penilaian'));
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        $this->initDosen();
        
        if ($penilaian->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $request->validate([
            'nilai_laporan' => 'required|numeric|min:0|max:100',
            'nilai_presentasi' => 'required|numeric|min:0|max:100',
            'nilai_sikap' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable|string',
        ]);
        
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

    public function destroy(Penilaian $penilaian)
    {
        $this->initDosen();
        
        if ($penilaian->kelompokSiswa->kelompok->dosen_id != $this->dosen->id) {
            abort(403);
        }
        
        $penilaian->delete();
        
        return redirect()->route('dosen.penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}