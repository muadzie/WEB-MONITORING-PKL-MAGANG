<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelompokPkl;
use App\Models\Penilaian;
use App\Models\User;
use App\Models\Logbook;
use App\Models\Laporan;
use App\Models\Perusahaan;
use App\Models\Dosen;
use App\Models\KelompokSiswa;
use Carbon\Carbon;

class ExportController extends Controller
{
    /**
     * Display export page
     */
    public function index()
    {
        $kelompoks = KelompokPkl::orderBy('nama_kelompok')->get();
        return view('admin.export.index', compact('kelompoks'));
    }

    /**
     * Export Kelompok PKL
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
        
        $filename = 'Data-Kelompok-PKL-' . $request->tahun . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateKelompokHTML($kelompoks, $request);
        exit;
    }

    /**
     * Export Nilai PKL
     */
    public function exportNilai(Request $request)
    {
        $request->validate([
            'kelompok_id' => 'required|exists:kelompok_pkls,id',
        ]);

        $kelompok = KelompokPkl::with(['anggota.siswa', 'dosen', 'perusahaan'])->find($request->kelompok_id);
        
        $filename = 'Data-Nilai-PKL-' . $kelompok->nama_kelompok . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateNilaiHTML($kelompok);
        exit;
    }

    /**
     * Export Data Siswa
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
        
        $filename = 'Data-Siswa-PKL-' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateSiswaHTML($siswas, $request);
        exit;
    }

    /**
     * Rekap Siswa (Admin)
     */
    public function rekapSiswa(Request $request)
    {
        $query = User::where('role', 'siswa')
            ->with(['kelompokSiswa.kelompok', 'kelompokSiswa']);
        
        if ($request->filled('angkatan')) {
            $query->whereYear('created_at', $request->angkatan);
        }
        
        if ($request->filled('prodi')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('prodi', 'like', '%' . $request->prodi . '%');
            });
        }
        
        $siswas = $query->get();
        
        $filename = 'Rekap-Data-Siswa-' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateRekapSiswaHTML($siswas, $request);
        exit;
    }

    /**
     * Rekap Kelompok (Admin)
     */
    public function rekapKelompok(Request $request)
    {
        $query = KelompokPkl::with(['dosen', 'perusahaan', 'anggota'])
                 ->withCount('anggota');
        
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $kelompoks = $query->get();
        
        $filename = 'Rekap-Kelompok-PKL-' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateRekapKelompokHTML($kelompoks, $request);
        exit;
    }

    /**
     * Rekap Logbook (Admin)
     */
    public function rekapLogbook(Request $request)
    {
        $query = Logbook::with(['kelompokSiswa.siswa', 'kelompokSiswa.kelompok']);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('kelompok_id')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('kelompok_pkl_id', $request->kelompok_id);
            });
        }
        
        $logbooks = $query->orderBy('tanggal', 'desc')->get();
        
        $filename = 'Rekap-Logbook-PKL-' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateRekapLogbookHTML($logbooks, $request);
        exit;
    }

    /**
     * Rekap Perusahaan (Admin)
     */
    public function rekapPerusahaan(Request $request)
    {
        $query = Perusahaan::withCount('kelompokPkls');
        
        if ($request->filled('bidang_usaha')) {
            $query->where('bidang_usaha', 'like', '%' . $request->bidang_usaha . '%');
        }
        
        $perusahaans = $query->get();
        
        $filename = 'Rekap-Perusahaan-PKL-' . date('Y-m-d') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateRekapPerusahaanHTML($perusahaans, $request);
        exit;
    }

    /**
     * Rekap Tahunan (Admin)
     */
    public function rekapTahunan(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');
        
        // Data per bulan
        $kelompokPerBulan = KelompokPkl::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        $logbookPerBulan = Logbook::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        $laporanPerBulan = Laporan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        $filename = 'Rekap-Tahunan-PKL-' . $tahun . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateRekapTahunanHTML($kelompokPerBulan, $logbookPerBulan, $laporanPerBulan, $tahun);
        exit;
    }

    // ==================== GENERATE HTML METHODS ====================

    private function generateKelompokHTML($kelompoks, $request)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Data Kelompok PKL</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h2 { color: #4472C4; margin: 0; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4472C4; color: white; border: 1px solid #333; padding: 10px; }
            td { border: 1px solid #999; padding: 8px; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .footer { margin-top: 20px; }
            .status-aktif { color: green; font-weight: bold; }
            .status-pending { color: orange; font-weight: bold; }
            .status-selesai { color: blue; font-weight: bold; }
            .status-dibatalkan { color: red; font-weight: bold; }
        </style></head><body>';
        
        $html .= '<div class="header"><h2>DATA KELOMPOK PKL</h2>';
        $html .= '<p>Tahun: ' . $request->tahun . '</p>';
        if ($request->filled('status')) {
            $html .= '<p>Status: ' . ucfirst($request->status) . '</p>';
        }
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        $html .= '<table><thead><tr>';
        $html .= '<th>No</th><th>Nama Kelompok</th><th>Dosen Pembimbing</th><th>Perusahaan</th>';
        $html .= '<th>Jumlah Anggota</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Status</th>';
        $html .= '</tr></thead><tbody>';
        
        $no = 1;
        foreach ($kelompoks as $kelompok) {
            $statusClass = match($kelompok->status) {
                'aktif' => 'status-aktif',
                'pending' => 'status-pending',
                'selesai' => 'status-selesai',
                'dibatalkan' => 'status-dibatalkan',
                default => ''
            };
            
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td>' . $kelompok->nama_kelompok . '</td>';
            $html .= '<td>' . ($kelompok->dosen->nama_dosen ?? '-') . '</td>';
            $html .= '<td>' . ($kelompok->perusahaan->nama_perusahaan ?? '-') . '</td>';
            $html .= '<td align="center">' . $kelompok->anggota->count() . '</td>';
            $html .= '<td align="center">' . Carbon::parse($kelompok->tanggal_mulai)->format('d/m/Y') . '</td>';
            $html .= '<td align="center">' . Carbon::parse($kelompok->tanggal_selesai)->format('d/m/Y') . '</td>';
            $html .= '<td align="center" class="' . $statusClass . '">' . ucfirst($kelompok->status) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer"><p>Total Kelompok: ' . $kelompoks->count() . '</p></div>';
        $html .= '</body></html>';
        
        return $html;
    }

    private function generateNilaiHTML($kelompok)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Data Nilai PKL</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h2 { color: #4472C4; margin: 0; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4472C4; color: white; border: 1px solid #333; padding: 10px; }
            td { border: 1px solid #999; padding: 8px; text-align: center; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .footer { margin-top: 20px; }
            .grade-A { color: green; font-weight: bold; }
            .grade-B { color: blue; font-weight: bold; }
            .grade-C { color: orange; font-weight: bold; }
            .grade-D { color: #cc6600; font-weight: bold; }
            .grade-E { color: red; font-weight: bold; }
        </style></head><body>';
        
        $html .= '<div class="header"><h2>DATA NILAI PKL</h2>';
        $html .= '<p>Kelompok: ' . $kelompok->nama_kelompok . '</p>';
        $html .= '<p>Dosen: ' . ($kelompok->dosen->nama_dosen ?? '-') . '</p>';
        $html .= '<p>Perusahaan: ' . ($kelompok->perusahaan->nama_perusahaan ?? '-') . '</p>';
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        $html .= '</table><thead><tr>';
        $html .= '<th>No</th><th>NIM</th><th>Nama Siswa</th><th>Nilai Dosen</th><th>Nilai PT</th><th>Nilai Akhir</th><th>Grade</th>';
        $html .= '</tr></thead><tbody>';
        
        $no = 1;
        foreach ($kelompok->anggota as $anggota) {
            $nilaiDosen = Penilaian::where('kelompok_siswa_id', $anggota->id)
                          ->where('penilai', 'dosen')
                          ->first();
            
            $nilaiPt = Penilaian::where('kelompok_siswa_id', $anggota->id)
                       ->where('penilai', 'pt')
                       ->first();
            
            $nilaiAkhir = null;
            if ($nilaiDosen && $nilaiPt) {
                $nilaiAkhir = ($nilaiDosen->nilai_akhir + $nilaiPt->nilai_akhir) / 2;
            } elseif ($nilaiDosen) {
                $nilaiAkhir = $nilaiDosen->nilai_akhir;
            } elseif ($nilaiPt) {
                $nilaiAkhir = $nilaiPt->nilai_akhir;
            }
            
            $grade = $this->getGrade($nilaiAkhir);
            $gradeClass = match(true) {
                $nilaiAkhir >= 85 => 'grade-A',
                $nilaiAkhir >= 70 => 'grade-B',
                $nilaiAkhir >= 60 => 'grade-C',
                $nilaiAkhir >= 50 => 'grade-D',
                default => 'grade-E'
            };
            
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td>' . $anggota->nim . '</td>';
            $html .= '<td>' . $anggota->siswa->name . '</td>';
            $html .= '<td align="center">' . ($nilaiDosen->nilai_akhir ?? '-') . '</td>';
            $html .= '<td align="center">' . ($nilaiPt->nilai_akhir ?? '-') . '</td>';
            $html .= '<td align="center"><strong>' . ($nilaiAkhir ? number_format($nilaiAkhir, 2) : '-') . '</strong></td>';
            $html .= '<td align="center" class="' . $gradeClass . '"><strong>' . $grade . '</strong></td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer"><p>Total Siswa: ' . $kelompok->anggota->count() . '</p></div>';
        $html .= '</body></html>';
        
        return $html;
    }

    private function generateSiswaHTML($siswas, $request)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Data Siswa PKL</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h2 { color: #4472C4; margin: 0; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4472C4; color: white; border: 1px solid #333; padding: 10px; }
            td { border: 1px solid #999; padding: 8px; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .footer { margin-top: 20px; }
        </style></head><body>';
        
        $html .= '<div class="header"><h2>DATA SISWA PKL</h2>';
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        $html .= '<table><thead><tr>';
        $html .= '<th>No</th><th>NIM</th><th>Nama</th><th>Email</th><th>Telepon</th>';
        $html .= '<th>Kelompok</th><th>Status Kelompok</th>';
        $html .= '</tr></thead><tbody>';
        
        $no = 1;
        foreach ($siswas as $siswa) {
            $kelompok = $siswa->kelompokSiswa->first()?->kelompok;
            $status = $kelompok ? ucfirst($kelompok->status) : 'Belum Kelompok';
            
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td>' . $siswa->nomor_induk . '</td>';
            $html .= '<td>' . $siswa->name . '</td>';
            $html .= '<td>' . $siswa->email . '</td>';
            $html .= '<td>' . ($siswa->phone ?? '-') . '</td>';
            $html .= '<td>' . ($kelompok->nama_kelompok ?? '-') . '</td>';
            $html .= '<td>' . $status . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer"><p>Total Siswa: ' . $siswas->count() . '</p></div>';
        $html .= '</body></html>';
        
        return $html;
    }

    private function generateRekapSiswaHTML($siswas, $request)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Rekap Data Siswa</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h2 { color: #4472C4; margin: 0; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4472C4; color: white; border: 1px solid #333; padding: 10px; }
            td { border: 1px solid #999; padding: 8px; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .footer { margin-top: 20px; }
        </style></head><body>';
        
        $html .= '<div class="header"><h2>REKAP DATA SISWA PKL</h2>';
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        $html .= '<tr><thead><tr>';
        $html .= '<th>No</th><th>NIM</th><th>Nama</th><th>Email</th><th>Telepon</th>';
        $html .= '<th>Kelompok</th><th>Kelas</th><th>Prodi</th><th>Status</th>';
        $html .= '</tr></thead><tbody>';
        
        $no = 1;
        foreach ($siswas as $siswa) {
            $kelompokSiswa = $siswa->kelompokSiswa->first();
            $kelompok = $kelompokSiswa?->kelompok;
            
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td>' . $siswa->nomor_induk . '</td>';
            $html .= '<td>' . $siswa->name . '</td>';
            $html .= '<td>' . $siswa->email . '</td>';
            $html .= '<td>' . ($siswa->phone ?? '-') . '</td>';
            $html .= '<td>' . ($kelompok->nama_kelompok ?? '-') . '</td>';
            $html .= '<td>' . ($kelompokSiswa->kelas ?? '-') . '</td>';
            $html .= '<td>' . ($kelompokSiswa->prodi ?? '-') . '</td>';
            $html .= '<td>' . ($kelompok ? ucfirst($kelompok->status) : 'Belum Kelompok') . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer"><p>Total Siswa: ' . $siswas->count() . '</p></div>';
        $html .= '</body></html>';
        
        return $html;
    }

    private function generateRekapKelompokHTML($kelompoks, $request)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Rekap Kelompok PKL</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h2 { color: #4472C4; margin: 0; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4472C4; color: white; border: 1px solid #333; padding: 10px; }
            td { border: 1px solid #999; padding: 8px; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .footer { margin-top: 20px; }
            .status-aktif { color: green; font-weight: bold; }
            .status-pending { color: orange; font-weight: bold; }
            .status-selesai { color: blue; font-weight: bold; }
        </style></head><body>';
        
        $html .= '<div class="header"><h2>REKAP KELOMPOK PKL</h2>';
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        $html .= '<table><thead><tr>';
        $html .= '<th>No</th><th>Nama Kelompok</th><th>Dosen Pembimbing</th><th>Perusahaan</th>';
        $html .= '<th>Jumlah Anggota</th><th>Tanggal Mulai</th><th>Tanggal Selesai</th><th>Status</th>';
        $html .= '<tr></thead><tbody>';
        
        $no = 1;
        foreach ($kelompoks as $kelompok) {
            $statusClass = match($kelompok->status) {
                'aktif' => 'status-aktif',
                'pending' => 'status-pending',
                'selesai' => 'status-selesai',
                default => ''
            };
            
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td>' . $kelompok->nama_kelompok . '</td>';
            $html .= '<td>' . ($kelompok->dosen->nama_dosen ?? '-') . '</td>';
            $html .= '<td>' . ($kelompok->perusahaan->nama_perusahaan ?? '-') . '</td>';
            $html .= '<td align="center">' . $kelompok->anggota_count . '</td>';
            $html .= '<td align="center">' . Carbon::parse($kelompok->tanggal_mulai)->format('d/m/Y') . '</td>';
            $html .= '<td align="center">' . Carbon::parse($kelompok->tanggal_selesai)->format('d/m/Y') . '</td>';
            $html .= '<td align="center" class="' . $statusClass . '">' . ucfirst($kelompok->status) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer"><p>Total Kelompok: ' . $kelompoks->count() . '</p></div>';
        $html .= '</body></html>';
        
        return $html;
    }

    private function generateRekapLogbookHTML($logbooks, $request)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Rekap Logbook PKL</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h2 { color: #4472C4; margin: 0; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4472C4; color: white; border: 1px solid #333; padding: 10px; }
            td { border: 1px solid #999; padding: 8px; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .footer { margin-top: 20px; }
            .status-pending { color: orange; font-weight: bold; }
            .status-disetujui { color: green; font-weight: bold; }
            .status-ditolak { color: red; font-weight: bold; }
        </style></head><body>';
        
        $html .= '<div class="header"><h2>REKAP LOGBOOK PKL</h2>';
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        $html .= '<table><thead><tr>';
        $html .= '<th>No</th><th>Tanggal</th><th>Siswa</th><th>NIM</th><th>Kelompok</th>';
        $html .= '<th>Kegiatan</th><th>Jam</th><th>Status</th>';
        $html .= '</tr></thead><tbody>';
        
        $no = 1;
        foreach ($logbooks as $logbook) {
            $statusClass = match($logbook->status) {
                'pending' => 'status-pending',
                'disetujui' => 'status-disetujui',
                'ditolak' => 'status-ditolak',
                default => ''
            };
            
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td align="center">' . Carbon::parse($logbook->tanggal)->format('d/m/Y') . '</td>';
            $html .= '<td>' . ($logbook->kelompokSiswa->siswa->name ?? '-') . '</td>';
            $html .= '<td>' . ($logbook->kelompokSiswa->siswa->nomor_induk ?? '-') . '</td>';
            $html .= '<td>' . ($logbook->kelompokSiswa->kelompok->nama_kelompok ?? '-') . '</td>';
            $html .= '<td>' . substr($logbook->kegiatan, 0, 50) . '...' . '</td>';
            $html .= '<td align="center">' . $logbook->jam_mulai . ' - ' . $logbook->jam_selesai . '</td>';
            $html .= '<td align="center" class="' . $statusClass . '">' . ucfirst($logbook->status) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer"><p>Total Logbook: ' . $logbooks->count() . '</p></div>';
        $html .= '</body></html>';
        
        return $html;
    }

    private function generateRekapPerusahaanHTML($perusahaans, $request)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Rekap Perusahaan PKL</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h2 { color: #4472C4; margin: 0; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4472C4; color: white; border: 1px solid #333; padding: 10px; }
            td { border: 1px solid #999; padding: 8px; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .footer { margin-top: 20px; }
        </style></head><body>';
        
        $html .= '<div class="header"><h2>REKAP PERUSAHAAN PKL</h2>';
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        $html .= '</table><thead><tr>';
        $html .= '<th>No</th><th>Nama Perusahaan</th><th>Bidang Usaha</th><th>Kontak Person</th>';
        $html .= '<th>Telepon</th><th>Email</th><th>Jumlah Kelompok</th><th>Status</th>';
        $html .= '</tr></thead><tbody>';
        
        $no = 1;
        foreach ($perusahaans as $perusahaan) {
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td>' . $perusahaan->nama_perusahaan . '</td>';
            $html .= '<td>' . $perusahaan->bidang_usaha . '</td>';
            $html .= '<td>' . $perusahaan->kontak_person . '</td>';
            $html .= '<td>' . $perusahaan->telepon . '</td>';
            $html .= '<td>' . $perusahaan->email . '</td>';
            $html .= '<td align="center">' . $perusahaan->kelompok_pkls_count . '</td>';
            $html .= '<td align="center">' . ($perusahaan->is_active ? 'Aktif' : 'Nonaktif') . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer"><p>Total Perusahaan: ' . $perusahaans->count() . '</p></div>';
        $html .= '</body></html>';
        
        return $html;
    }

    private function generateRekapTahunanHTML($kelompokPerBulan, $logbookPerBulan, $laporanPerBulan, $tahun)
    {
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataKelompok = array_fill(0, 12, 0);
        $dataLogbook = array_fill(0, 12, 0);
        $dataLaporan = array_fill(0, 12, 0);
        
        foreach ($kelompokPerBulan as $data) {
            $dataKelompok[$data->bulan - 1] = $data->total;
        }
        foreach ($logbookPerBulan as $data) {
            $dataLogbook[$data->bulan - 1] = $data->total;
        }
        foreach ($laporanPerBulan as $data) {
            $dataLaporan[$data->bulan - 1] = $data->total;
        }
        
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Rekap Tahunan PKL</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h2 { color: #4472C4; margin: 0; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4472C4; color: white; border: 1px solid #333; padding: 10px; }
            td { border: 1px solid #999; padding: 8px; text-align: center; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .footer { margin-top: 20px; }
            .total-row { background-color: #e8f0fe; font-weight: bold; }
        </style></head><body>';
        
        $html .= '<div class="header"><h2>REKAP TAHUNAN PKL ' . $tahun . '</h2>';
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        $html .= '<table><thead><tr>';
        $html .= '<th>Bulan</th><th>Kelompok PKL</th><th>Logbook</th><th>Laporan</th>';
        $html .= '</tr></thead><tbody>';
        
        $totalKelompok = 0;
        $totalLogbook = 0;
        $totalLaporan = 0;
        
        for ($i = 0; $i < 12; $i++) {
            $totalKelompok += $dataKelompok[$i];
            $totalLogbook += $dataLogbook[$i];
            $totalLaporan += $dataLaporan[$i];
            
            $html .= '<tr>';
            $html .= '<td align="center"><strong>' . $bulan[$i] . '</strong></td>';
            $html .= '<td align="center">' . $dataKelompok[$i] . '</td>';
            $html .= '<td align="center">' . $dataLogbook[$i] . '</td>';
            $html .= '<td align="center">' . $dataLaporan[$i] . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '<tr class="total-row">';
        $html .= '<td align="center"><strong>TOTAL</strong></td>';
        $html .= '<td align="center"><strong>' . $totalKelompok . '</strong></td>';
        $html .= '<td align="center"><strong>' . $totalLogbook . '</strong></td>';
        $html .= '<td align="center"><strong>' . $totalLaporan . '</strong></td>';
        $html .= '</tr>';
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer">';
        $html .= '<p>Total Kelompok: ' . $totalKelompok . '</p>';
        $html .= '<p>Total Logbook: ' . $totalLogbook . '</p>';
        $html .= '<p>Total Laporan: ' . $totalLaporan . '</p>';
        $html .= '</div></body></html>';
        
        return $html;
    }

    private function getGrade($nilai)
    {
        if ($nilai >= 85) return 'A (Sangat Baik)';
        if ($nilai >= 70) return 'B (Baik)';
        if ($nilai >= 60) return 'C (Cukup)';
        if ($nilai >= 50) return 'D (Kurang)';
        return 'E (Sangat Kurang)';
    }
}