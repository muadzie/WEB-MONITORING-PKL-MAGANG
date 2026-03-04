<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Penilaian;
use App\Models\KelompokSiswa;

class PenilaianController extends Controller
{
    /**
     * Display a listing of penilaian for the student.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil data kelompok siswa
        $kelompokSiswa = KelompokSiswa::where('siswa_id', $user->id)->first();
        
        if (!$kelompokSiswa) {
            return view('siswa.penilaian.index', [
                'penilaians' => collect(),
                'nilaiDosen' => null,
                'nilaiPt' => null,
                'nilaiAkhir' => null,
                'message' => 'Anda belum terdaftar dalam kelompok PKL.'
            ]);
        }
        
        // Ambil penilaian dari dosen dan PT
        $penilaians = Penilaian::where('kelompok_siswa_id', $kelompokSiswa->id)
                      ->with('penilaiUser')
                      ->get();
        
        $nilaiDosen = $penilaians->where('penilai', 'dosen')->first();
        $nilaiPt = $penilaians->where('penilai', 'pt')->first();
        
        // Hitung nilai akhir gabungan
        $nilaiAkhir = null;
        if ($nilaiDosen && $nilaiPt) {
            $nilaiAkhir = ($nilaiDosen->nilai_akhir + $nilaiPt->nilai_akhir) / 2;
        } elseif ($nilaiDosen) {
            $nilaiAkhir = $nilaiDosen->nilai_akhir;
        } elseif ($nilaiPt) {
            $nilaiAkhir = $nilaiPt->nilai_akhir;
        }
        
        return view('siswa.penilaian.index', compact(
            'penilaians', 
            'nilaiDosen', 
            'nilaiPt', 
            'nilaiAkhir'
        ));
    }

    /**
     * Display the specified penilaian.
     */
    public function show(Penilaian $penilaian)
    {
        $user = Auth::user();
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->siswa_id != $user->id) {
            abort(403, 'Anda tidak memiliki akses ke penilaian ini');
        }
        
        $penilaian->load(['kelompokSiswa.siswa', 'penilaiUser']);
        
        return view('siswa.penilaian.show', compact('penilaian'));
    }

    /**
     * Download certificate or report (optional).
     */
    public function download(Penilaian $penilaian)
    {
        $user = Auth::user();
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->siswa_id != $user->id) {
            abort(403, 'Anda tidak memiliki akses ke penilaian ini');
        }
        
        // Logika untuk download sertifikat atau laporan nilai
        // Bisa generate PDF atau file lainnya
        
        return back()->with('info', 'Fitur download belum tersedia');
    }

    /**
     * Print the assessment (optional).
     */
    public function print(Penilaian $penilaian)
    {
        $user = Auth::user();
        
        // Cek kepemilikan
        if ($penilaian->kelompokSiswa->siswa_id != $user->id) {
            abort(403, 'Anda tidak memiliki akses ke penilaian ini');
        }
        
        // Logika untuk print
        return view('siswa.penilaian.print', compact('penilaian'));
    }
}