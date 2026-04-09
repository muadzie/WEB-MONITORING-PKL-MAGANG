<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\IjinSakit;
use App\Models\KelompokPkl;
use App\Models\KelompokSiswa;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Storage;

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
        
        $ijinSakits = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('dosen.ijin-sakit.index', compact('ijinSakits'));
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
        
        Notifikasi::create([
            'user_id' => $ijinSakit->siswa_id,
            'judul' => 'Pengajuan ' . ucfirst($ijinSakit->jenis) . ' Disetujui',
            'pesan' => 'Pengajuan Anda telah disetujui oleh dosen pembimbing.',
            'tipe' => 'success',
        ]);
        
        return redirect()->back()->with('success', 'Pengajuan disetujui.');
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
        
        Notifikasi::create([
            'user_id' => $ijinSakit->siswa_id,
            'judul' => 'Pengajuan ' . ucfirst($ijinSakit->jenis) . ' Ditolak',
            'pesan' => 'Pengajuan Anda ditolak. Catatan: ' . $request->catatan_dosen,
            'tipe' => 'danger',
        ]);
        
        return redirect()->back()->with('error', 'Pengajuan ditolak.');
    }

   public function destroy($id)
{
    $this->initDosen();

    $ijinSakit = IjinSakit::findOrFail($id);

    // Hapus file foto jika ada
    if ($ijinSakit->bukti_foto && Storage::disk('public')->exists($ijinSakit->bukti_foto)) {
        Storage::disk('public')->delete($ijinSakit->bukti_foto);
    }

    $ijinSakit->delete();

    return redirect()->route('dosen.ijin-sakit.index')
        ->with('success', 'Pengajuan berhasil dihapus.');
}
}