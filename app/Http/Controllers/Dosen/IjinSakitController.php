<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IjinSakit;
use App\Models\KelompokPkl;
use App\Models\KelompokSiswa;
use App\Models\Notifikasi;
use Carbon\Carbon;

class IjinSakitController extends Controller
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
        
        $kelompokIds = KelompokPkl::where('dosen_id', $dosenId)->pluck('id');
        $siswaIds = KelompokSiswa::whereIn('kelompok_pkl_id', $kelompokIds)->pluck('siswa_id');
        
        $query = IjinSakit::with(['siswa', 'kelompokSiswa.kelompok'])
                 ->whereIn('siswa_id', $siswaIds);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        
        $ijinSakits = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $statistik = [
            'pending' => IjinSakit::whereIn('siswa_id', $siswaIds)->where('status', 'pending')->count(),
            'disetujui' => IjinSakit::whereIn('siswa_id', $siswaIds)->where('status', 'disetujui')->count(),
            'ditolak' => IjinSakit::whereIn('siswa_id', $siswaIds)->where('status', 'ditolak')->count(),
        ];
        
        return view('dosen.ijin-sakit.index', compact('ijinSakits', 'statistik'));
    }

    public function approve(Request $request, $id)
    {
        $this->initDosen();
        
        $ijinSakit = IjinSakit::findOrFail($id);
        
        $ijinSakit->update([
            'status' => 'disetujui',
            'catatan_dosen' => $request->catatan_dosen,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        // Notifikasi ke siswa
        Notifikasi::create([
            'user_id' => $ijinSakit->siswa_id,
            'judul' => 'Pengajuan ' . ucfirst($ijinSakit->jenis) . ' Disetujui',
            'pesan' => 'Pengajuan ' . $ijinSakit->jenis . ' Anda telah disetujui oleh dosen pembimbing.',
            'tipe' => 'success',
            'url' => route('siswa.ijin-sakit.show', $ijinSakit->id),
        ]);
        
        return redirect()->back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $this->initDosen();
        
        $request->validate([
            'catatan_dosen' => 'required|string',
        ]);
        
        $ijinSakit = IjinSakit::findOrFail($id);
        
        $ijinSakit->update([
            'status' => 'ditolak',
            'catatan_dosen' => $request->catatan_dosen,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        // Notifikasi ke siswa
        Notifikasi::create([
            'user_id' => $ijinSakit->siswa_id,
            'judul' => 'Pengajuan ' . ucfirst($ijinSakit->jenis) . ' Ditolak',
            'pesan' => 'Pengajuan ' . $ijinSakit->jenis . ' Anda ditolak. Catatan: ' . $request->catatan_dosen,
            'tipe' => 'danger',
            'url' => route('siswa.ijin-sakit.show', $ijinSakit->id),
        ]);
        
        return redirect()->back()->with('error', 'Pengajuan ditolak.');
    }
}