<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Laporan;
use App\Models\Approval;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    // Approval Logbook oleh Dosen
    public function approveLogbookDosen(Request $request, Logbook $logbook)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah dosen pembimbing
        $dosenId = $logbook->kelompokSiswa->kelompok->dosen->user_id;
        if ($user->id != $dosenId && !$user->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'catatan' => 'nullable|string',
        ]);
        
        $logbook->update([
            'status' => $request->action === 'approve' ? 'disetujui' : 'ditolak',
            'catatan_dosen' => $request->catatan,
            'approved_by_dosen' => $user->id,
            'approved_at_dosen' => now(),
        ]);
        
        // Notifikasi ke siswa
        $siswa = $logbook->kelompokSiswa->siswa;
        $status = $request->action === 'approve' ? 'disetujui' : 'ditolak';
        
        Notifikasi::create([
            'user_id' => $siswa->id,
            'judul' => 'Logbook ' . ucfirst($status),
            'pesan' => 'Logbook tanggal ' . $logbook->tanggal->format('d/m/Y') . 
                      ' telah ' . $status . ' oleh dosen pembimbing.',
            'tipe' => $request->action === 'approve' ? 'success' : 'warning',
            'url' => route('siswa.logbook.show', $logbook->id),
        ]);
        
        $message = $request->action === 'approve' ? 'disetujui' : 'ditolak';
        return redirect()->back()->with('success', "Logbook berhasil {$message}.");
    }
    
    // Approval Logbook oleh PT
    public function approveLogbookPt(Request $request, Logbook $logbook)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah PT tempat PKL
        $ptId = $logbook->kelompokSiswa->kelompok->perusahaan->user_id;
        if ($user->id != $ptId && !$user->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'catatan' => 'nullable|string',
        ]);
        
        $logbook->update([
            'status' => $request->action === 'approve' ? 'disetujui' : 'ditolak',
            'catatan_pt' => $request->catatan,
            'approved_by_pt' => $user->id,
            'approved_at_pt' => now(),
        ]);
        
        // Notifikasi ke siswa
        $siswa = $logbook->kelompokSiswa->siswa;
        $status = $request->action === 'approve' ? 'disetujui' : 'ditolak';
        
        Notifikasi::create([
            'user_id' => $siswa->id,
            'judul' => 'Logbook ' . ucfirst($status),
            'pesan' => 'Logbook tanggal ' . $logbook->tanggal->format('d/m/Y') . 
                      ' telah ' . $status . ' oleh pembimbing PT.',
            'tipe' => $request->action === 'approve' ? 'success' : 'warning',
            'url' => route('siswa.logbook.show', $logbook->id),
        ]);
        
        $message = $request->action === 'approve' ? 'disetujui' : 'ditolak';
        return redirect()->back()->with('success', "Logbook berhasil {$message}.");
    }
    
    // Review Laporan oleh Dosen
    public function reviewLaporan(Request $request, Laporan $laporan)
    {
        $user = Auth::user();
        
        // Cek apakah user adalah dosen pembimbing
        $dosenId = $laporan->kelompokSiswa->kelompok->dosen->user_id;
        if ($user->id != $dosenId && !$user->isAdmin()) {
            abort(403);
        }
        
        $request->validate([
            'catatan_revisi' => 'required_if:action,revisi|string|nullable',
            'status' => 'required|in:setujui,revisi,tolak',
        ]);
        
        $status = [
            'setujui' => 'disetujui',
            'revisi' => 'direvisi',
            'tolak' => 'ditolak',
        ][$request->status];
        
        $laporan->update([
            'status' => $status,
            'catatan_revisi' => $request->catatan_revisi,
            'reviewer_dosen_id' => $user->id,
            'reviewed_at' => now(),
        ]);
        
        // Notifikasi ke siswa
        $siswa = $laporan->kelompokSiswa->siswa;
        $statusText = $status === 'disetujui' ? 'disetujui' : 
                     ($status === 'direvisi' ? 'memerlukan revisi' : 'ditolak');
        
        Notifikasi::create([
            'user_id' => $siswa->id,
            'judul' => 'Laporan ' . ucfirst(str_replace('i', 'i', $statusText)),
            'pesan' => 'Laporan Anda dengan judul "' . $laporan->judul_laporan . 
                      '" telah ' . $statusText . '.',
            'tipe' => $status === 'disetujui' ? 'success' : 'warning',
            'url' => route('siswa.laporan.show', $laporan->id),
        ]);
        
        return redirect()->back()->with('success', 'Review laporan berhasil disimpan.');
    }
}