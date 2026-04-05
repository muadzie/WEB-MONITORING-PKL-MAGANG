<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        // Filter berdasarkan role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }
        
        // Pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_induk', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    public function create()
    {
        return view('admin.users.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
              'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed',
    'nomor_induk' => 'required|string|unique:users',
    'phone' => 'nullable|string|max:20',
    'address' => 'nullable|string',
    'role' => 'required|in:admin,dosen,pt,siswa',
    'foto' => 'nullable|image|max:2048',
    // Tambahkan ini untuk dosen
    'jurusan' => 'required_if:role,dosen|string|nullable',
    'fakultas' => 'required_if:role,dosen|string|nullable',
        ]);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nomor_induk' => $request->nomor_induk,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'is_active' => true,
        ];
        
        // Upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('users/foto', 'public');
        }
        
        $user = User::create($data);
        
        // Buat entri di tabel spesifik sesuai role
        if ($request->role === 'dosen') {
            Dosen::create([
                  'user_id' => $user->id,
        'nidn' => $request->nomor_induk,
        'nama_dosen' => $request->name,
        'jurusan' => $request->jurusan ?? 'Teknik Informatika', // Tambahkan ini
        'fakultas' => $request->fakultas ?? 'Ilmu Komputer',   // Tambahkan ini
        'email' => $request->email,
        'telepon' => $request->phone,
        'is_active' => true,
            ]);
        } elseif ($request->role === 'pt') {
            Perusahaan::create([
                'user_id' => $user->id,
                'nama_perusahaan' => $request->name,
                'email' => $request->email,
                'telepon' => $request->phone,
                'alamat' => $request->address,
                'is_active' => true,
            ]);
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }
    
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nomor_induk' => 'required|string|unique:users,nomor_induk,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nomor_induk' => $request->nomor_induk,
            'phone' => $request->phone,
            'address' => $request->address,
            'is_active' => $request->has('is_active'),
        ];
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $data['password'] = Hash::make($request->password);
        }
        
        // Upload foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $data['foto'] = $request->file('foto')->store('users/foto', 'public');
        }
        
        $user->update($data);
        
        // Update data di tabel spesifik
        if ($user->role === 'dosen' && $user->dosen) {
            $user->dosen->update([
                'nama_dosen' => $request->name,
                'email' => $request->email,
                'telepon' => $request->phone,
                'is_active' => $request->has('is_active'),
            ]);
        } elseif ($user->role === 'pt' && $user->perusahaan) {
            $user->perusahaan->update([
                'nama_perusahaan' => $request->name,
                'email' => $request->email,
                'telepon' => $request->phone,
                'alamat' => $request->address,
                'is_active' => $request->has('is_active'),
            ]);
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }
    
    public function destroy(User $user)
    {
        // Hapus foto jika ada
        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
        }
        
        // Hapus data terkait
        if ($user->dosen) {
            $user->dosen->delete();
        }
        if ($user->perusahaan) {
            $user->perusahaan->delete();
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
    
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()->with('success', "User berhasil {$status}.");
    }
}