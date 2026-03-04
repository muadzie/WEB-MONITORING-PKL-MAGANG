<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\KelompokSiswa;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Anda belum terdaftar dalam kelompok PKL.');
        }
        
        $laporans = Laporan::where('kelompok_siswa_id', $kelompokSiswa->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
        
        return view('siswa.laporan.index', compact('laporans', 'kelompokSiswa'));
    }
    
    public function create()
    {
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        if (!$kelompokSiswa) {
            return redirect()->route('siswa.dashboard')
                ->with('error', 'Anda belum terdaftar dalam kelompok PKL.');
        }
        
        // Cek apakah sudah punya laporan
        $existing = Laporan::where('kelompok_siswa_id', $kelompokSiswa->id)->first();
        if ($existing) {
            return redirect()->route('siswa.laporan.edit', $existing->id)
                ->with('info', 'Anda sudah memiliki laporan. Silakan edit laporan yang ada.');
        }
        
        return view('siswa.laporan.create', compact('kelompokSiswa'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'abstrak' => 'required|string',
            'file_laporan' => 'required|mimes:pdf,doc,docx|max:10240',
            'file_presentasi' => 'nullable|mimes:pdf,pptx,ppt|max:20480',
        ]);
        
        $kelompokSiswa = Auth::user()->kelompokSiswa()->first();
        
        // Upload file laporan
        $fileLaporanPath = $request->file('file_laporan')
            ->store('laporan/' . $kelompokSiswa->id, 'public');
        
        // Upload file presentasi jika ada
        $filePresentasiPath = null;
        if ($request->hasFile('file_presentasi')) {
            $filePresentasiPath = $request->file('file_presentasi')
                ->store('presentasi/' . $kelompokSiswa->id, 'public');
        }
        
        $laporan = Laporan::create([
            'kelompok_siswa_id' => $kelompokSiswa->id,
            'judul_laporan' => $request->judul_laporan,
            'abstrak' => $request->abstrak,
            'file_laporan' => $fileLaporanPath,
            'file_presentasi' => $filePresentasiPath,
            'status' => 'draft',
        ]);
        
        return redirect()->route('siswa.laporan.index')
            ->with('success', 'Laporan berhasil dibuat. Silakan submit untuk direview.');
    }
    
    public function edit(Laporan $laporan)
    {
        // Cek kepemilikan
        if ($laporan->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403);
        }
        
        // Cek status (hanya bisa edit jika draft atau direvisi)
        if (!in_array($laporan->status, ['draft', 'direvisi'])) {
            return redirect()->route('siswa.laporan.index')
                ->with('error', 'Laporan sudah diproses dan tidak dapat diedit.');
        }
        
        return view('siswa.laporan.edit', compact('laporan'));
    }
    
    public function update(Request $request, Laporan $laporan)
    {
        // Cek kepemilikan
        if ($laporan->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403);
        }
        
        // Cek status
        if (!in_array($laporan->status, ['draft', 'direvisi'])) {
            return redirect()->route('siswa.laporan.index')
                ->with('error', 'Laporan sudah diproses dan tidak dapat diedit.');
        }
        
        $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'abstrak' => 'required|string',
            'file_laporan' => 'nullable|mimes:pdf,doc,docx|max:10240',
            'file_presentasi' => 'nullable|mimes:pdf,pptx,ppt|max:20480',
        ]);
        
        $data = [
            'judul_laporan' => $request->judul_laporan,
            'abstrak' => $request->abstrak,
        ];
        
        // Upload file laporan baru jika ada
        if ($request->hasFile('file_laporan')) {
            // Hapus file lama
            Storage::disk('public')->delete($laporan->file_laporan);
            $data['file_laporan'] = $request->file('file_laporan')
                ->store('laporan/' . $laporan->kelompokSiswa_id, 'public');
        }
        
        // Upload file presentasi baru jika ada
        if ($request->hasFile('file_presentasi')) {
            // Hapus file lama
            if ($laporan->file_presentasi) {
                Storage::disk('public')->delete($laporan->file_presentasi);
            }
            $data['file_presentasi'] = $request->file('file_presentasi')
                ->store('presentasi/' . $laporan->kelompokSiswa_id, 'public');
        }
        
        $laporan->update($data);
        
        return redirect()->route('siswa.laporan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }
    
    public function submit(Laporan $laporan)
    {
        // Cek kepemilikan
        if ($laporan->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403);
        }
        
        // Cek status
        if (!in_array($laporan->status, ['draft', 'direvisi'])) {
            return redirect()->route('siswa.laporan.index')
                ->with('error', 'Laporan tidak dapat disubmit.');
        }
        
        $laporan->update([
            'status' => 'diajukan',
        ]);
        
        // Notifikasi ke dosen
        $dosen = $laporan->kelompokSiswa->kelompok->dosen->user;
        Notifikasi::create([
            'user_id' => $dosen->id,
            'judul' => 'Laporan Baru',
            'pesan' => Auth::user()->name . ' mengajukan laporan untuk direview.',
            'tipe' => 'info',
            'url' => route('dosen.laporan.review', $laporan->id),
        ]);
        
        return redirect()->route('siswa.laporan.index')
            ->with('success', 'Laporan berhasil disubmit. Silakan tunggu review dari dosen.');
    }
    
    public function show(Laporan $laporan)
    {
        // Cek kepemilikan
        if ($laporan->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403);
        }
        
        return view('siswa.laporan.show', compact('laporan'));
    }
    
    public function destroy(Laporan $laporan)
    {
        // Cek kepemilikan
        if ($laporan->kelompokSiswa->siswa_id != Auth::id()) {
            abort(403);
        }
        
        // Cek status (hanya bisa hapus jika draft)
        if ($laporan->status != 'draft') {
            return redirect()->route('siswa.laporan.index')
                ->with('error', 'Laporan sudah diproses dan tidak dapat dihapus.');
        }
        
        // Hapus file
        Storage::disk('public')->delete($laporan->file_laporan);
        if ($laporan->file_presentasi) {
            Storage::disk('public')->delete($laporan->file_presentasi);
        }
        
        $laporan->delete();
        
        return redirect()->route('siswa.laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
    
    public function download(Laporan $laporan, $type)
    {
        // Cek kepemilikan
        if ($laporan->kelompokSiswa->siswa_id != Auth::id() && 
            !Auth::user()->isAdmin() && 
            !Auth::user()->isDosen()) {
            abort(403);
        }
        
        $file = $type === 'laporan' ? $laporan->file_laporan : $laporan->file_presentasi;
        
        if (!$file) {
            return back()->with('error', 'File tidak ditemukan.');
        }
        
        return Storage::disk('public')->download($file);
    }
}