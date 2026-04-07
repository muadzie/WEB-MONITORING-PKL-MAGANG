<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dosen::with('user');
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_dosen', 'like', '%' . $request->search . '%')
                  ->orWhere('nidn', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }
        
        $dosens = $query->orderBy('nama_dosen')->paginate(15);
        $jurusanList = Dosen::distinct('jurusan')->pluck('jurusan');
        
        return view('admin.dosens.index', compact('dosens', 'jurusanList'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.dosens.create');
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nidn' => 'required|string|unique:dosens',
            'nama_dosen' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jurusan' => 'required|string',
            'fakultas' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:dosens|unique:users,email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'create_user' => 'boolean',
            'password' => 'required_if:create_user,true|nullable|min:8|confirmed',
        ]);
        
        // Upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $fotoPath = $file->storeAs('users/foto', $filename, 'public');
        }
        
        // Buat user account jika diperlukan
        $userId = null;
        if ($request->create_user) {
            $user = User::create([
                'name' => $request->nama_dosen,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nomor_induk' => $request->nidn,
                'phone' => $request->telepon,
                'role' => 'dosen',
                'foto' => $fotoPath,
                'is_active' => true,
            ]);
            $userId = $user->id;
        }
        
        // Buat data dosen
        $dosen = Dosen::create([
            'nidn' => $request->nidn,
            'nama_dosen' => $request->nama_dosen,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_belakang,
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'foto' => $fotoPath,
            'user_id' => $userId,
            'is_active' => true,
        ]);
        
        return redirect()->route('admin.dosens.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        $dosen->load(['user', 'kelompokPkls.perusahaan', 'kelompokPkls.anggota.siswa']);
        
        return view('admin.dosens.show', compact('dosen'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dosen $dosen)
    {
        return view('admin.dosens.edit', compact('dosen'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $request->validate([
            'nidn' => 'required|string|unique:dosens,nidn,' . $dosen->id,
            'nama_dosen' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jurusan' => 'required|string',
            'fakultas' => 'required|string',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:dosens,email,' . $dosen->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'nidn' => $request->nidn,
            'nama_dosen' => $request->nama_dosen,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_belakang,
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'telepon' => $request->telepon,
            'email' => $request->email,
        ];
        
        // Upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama dari storage
            if ($dosen->foto && Storage::disk('public')->exists($dosen->foto)) {
                Storage::disk('public')->delete($dosen->foto);
            }
            
            // Upload foto baru
            $file = $request->file('foto');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $path = $file->storeAs('users/foto', $filename, 'public');
            
            $data['foto'] = $path;
            
            // Update juga di tabel users jika ada
            if ($dosen->user) {
                $dosen->user->foto = $path;
                $dosen->user->save();
            }
        }
        
        // Update data dosen
        $dosen->update($data);
        
        // Update user terkait
        if ($dosen->user) {
            $dosen->user->update([
                'name' => $request->nama_dosen,
                'email' => $request->email,
                'phone' => $request->telepon,
                'foto' => $data['foto'] ?? $dosen->foto,
            ]);
        }
        
        return redirect()->route('admin.dosens.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dosen $dosen)
    {
        // Hapus foto jika ada
        if ($dosen->foto && Storage::disk('public')->exists($dosen->foto)) {
            Storage::disk('public')->delete($dosen->foto);
        }
        
        // Update foreign key di tabel kelompok_pkls
        \DB::table('kelompok_pkls')->where('dosen_id', $dosen->id)->update(['dosen_id' => null]);
        
        // Update foreign key di tabel absensis
        \DB::table('absensis')->where('dosen_id', $dosen->id)->update(['dosen_id' => null]);
        
        // Update foreign key di tabel penilaians
        \DB::table('penilaians')->where('penilai_id', $dosen->user_id)->update(['penilai_id' => null]);
        
        // Hapus user terkait jika ada
        if ($dosen->user) {
            $dosen->user->delete();
        }
        
        $dosen->delete();
        
        return redirect()->route('admin.dosens.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
    
    /**
     * Toggle status dosen.
     */
    public function toggleStatus(Dosen $dosen)
    {
        $dosen->update(['is_active' => !$dosen->is_active]);
        
        if ($dosen->user) {
            $dosen->user->update(['is_active' => $dosen->is_active]);
        }
        
        $status = $dosen->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "Status guru berhasil {$status}.");
    }
}