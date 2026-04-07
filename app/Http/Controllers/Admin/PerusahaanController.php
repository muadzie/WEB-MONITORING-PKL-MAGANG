<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Perusahaan::with('user');
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_perusahaan', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('kontak_person', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('bidang_usaha')) {
            $query->where('bidang_usaha', 'like', '%' . $request->bidang_usaha . '%');
        }
        
        $perusahaans = $query->orderBy('nama_perusahaan')->paginate(15);
        $bidangUsahaList = Perusahaan::distinct('bidang_usaha')->pluck('bidang_usaha');
        
        return view('admin.perusahaans.index', compact('perusahaans', 'bidangUsahaList'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.perusahaans.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:perusahaans|unique:users,email',
            'bidang_usaha' => 'required|string',
            'deskripsi' => 'nullable|string',
            'kontak_person' => 'required|string|max:255',
            'jabatan_kontak' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'create_user' => 'boolean',
            'password' => 'required_if:create_user,true|nullable|min:8|confirmed',
        ]);
        
        // Upload logo
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $logoPath = $file->storeAs('perusahaan/logo', $filename, 'public');
        }
        
        // Buat user account jika diperlukan
        $userId = null;
        if ($request->create_user) {
            $user = User::create([
                'name' => $request->nama_perusahaan,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nomor_induk' => 'PT' . time(),
                'phone' => $request->telepon,
                'address' => $request->alamat,
                'role' => 'pt',
                'foto' => $logoPath,
                'is_active' => true,
            ]);
            $userId = $user->id;
        }
        
        // Buat data perusahaan
        $perusahaan = Perusahaan::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'bidang_usaha' => $request->bidang_usaha,
            'deskripsi' => $request->deskripsi,
            'kontak_person' => $request->kontak_person,
            'jabatan_kontak' => $request->jabatan_kontak,
            'logo' => $logoPath,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'user_id' => $userId,
            'is_active' => true,
        ]);
        
        return redirect()->route('admin.perusahaans.index')
            ->with('success', 'Data perusahaan berhasil ditambahkan.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Perusahaan $perusahaan)
    {
        $perusahaan->load(['user', 'kelompokPkls.dosen', 'kelompokPkls.anggota.siswa']);
        
        return view('admin.perusahaans.show', compact('perusahaan'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Perusahaan $perusahaan)
    {
        return view('admin.perusahaans.edit', compact('perusahaan'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Perusahaan $perusahaan)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:perusahaans,email,' . $perusahaan->id,
            'bidang_usaha' => 'required|string',
            'deskripsi' => 'nullable|string',
            'kontak_person' => 'required|string|max:255',
            'jabatan_kontak' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);
        
        $data = [
            'nama_perusahaan' => $request->nama_perusahaan,
            'alamat' => $request->alamat,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'bidang_usaha' => $request->bidang_usaha,
            'deskripsi' => $request->deskripsi,
            'kontak_person' => $request->kontak_person,
            'jabatan_kontak' => $request->jabatan_kontak,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ];
        
        // Upload logo baru
        if ($request->hasFile('logo')) {
            // Hapus logo lama
            if ($perusahaan->logo && Storage::disk('public')->exists($perusahaan->logo)) {
                Storage::disk('public')->delete($perusahaan->logo);
            }
            
            // Upload logo baru
            $file = $request->file('logo');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('perusahaan/logo', $filename, 'public');
            
            $data['logo'] = $path;
            
            // Update juga di tabel users jika ada
            if ($perusahaan->user) {
                $perusahaan->user->foto = $path;
                $perusahaan->user->save();
            }
        }
        
        $perusahaan->update($data);
        
        // Update user terkait
        if ($perusahaan->user) {
            $perusahaan->user->update([
                'name' => $request->nama_perusahaan,
                'email' => $request->email,
                'phone' => $request->telepon,
                'address' => $request->alamat,
                'foto' => $data['logo'] ?? $perusahaan->logo,
            ]);
        }
        
        return redirect()->route('admin.perusahaans.index')
            ->with('success', 'Data perusahaan berhasil diperbarui.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Perusahaan $perusahaan)
    {
        // Hapus logo jika ada
        if ($perusahaan->logo && Storage::disk('public')->exists($perusahaan->logo)) {
            Storage::disk('public')->delete($perusahaan->logo);
        }
        
        // Update foreign key di tabel kelompok_pkls (set perusahaan_id menjadi null)
        \DB::table('kelompok_pkls')->where('perusahaan_id', $perusahaan->id)->update(['perusahaan_id' => null]);
        
        // Update foreign key di tabel pendaftaran_magang (jika ada)
        \DB::table('pendaftaran_magang')->where('perusahaan_id', $perusahaan->id)->update(['perusahaan_id' => null]);
        
        // Nonaktifkan user terkait (jangan hapus karena bisa memiliki relasi lain)
        if ($perusahaan->user) {
            $perusahaan->user->update(['is_active' => false]);
        }
        
        // Hapus perusahaan
        $perusahaan->delete();
        
        return redirect()->route('admin.perusahaans.index')
            ->with('success', 'Data perusahaan berhasil dihapus.');
    }
    
    /**
     * Toggle status perusahaan.
     */
    public function toggleStatus(Perusahaan $perusahaan)
    {
        $perusahaan->update(['is_active' => !$perusahaan->is_active]);
        
        if ($perusahaan->user) {
            $perusahaan->user->update(['is_active' => $perusahaan->is_active]);
        }
        
        $status = $perusahaan->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Perusahaan berhasil {$status}.");
    }
}