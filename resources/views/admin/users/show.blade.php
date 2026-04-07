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
                         alt="User profile picture"
                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; display: block; margin: 0 auto;">
                </div>
                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                <p class="text-muted text-center">
                    @if($user->role == 'admin')
                        <span class="badge badge-danger">Administrator</span>
                    @elseif($user->role == 'dosen')
                        <span class="badge badge-success">Guru</span>
                    @elseif($user->role == 'pt')
                        <span class="badge badge-warning">Perusahaan</span>
                    @else
                        <span class="badge badge-info">Siswa</span>
                    @endif
                </p>
                <p class="text-center">
                    @if($user->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </p>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Edit User
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Detail</h3>
                <div class="card-tools">
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
                    @if($user->nomor_induk)
                    <tr>
                        <th>Nomor Induk</th>
                        <td>{{ $user->nomor_induk }}</td>
                    </tr>
                    @endif
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
        
        @if($user->dosen)
        <div class="card mt-3">
            <div class="card-header bg-success">
                <h3 class="card-title">Informasi Guru</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">NIDN</th>
                        <td>{{ $user->dosen->nidn }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $user->dosen->nama_dosen }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>{{ $user->dosen->jurusan }}</td>
                    </tr>
                    <tr>
                        <th>Fakultas</th>
                        <td>{{ $user->dosen->fakultas }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $user->dosen->telepon }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif
        
        @if($user->perusahaan)
        <div class="card mt-3">
            <div class="card-header bg-warning">
                <h3 class="card-title">Informasi Perusahaan</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nama Perusahaan</th>
                        <td>{{ $user->perusahaan->nama_perusahaan }}</td>
                    </tr>
                    <tr>
                        <th>Bidang Usaha</th>
                        <td>{{ $user->perusahaan->bidang_usaha }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $user->perusahaan->alamat }}</td>
                    </tr>
                    <tr>
                        <th>Kontak Person</th>
                        <td>{{ $user->perusahaan->kontak_person }} ({{
 $user->perusahaan->jabatan_kontak }})</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $user->perusahaan->telepon }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endif
        
        @if($user->kelompokSiswa->count() > 0)
        <div class="card mt-3">
            <div class="card-header bg-info">
                <h3 class="card-title">Informasi Kelompok PKL</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelompok</th>
                                <th>NIM</th>
                                <th>Kelas</th>
                                <th>Prodi</th>
                                <th>Status Anggota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->kelompokSiswa as $index => $anggota)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $anggota->kelompok->nama_kelompok }}</td>
                                <td>{{ $anggota->nim }}</td>
                                <td>{{ $anggota->kelas }}</td>
                                <td>{{ $anggota->prodi }}</td>
                                <td>
                                    @if($anggota->status_anggota == 'ketua')
                                        <span class="badge badge-primary">Ketua</span>
                                    @else
                                        <span class="badge badge-secondary">Anggota</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection