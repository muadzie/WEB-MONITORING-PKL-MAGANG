<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelompokPkl;
use App\Models\Penilaian;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    /**
     * Display the export page.
     */
    public function index()
    {
        $kelompoks = KelompokPkl::orderBy('nama_kelompok')->get();
        return view('admin.export.index', compact('kelompoks'));
    }

    /**
     * Export kelompok data to CSV.
     */
    public function exportKelompok(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer',
            'status' => 'nullable|in:pending,aktif,selesai,dibatalkan',
        ]);

        $query = KelompokPkl::with(['dosen', 'perusahaan', 'anggota.siswa'])
                 ->whereYear('created_at', $request->tahun);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kelompoks = $query->get();

        $filename = 'kelompok-pkl-' . $request->tahun . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['No', 'Nama Kelompok', 'Dosen Pembimbing', 'Perusahaan', 'Jumlah Anggota', 'Tanggal Mulai', 'Tanggal Selesai', 'Status']);

        foreach ($kelompoks as $index => $kelompok) {
            fputcsv($handle, [
                $index + 1,
                $kelompok->nama_kelompok,
                $kelompok->dosen->nama_dosen ?? '-',
                $kelompok->perusahaan->nama_perusahaan ?? '-',
                $kelompok->anggota->count(),
                $kelompok->tanggal_mulai->format('d/m/Y'),
                $kelompok->tanggal_selesai->format('d/m/Y'),
                $kelompok->status,
            ]);
        }

        fclose($handle);
        return Response::make('', 200, $headers);
    }

    /**
     * Export nilai data to CSV.
     */
    public function exportNilai(Request $request)
    {
        $request->validate([
            'kelompok_id' => 'required|exists:kelompok_pkls,id',
        ]);

        $kelompok = KelompokPkl::with(['anggota.siswa', 'dosen', 'perusahaan'])->find($request->kelompok_id);

        $filename = 'nilai-' . $kelompok->nama_kelompok . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['No', 'NIM', 'Nama Siswa', 'Nilai Dosen', 'Nilai PT', 'Nilai Akhir', 'Grade']);

        foreach ($kelompok->anggota as $index => $anggota) {
            $nilaiDosen = Penilaian::where('kelompok_siswa_id', $anggota->id)
                          ->where('penilai', 'dosen')
                          ->first();
            
            $nilaiPt = Penilaian::where('kelompok_siswa_id', $anggota->id)
                       ->where('penilai', 'pt')
                       ->first();

            $nilaiAkhir = null;
            $grade = '-';

            if ($nilaiDosen && $nilaiPt) {
                $nilaiAkhir = ($nilaiDosen->nilai_akhir + $nilaiPt->nilai_akhir) / 2;
                
                if ($nilaiAkhir >= 85) $grade = 'A';
                elseif ($nilaiAkhir >= 70) $grade = 'B';
                elseif ($nilaiAkhir >= 60) $grade = 'C';
                elseif ($nilaiAkhir >= 50) $grade = 'D';
                else $grade = 'E';
            }

            fputcsv($handle, [
                $index + 1,
                $anggota->nim,
                $anggota->siswa->name,
                $nilaiDosen->nilai_akhir ?? '-',
                $nilaiPt->nilai_akhir ?? '-',
                $nilaiAkhir ? number_format($nilaiAkhir, 2) : '-',
                $grade,
            ]);
        }

        fclose($handle);
        return Response::make('', 200, $headers);
    }

    /**
     * Export siswa data to CSV.
     */
    public function exportSiswa(Request $request)
    {
        $query = User::where('role', 'siswa')
            ->with('kelompokSiswa.kelompok');
        
        if ($request->filled('angkatan')) {
            $query->whereYear('created_at', $request->angkatan);
        }
        
        if ($request->filled('prodi')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('prodi', 'like', '%' . $request->prodi . '%');
            });
        }

        $siswas = $query->get();

        $filename = 'data-siswa-' . date('Ymd') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['No', 'NIM', 'Nama', 'Email', 'Telepon', 'Kelompok', 'Status PKL']);

        foreach ($siswas as $index => $siswa) {
            $kelompok = $siswa->kelompokSiswa->first()?->kelompok;
            fputcsv($handle, [
                $index + 1,
                $siswa->nomor_induk,
                $siswa->name,
                $siswa->email,
                $siswa->phone ?? '-',
                $kelompok->nama_kelompok ?? 'Belum Kelompok',
                $kelompok->status ?? '-',
            ]);
        }

        fclose($handle);
        return Response::make('', 200, $headers);
    }
}