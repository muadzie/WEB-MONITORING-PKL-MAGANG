@extends('layouts.app')

@section('title', 'Manajemen Users')
@section('page-title', 'Manajemen Users')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Users</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah User
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="role" class="form-control">
                                <option value="">Semua Role</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="dosen" {{ request('role') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                <option value="pt" {{ request('role') == 'pt' ? 'selected' : '' }}>PT</option>
                                <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Cari nama/email/nomor induk" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Foto</th>
                                <th>Nama</th>
                                <th>Nomor Induk</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                            <tr>
                                <td>{{ $users->firstItem() + $index }}</td>
                                <td>
                                    <img src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}" 
                                         class="img-circle img-size-32" alt="User Image">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->nomor_induk ?? '-' }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge badge-danger">Admin</span>
                                    @elseif($user->role == 'dosen')
                                        <span class="badge badge-success">Dosen</span>
                                    @elseif($user->role == 'pt')
                                        <span class="badge badge-warning">PT</span>
                                    @else
                                        <span class="badge badge-info">Siswa</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @if($user->is_active)
                                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Nonaktifkan user ini?')">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Aktifkan user ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection