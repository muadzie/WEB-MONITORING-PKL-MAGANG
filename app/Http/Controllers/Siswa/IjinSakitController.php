<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\IjinSakit;
use App\Models\KelompokSiswa;
use App\Models\Logbook;
use App\Models\Notifikasi;
use Carbon\Carbon;

class IjinSakitController extends Controller
{
    public function index()
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Anda belum terdaftar dalam kelompok PKL.');
        }

        $ijinSakits = IjinSakit::where('siswa_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('siswa.ijin-sakit.index', compact('ijinSakits', 'kelompokSiswa'));
    }

    public function create()
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Anda belum terdaftar dalam kelompok PKL.');
        }

        return view('siswa.ijin-sakit.create', compact('kelompokSiswa'));
    }

    public function store(Request $request)
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis' => 'required|in:izin,sakit',
            'alasan' => 'required|string|min:10',
            'bukti_foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload bukti foto
        $buktiPath = $request->file('bukti_foto')->store('ijin-sakit', 'public');

        $ijinSakit = IjinSakit::create([
            'siswa_id' => Auth::id(),
            'kelompok_siswa_id' => $kelompokSiswa->id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis' => $request->jenis,
            'alasan' => $request->alasan,
            'bukti_foto' => $buktiPath,
            'status' => 'pending',
        ]);

        // Notifikasi ke dosen
        $dosen = $kelompokSiswa->kelompok->dosen;
        if ($dosen && $dosen->user) {
            Notifikasi::create([
                'user_id' => $dosen->user->id,
                'judul' => 'Pengajuan ' . ucfirst($request->jenis),
                'pesan' => Auth::user()->name . ' mengajukan ' . $request->jenis . ' dari ' . 
                          Carbon::parse($request->tanggal_mulai)->format('d/m/Y') . ' s/d ' .
                          Carbon::parse($request->tanggal_selesai)->format('d/m/Y'),
                'tipe' => 'info',
                'url' => route('dosen.ijin-sakit.index'),
            ]);
        }

        return redirect()->route('siswa.ijin-sakit.index')
            ->with('success', 'Pengajuan ' . $request->jenis . ' berhasil dikirim. Menunggu persetujuan dosen.');
    }

    public function show(IjinSakit $ijinSakit)
    {
        if ($ijinSakit->siswa_id != Auth::id()) {
            abort(403);
        }

        return view('siswa.ijin-sakit.show', compact('ijinSakit'));
    }

    public function destroy(IjinSakit $ijinSakit)
    {
        if ($ijinSakit->siswa_id != Auth::id()) {
            abort(403);
        }

        if ($ijinSakit->status != 'pending') {
            return back()->with('error', 'Pengajuan sudah diproses, tidak dapat dibatalkan.');
        }

        if ($ijinSakit->bukti_foto) {
            Storage::disk('public')->delete($ijinSakit->bukti_foto);
        }

        $ijinSakit->delete();

        return redirect()->route('siswa.ijin-sakit.index')
            ->with('success', 'Pengajuan berhasil dibatalkan.');
    }
}