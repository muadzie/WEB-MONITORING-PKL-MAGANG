<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelompokPkl;
use App\Models\Dosen;
use App\Models\Perusahaan;
use App\Models\User;
use App\Models\KelompokSiswa;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\DB;

class KelompokController extends Controller
{
    public function index(Request $request)
    {
        $query = KelompokPkl::with(['dosen', 'perusahaan', 'anggota.siswa']);
        
        if ($request->filled('search')) {
            $query->where('nama_kelompok', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('dosen_id')) {
            $query->where('dosen_id', $request->dosen_id);
        }
        
        $kelompoks = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $dosens = Dosen::where('is_active', true)->orderBy('nama_dosen')->get();
        $statusList = ['pending', 'aktif', 'selesai', 'dibatalkan'];
        
        return view('admin.kelompok.index', compact('kelompoks', 'dosens', 'statusList'));
    }
    
    public function create()
    {
        $dosens = Dosen::where('is_active', true)->orderBy('nama_dosen')->get();
        $perusahaans = Perusahaan::where('is_active', true)->orderBy('nama_perusahaan')->get();
        $siswas = User::where('role', 'siswa')
                ->whereDoesntHave('kelompokSiswa')
                ->orderBy('name')
                ->get();
        
        return view('admin.kelompok.create', compact('dosens', 'perusahaans', 'siswas'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|unique:kelompok_pkls',
            'dosen_id' => 'required|exists:dosens,id',
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'siswa_ids' => 'required|array|min:1',
            'siswa_ids.*' => 'exists:users,id',
            'nims' => 'required|array',
            'nims.*' => 'required|string',
            'kelass' => 'required|array',
            'kelass.*' => 'required|string',
            'prodis' => 'required|array',
            'prodis.*' => 'required|string',
            'status_anggota' => 'required|array',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Buat kelompok
            $kelompok = KelompokPkl::create([
                'nama_kelompok' => $request->nama_kelompok,
                'dosen_id' => $request->dosen_id,
                'perusahaan_id' => $request->perusahaan_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'status' => 'pending',
            ]);
            
            // Tambahkan anggota
            foreach ($request->siswa_ids as $index => $siswaId) {
                KelompokSiswa::create([
                    'kelompok_pkl_id' => $kelompok->id,
                    'siswa_id' => $siswaId,
                    'nim' => $request->nims[$index],
                    'kelas' => $request->kelass[$index],
                    'prodi' => $request->prodis[$index],
                    'status_anggota' => $request->status_anggota[$index] ?? 'anggota',
                ]);
            }
            
            // Notifikasi ke dosen
            $dosen = Dosen::find($request->dosen_id);
            if ($dosen && $dosen->user) {
                Notifikasi::create([
                    'user_id' => $dosen->user->id,
                    'judul' => 'Kelompok PKL Baru',
                    'pesan' => "Anda ditugaskan sebagai pembimbing kelompok {$kelompok->nama_kelompok}",
                    'tipe' => 'info',
                    'url' => route('dosen.bimbingan.show', $kelompok->id),
                ]);
            }
            
            // Notifikasi ke PT
            $perusahaan = Perusahaan::find($request->perusahaan_id);
            if ($perusahaan && $perusahaan->user) {
                Notifikasi::create([
                    'user_id' => $perusahaan->user->id,
                    'judul' => 'Kelompok PKL Baru',
                    'pesan' => "Kelompok {$kelompok->nama_kelompok} akan PKL di perusahaan Anda",
                    'tipe' => 'info',
                    'url' => route('pt.monitoring.show', $kelompok->id),
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('admin.kelompok.index')
                ->with('success', 'Kelompok PKL berhasil dibuat.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function show(KelompokPkl $kelompok)
    {
        $kelompok->load(['dosen', 'perusahaan', 'anggota.siswa']);
        
        return view('admin.kelompok.show', compact('kelompok'));
    }
    
    public function edit(KelompokPkl $kelompok)
    {
        $dosens = Dosen::where('is_active', true)->orderBy('nama_dosen')->get();
        $perusahaans = Perusahaan::where('is_active', true)->orderBy('nama_perusahaan')->get();
        
        return view('admin.kelompok.edit', compact('kelompok', 'dosens', 'perusahaans'));
    }
    
    public function update(Request $request, KelompokPkl $kelompok)
    {
        $request->validate([
            'nama_kelompok' => 'required|string|unique:kelompok_pkls,nama_kelompok,' . $kelompok->id,
            'dosen_id' => 'required|exists:dosens,id',
            'perusahaan_id' => 'required|exists:perusahaans,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:pending,aktif,selesai,dibatalkan',
        ]);
        
        $kelompok->update($request->all());
        
        return redirect()->route('admin.kelompok.index')
            ->with('success', 'Kelompok PKL berhasil diperbarui.');
    }
    
    public function approve(Request $request, KelompokPkl $kelompok)
    {
        $request->validate([
            'status' => 'required|in:aktif,dibatalkan',
            'catatan' => 'nullable|string',
        ]);
        
        $kelompok->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);
        
        // Notifikasi ke semua anggota
        foreach ($kelompok->anggota as $anggota) {
            Notifikasi::create([
                'user_id' => $anggota->siswa_id,
                'judul' => 'Status Kelompok PKL',
                'pesan' => "Kelompok {$kelompok->nama_kelompok} telah {$kelompok->status}",
                'tipe' => $kelompok->status === 'aktif' ? 'success' : 'warning',
            ]);
        }
        
        $message = $kelompok->status === 'aktif' ? 'diaktifkan' : 'dibatalkan';
        return redirect()->back()->with('success', "Kelompok PKL berhasil {$message}.");
    }
    
    public function destroy(KelompokPkl $kelompok)
    {
        $kelompok->delete();
        
        return redirect()->route('admin.kelompok.index')
            ->with('success', 'Kelompok PKL berhasil dihapus.');
    }
    
    public function getSiswaData(User $siswa)
    {
        return response()->json([
            'nim' => $siswa->nomor_induk,
            'nama' => $siswa->name,
            'email' => $siswa->email,
        ]);
    }
    public function selesaikan(KelompokPkl $kelompok)
{
    $kelompok->update(['status' => 'selesai']);
    return redirect()->back()->with('success', 'Kelompok PKL telah diselesaikan.');
}
}