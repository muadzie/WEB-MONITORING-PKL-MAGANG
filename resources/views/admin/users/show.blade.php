@extends('layouts.app')

@section('title', 'Detail User')
@section('page-title', 'Detail User')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ $user->foto ? asset('storage/'.$user->foto) : asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}"
                         alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                <p class="text-muted text-center">
                    @if($user->role == 'admin')
                        <span class="badge badge-danger">Admin</span>
                    @elseif($user->role == 'dosen')
                        <span class="badge badge-success">Dosen</span>
                    @elseif($user->role == 'pt')
                        <span class="badge badge-warning">PT</span>
                    @else
                        <span class="badge badge-info">Siswa</span>
                    @endif
                    
                    @if($user->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Detail</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nama Lengkap</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Nomor Induk</th>
                        <td>{{ $user->nomor_induk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $user->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $user->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ ucfirst($user->role) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($user->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Email Terverifikasi</th>
                        <td>
                            @if($user->email_verified_at)
                                {{ $user->email_verified_at->format('d/m/Y H:i') }}
                            @else
                                <span class="badge badge-warning">Belum Verifikasi</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Bergabung Sejak</th>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td>{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection