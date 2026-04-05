<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\KelompokSiswa;
use App\Models\Logbook;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Anda belum terdaftar dalam kelompok PKL.');
        }

        $absensis = Absensi::where('siswa_id', Auth::id())
                    ->orderBy('tanggal', 'desc')
                    ->paginate(15);

        $today = Carbon::today();
        $todayAbsen = Absensi::where('siswa_id', Auth::id())
                    ->whereDate('tanggal', $today)
                    ->first();

        $perusahaan = $kelompokSiswa->kelompok->perusahaan;

        return view('siswa.absensi.index', compact('absensis', 'todayAbsen', 'perusahaan'));
    }

    public function store(Request $request)
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return response()->json(['error' => 'Belum terdaftar kelompok'], 400);
        }

        $today = Carbon::today();
        $existing = Absensi::where('siswa_id', Auth::id())
                    ->whereDate('tanggal', $today)
                    ->first();

        if ($existing) {
            return response()->json(['error' => 'Anda sudah absen hari ini'], 400);
        }

        // Validasi lokasi
        $perusahaan = $kelompokSiswa->kelompok->perusahaan;
        $jarak = $this->hitungJarak(
            $request->latitude,
            $request->longitude,
            $perusahaan->latitude,
            $perusahaan->longitude
        );

        $isValid = $jarak <= 100; // Maksimal 100 meter

        $absensi = Absensi::create([
            'siswa_id' => Auth::id(),
            'kelompok_siswa_id' => $kelompokSiswa->id,
            'tanggal' => $today,
            'jam_masuk' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'lokasi_absen' => $request->lokasi,
            'is_valid_location' => $isValid,
            'status' => $isValid ? 'hadir' : 'alpha',
        ]);

        // Cek apakah hari ini ada izin/sakit
        $ijinSakit = \App\Models\IjinSakit::where('siswa_id', Auth::id())
                    ->where('status', 'disetujui')
                    ->whereDate('tanggal_mulai', '<=', $today)
                    ->whereDate('tanggal_selesai', '>=', $today)
                    ->first();

        if ($ijinSakit) {
            $absensi->update([
                'status' => $ijinSakit->jenis,
                'keterangan' => $ijinSakit->alasan,
                'bukti_foto' => $ijinSakit->bukti_foto,
            ]);
        }

        return response()->json([
            'success' => true,
            'is_valid' => $isValid,
            'message' => $isValid ? 'Absen berhasil' : 'Anda di luar radius lokasi magang'
        ]);
    }

    public function absenKeluar(Request $request)
    {
        $today = Carbon::today();
        $absensi = Absensi::where('siswa_id', Auth::id())
                    ->whereDate('tanggal', $today)
                    ->first();

        if (!$absensi) {
            return response()->json(['error' => 'Belum absen masuk'], 400);
        }

        if ($absensi->jam_keluar) {
            return response()->json(['error' => 'Sudah absen keluar'], 400);
        }

        $absensi->update(['jam_keluar' => now()]);

        return response()->json(['success' => true, 'message' => 'Absen keluar berhasil']);
    }

    private function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter
        
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
        
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;
        
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos($lat1) * cos($lat2) *
             sin($dLon / 2) * sin($dLon / 2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        return $earthRadius * $c;
    }
}