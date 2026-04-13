<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\KelompokPkl;
use App\Models\KelompokSiswa;
use App\Models\Notifikasi;
use App\Models\User;
use Carbon\Carbon;

class AbsensiDosenController extends Controller
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

    protected function getDosenId()
    {
        $this->initDosen();
        return $this->dosen->id;
    }

    protected function getSiswaIds()
    {
        $dosenId = $this->getDosenId();
        $kelompokIds = KelompokPkl::where('dosen_id', $dosenId)->pluck('id');
        return KelompokSiswa::whereIn('kelompok_pkl_id', $kelompokIds)->pluck('siswa_id');
    }

     public function index(Request $request)
    {
        $dosenId = $this->getDosenId();
        
        $kelompoks = KelompokPkl::where('dosen_id', $dosenId)->get();
        
        $selectedKelompok = null;
        $siswas = collect();
        $isExpired = false;
        
        if ($request->filled('kelompok_id')) {
            $selectedKelompok = KelompokPkl::with('anggota.siswa')->find($request->kelompok_id);
            if ($selectedKelompok) {
                // Cek apakah PKL sudah berakhir
                $today = Carbon::today();
                $isExpired = $selectedKelompok->tanggal_selesai < $today;
                
                if (!$isExpired) {
                    $siswas = $selectedKelompok->anggota->map(function($item) {
                        $item->siswa->absensi_hari_ini = Absensi::where('siswa_id', $item->siswa_id)
                                                            ->whereDate('tanggal', Carbon::today())
                                                            ->first();
                        return $item->siswa;
                    });
                }
            }
        }
        
        return view('dosen.absensi.index', compact('kelompoks', 'selectedKelompok', 'siswas', 'isExpired'));
    }

    public function absenSiswa(Request $request, $siswaId)
    {
        $dosenId = $this->getDosenId();
        
        $siswa = User::findOrFail($siswaId);
        $kelompokSiswa = KelompokSiswa::where('siswa_id', $siswaId)->first();
        
        if (!$kelompokSiswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan dalam kelompok'], 400);
        }
        
        // Cek apakah PKL sudah berakhir
        $kelompok = $kelompokSiswa->kelompok;
        if ($kelompok->tanggal_selesai < Carbon::today()) {
            return response()->json(['error' => 'Masa PKL kelompok ini telah berakhir, tidak dapat melakukan absensi.'], 400);
        }
        
        $today = Carbon::today();
        $existing = Absensi::where('siswa_id', $siswaId)
                    ->whereDate('tanggal', $today)
                    ->first();
        
        if ($existing) {
            return response()->json(['error' => 'Siswa sudah absen hari ini'], 400);
        }
        
        $absensi = Absensi::create([
            'siswa_id' => $siswaId,
            'kelompok_siswa_id' => $kelompokSiswa->id,
            'tanggal' => $today,
            'jam_masuk' => now(),
            'dosen_id' => $dosenId,
            'dosen_absen_at' => now(),
            'status' => 'hadir',
            'is_valid_location' => true,
        ]);
        
        Notifikasi::create([
            'user_id' => $siswaId,
            'judul' => 'Absensi oleh Dosen',
            'pesan' => 'Anda telah diabsensi oleh dosen pembimbing pada hari ini',
            'tipe' => 'success',
            'url' => route('siswa.absensi.index'),
        ]);
        
        return response()->json(['success' => true, 'message' => 'Absen berhasil!']);
    }

    public function rekap(Request $request)
    {
        $dosenId = $this->getDosenId();
        $siswaIds = $this->getSiswaIds();
        
        $kelompoks = KelompokPkl::where('dosen_id', $dosenId)->orderBy('nama_kelompok')->get();
        
        $query = Absensi::with(['siswa', 'kelompokSiswa.kelompok'])
                 ->whereIn('siswa_id', $siswaIds);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('kelompok_id')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('kelompok_pkl_id', $request->kelompok_id);
            });
        }
        
        $absensis = $query->orderBy('tanggal', 'desc')->paginate(20);
        $siswas = User::whereIn('id', $siswaIds)->orderBy('name')->get();
        
        $absensiQuery = Absensi::whereIn('siswa_id', $siswaIds);
        $statistik = [
            'total_hadir' => (clone $absensiQuery)->where('status', 'hadir')->count(),
            'total_izin' => (clone $absensiQuery)->where('status', 'izin')->count(),
            'total_sakit' => (clone $absensiQuery)->where('status', 'sakit')->count(),
            'total_alpha' => (clone $absensiQuery)->where('status', 'alpha')->count(),
            'total_siswa' => $siswas->count(),
            'total_absensi' => $absensiQuery->count(),
        ];
        
        return view('dosen.absensi.rekap', compact('absensis', 'kelompoks', 'siswas', 'statistik'));
    }

    /**
     * Export detail absensi ke Excel (Manual - HTML)
     */
    public function exportExcel(Request $request)
    {
        $dosenId = $this->getDosenId();
        $kelompokIds = KelompokPkl::where('dosen_id', $dosenId)->pluck('id');
        $siswaIds = KelompokSiswa::whereIn('kelompok_pkl_id', $kelompokIds)->pluck('siswa_id');
        
        $query = Absensi::with(['siswa', 'kelompokSiswa.kelompok', 'dosen'])
                 ->whereIn('siswa_id', $siswaIds);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('kelompok_id')) {
            $query->whereHas('kelompokSiswa', function($q) use ($request) {
                $q->where('kelompok_pkl_id', $request->kelompok_id);
            });
        }
        
        $absensis = $query->orderBy('tanggal', 'asc')->get();
        $filename = 'rekap-absensi-detail-' . date('Y-m-d-H-i-s') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateDetailHTML($absensis, $request);
        exit;
    }

    /**
     * Export rekap per siswa ke Excel (Manual - HTML)
     */
    public function exportRekapSiswa(Request $request)
    {
        $dosenId = $this->getDosenId();
        $kelompokIds = KelompokPkl::where('dosen_id', $dosenId)->pluck('id');
        $siswaIds = KelompokSiswa::whereIn('kelompok_pkl_id', $kelompokIds)->pluck('siswa_id');
        
        if ($request->filled('kelompok_id')) {
            $kelompokSiswaIds = KelompokSiswa::where('kelompok_pkl_id', $request->kelompok_id)->pluck('siswa_id');
            $siswaIds = $siswaIds->intersect($kelompokSiswaIds);
        }
        
        $siswas = User::whereIn('id', $siswaIds)
                 ->with(['kelompokSiswa.kelompok'])
                 ->orderBy('name')
                 ->get();
        
        $filename = 'rekap-absensi-per-siswa-' . date('Y-m-d-H-i-s') . '.xls';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        echo $this->generateRekapHTML($siswas, $request);
        exit;
    }

    private function generateDetailHTML($absensis, $request)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Rekap Absensi PKL</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h2 { color: #4472C4; margin: 0; }
            table { border-collapse: collapse; width: 100%; }
            th { background-color: #4472C4; color: white; border: 1px solid #333; padding: 10px; }
            td { border: 1px solid #999; padding: 8px; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            .footer { margin-top: 20px; }
            .hadir { color: green; font-weight: bold; }
            .izin { color: blue; font-weight: bold; }
            .sakit { color: orange; font-weight: bold; }
            .alpha { color: red; font-weight: bold; }
        </style></head><body>';
        
        $html .= '<div class="header"><h2>LAPORAN REKAP ABSENSI PKL</h2>';
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        if ($request->filled('tanggal_mulai') || $request->filled('tanggal_selesai')) {
            $periode = ($request->tanggal_mulai ?? 'Awal') . ' s/d ' . ($request->tanggal_selesai ?? 'Sekarang');
            $html .= '<p><strong>Periode:</strong> ' . $periode . '</p>';
        }
        
        $html .= '<table><thead><tr>';
        $html .= '<th>No</th><th>Tanggal</th><th>Nama Siswa</th><th>NIM</th><th>Kelompok</th>';
        $html .= '<th>Jam Masuk</th><th>Jam Keluar</th><th>Status</th><th>Keterangan</th><th>Validasi</th><th>Diabsen Oleh</th>';
        $html .= '</tr></thead><tbody>';
        
        $no = 1;
        foreach ($absensis as $absen) {
            $statusClass = match($absen->status) {
                'hadir' => 'hadir',
                'izin' => 'izin',
                'sakit' => 'sakit',
                'alpha' => 'alpha',
                default => ''
            };
            
            $html .= '<tr>';
            $html .= '<td align="center">' . $no++ . '</td>';
            $html .= '<td align="center">' . Carbon::parse($absen->tanggal)->format('d/m/Y') . '</td>';
            $html .= '<td>' . $absen->siswa->name . '</td>';
            $html .= '<td>' . $absen->siswa->nomor_induk . '</td>';
            $html .= '<td>' . $absen->kelompokSiswa->kelompok->nama_kelompok . '</td>';
            $html .= '<td align="center">' . ($absen->jam_masuk ? Carbon::parse($absen->jam_masuk)->format('H:i:s') : '-') . '</td>';
            $html .= '<td align="center">' . ($absen->jam_keluar ? Carbon::parse($absen->jam_keluar)->format('H:i:s') : '-') . '</td>';
            $html .= '<td align="center" class="' . $statusClass . '">' . $this->getStatusText($absen->status) . '</td>';
            $html .= '<td>' . ($absen->keterangan ?? '-') . '</td>';
            $html .= '<td align="center">' . ($absen->is_valid_location ? 'Valid' : 'Tidak Valid') . '</td>';
            $html .= '<td>' . ($absen->dosen ? $absen->dosen->nama_dosen : '-') . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer">';
        $html .= '<p>Total Data: ' . $absensis->count() . '</p>';
        $html .= '<p>Total Hadir: ' . $absensis->where('status', 'hadir')->count() . '</p>';
        $html .= '<p>Total Izin: ' . $absensis->where('status', 'izin')->count() . '</p>';
        $html .= '<p>Total Sakit: ' . $absensis->where('status', 'sakit')->count() . '</p>';
        $html .= '<p>Total Alpha: ' . $absensis->where('status', 'alpha')->count() . '</p>';
        $html .= '</div></body></html>';
        
        return $html;
    }

    private function generateRekapHTML($siswas, $request)
    {
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Rekap Absensi Per Siswa</title>';
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
        
        $html .= '<div class="header"><h2>REKAPITULASI ABSENSI PER SISWA</h2>';
        $html .= '<p>Tanggal Export: ' . Carbon::now()->format('d F Y H:i:s') . '</p></div>';
        
        if ($request->filled('kelompok_id')) {
            $kelompok = KelompokPkl::find($request->kelompok_id);
            $html .= '<p><strong>Kelompok:</strong> ' . ($kelompok ? $kelompok->nama_kelompok : '-') . '</p>';
        }
        
        $html .= '<table><thead><tr>';
        $html .= '<th>No</th><th>Nama Siswa</th><th>NIM</th><th>Kelompok</th>';
        $html .= '<th>Hadir</th><th>Izin</th><th>Sakit</th><th>Alpha</th><th>Total</th><th>Persentase</th><th>Grade</th>';
        $html .= '</tr></thead><tbody>';
        
        $no = 1;
        $totalPersentase = 0;
        
        foreach ($siswas as $siswa) {
            $absensis = Absensi::where('siswa_id', $siswa->id)->get();
            
            $totalHadir = $absensis->where('status', 'hadir')->count();
            $totalIzin = $absensis->where('status', 'izin')->count();
            $totalSakit = $absensis->where('status', 'sakit')->count();
            $totalAlpha = $absensis->where('status', 'alpha')->count();
            $totalAbsensi = $absensis->count();
            
            $persentase = $totalAbsensi > 0 ? round(($totalHadir / $totalAbsensi) * 100, 2) : 0;
            $totalPersentase += $persentase;
            
            $grade = $this->getGrade($persentase);
            $gradeClass = match(true) {
                $persentase >= 90 => 'grade-A',
                $persentase >= 75 => 'grade-B',
                $persentase >= 60 => 'grade-C',
                $persentase >= 50 => 'grade-D',
                default => 'grade-E'
            };
            
            $html .= '<tr>';
            $html .= '<td>' . $no++ . '</td>';
            $html .= '<td>' . $siswa->name . '</td>';
            $html .= '<td>' . $siswa->nomor_induk . '</td>';
            $html .= '<td>' . ($siswa->kelompokSiswa->first()?->kelompok->nama_kelompok ?? '-') . '</td>';
            $html .= '<td>' . $totalHadir . '</td>';
            $html .= '<td>' . $totalIzin . '</td>';
            $html .= '<td>' . $totalSakit . '</td>';
            $html .= '<td>' . $totalAlpha . '</td>';
            $html .= '<td><strong>' . $totalAbsensi . '</strong></td>';
            $html .= '<td><strong>' . $persentase . '%</strong></td>';
            $html .= '<td class="' . $gradeClass . '"><strong>' . $grade . '</strong></td>';
            $html .= '</tr>';
        }
        
        $rataRata = $siswas->count() > 0 ? round($totalPersentase / $siswas->count(), 2) : 0;
        $gradeKeseluruhan = $this->getGrade($rataRata);
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer">';
        $html .= '<p>Total Siswa: ' . $siswas->count() . '</p>';
        $html .= '<p>Rata-rata Kehadiran: ' . $rataRata . '%</p>';
        $html .= '<p>Grade Keseluruhan: ' . $gradeKeseluruhan . '</p>';
        $html .= '</div></body></html>';
        
        return $html;
    }

    private function getStatusText($status)
    {
        return match($status) {
            'hadir' => 'Hadir',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            default => ucfirst($status)
        };
    }

    private function getGrade($persentase)
    {
        if ($persentase >= 90) return 'A (Sangat Baik)';
        if ($persentase >= 75) return 'B (Baik)';
        if ($persentase >= 60) return 'C (Cukup)';
        if ($persentase >= 50) return 'D (Kurang)';
        return 'E (Sangat Kurang)';
    }
}