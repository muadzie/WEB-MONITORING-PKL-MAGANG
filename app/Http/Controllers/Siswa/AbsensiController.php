<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;
use App\Models\KelompokSiswa;
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

        $kelompok = $kelompokSiswa->kelompok;
        $perusahaan = $kelompok->perusahaan;
        
        // Cek apakah perusahaan punya koordinat
        if (!$perusahaan->latitude || !$perusahaan->longitude) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Lokasi perusahaan belum diatur oleh admin. Silakan hubungi admin.');
        }

        // Cek apakah PKL sudah berakhir
        $today = Carbon::today();
        $isExpired = $kelompok->tanggal_selesai < $today;

        $absensis = Absensi::where('siswa_id', Auth::id())
                    ->orderBy('tanggal', 'desc')
                    ->paginate(15);

        $todayAbsen = Absensi::where('siswa_id', Auth::id())
                    ->whereDate('tanggal', $today)
                    ->first();

        return view('siswa.absensi.index', compact('absensis', 'todayAbsen', 'perusahaan', 'isExpired'));
    }

    public function store(Request $request)
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return response()->json(['error' => 'Belum terdaftar kelompok'], 400);
        }

        $kelompok = $kelompokSiswa->kelompok;
        $perusahaan = $kelompok->perusahaan;

        // Cek apakah PKL sudah berakhir
        $today = Carbon::today();
        if ($kelompok->tanggal_selesai < $today) {
            return response()->json(['error' => 'Masa PKL Anda telah berakhir. Tidak dapat melakukan absensi.'], 400);
        }
        
        // Validasi lokasi
        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $perusahaan->latitude,
            $perusahaan->longitude
        );
        
        $radius = 100; // meter
        
        if ($distance > $radius) {
            return response()->json([
                'error' => 'Anda berada di luar radius magang. Jarak: ' . round($distance, 2) . ' meter (Maksimal 100 meter)'
            ], 400);
        }

        $existing = Absensi::where('siswa_id', Auth::id())
                    ->whereDate('tanggal', $today)
                    ->first();

        if ($existing) {
            return response()->json(['error' => 'Anda sudah absen hari ini'], 400);
        }

        $absensi = Absensi::create([
            'siswa_id' => Auth::id(),
            'kelompok_siswa_id' => $kelompokSiswa->id,
            'tanggal' => $today,
            'jam_masuk' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_valid_location' => true,
            'status' => 'hadir',
        ]);

        return response()->json(['success' => true, 'message' => 'Absen berhasil! Jarak: ' . round($distance, 2) . ' meter']);
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

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
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