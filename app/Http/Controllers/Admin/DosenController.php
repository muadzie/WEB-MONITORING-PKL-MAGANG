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
    
    public function create()
    {
        return view('admin.dosens.create');
    }
    
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
            'foto' => 'nullable|image|max:2048',
            'create_user' => 'boolean',
            'password' => 'required_if:create_user,true|nullable|min:8|confirmed',
        ]);
        
        // Upload foto
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('dosens/foto', 'public');
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
            ->with('success', 'Data dosen berhasil ditambahkan.');
    }
    
    public function edit(Dosen $dosen)
    {
        return view('admin.dosens.edit', compact('dosen'));
    }
    
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
            'foto' => 'nullable|image|max:2048',
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
            if ($dosen->foto) {
                Storage::disk('public')->delete($dosen->foto);
            }
            $data['foto'] = $request->file('foto')->store('dosens/foto', 'public');
        }
        
        $dosen->update($data);
        
        // Update user jika ada
        if ($dosen->user) {
            $dosen->user->update([
                'name' => $request->nama_dosen,
                'email' => $request->email,
                'nomor_induk' => $request->nidn,
                'phone' => $request->telepon,
            ]);
        }
        
        return redirect()->route('admin.dosens.index')
            ->with('success', 'Data dosen berhasil diperbarui.');
    }
    
    public function destroy(Dosen $dosen)
    {
        // Hapus foto
        if ($dosen->foto) {
            Storage::disk('public')->delete($dosen->foto);
        }
        
        // Hapus user terkait jika ada
        if ($dosen->user) {
            $dosen->user->delete();
        }
        
        $dosen->delete();
        
        return redirect()->route('admin.dosens.index')
            ->with('success', 'Data dosen berhasil dihapus.');
    }
}