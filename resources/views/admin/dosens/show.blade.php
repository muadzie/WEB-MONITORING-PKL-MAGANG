@extends('layouts.app')

@section('title', 'Detail Guru')
@section('page-title', 'Detail Data Guru')

@section('content')


<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                   <img class="profile-user-img img-fluid img-circle"
     src="{{ $dosen->foto ? asset('storage/'.$dosen->foto) : asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}"
     alt="Dosen profile picture"
     style="width: 120px; height: 120px; min-width: 120px; min-height: 120px; object-fit: cover; border-radius: 50%; display: block; margin: 0 auto;">
                </div>
                <h3 class="profile-username text-center">
                    {{ $dosen->gelar_depan ? $dosen->gelar_depan.' ' : '' }}
                    {{ $dosen->nama_dosen }}
                    {{ $dosen->gelar_belakang ? ', '.$dosen->gelar_belakang : '' }}
                </h3>
                <p class="text-muted text-center">{{ $dosen->nidn }}</p>
                <p class="text-center">
                    @if($dosen->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </p>
                <a href="{{ route('admin.dosens.edit', $dosen->id) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Edit Guru
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Detail</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.dosens.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">NIDN</th>
                        <td>{{ $dosen->nidn }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>
                            {{ $dosen->gelar_depan ? $dosen->gelar_depan.' ' : '' }}
                            {{ $dosen->nama_dosen }}
                            {{ $dosen->gelar_belakang ? ', '.$dosen->gelar_belakang : '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>{{ $dosen->jurusan }}</td>
                    </tr>
                    <tr>
                        <th>Fakultas</th>
                        <td>{{ $dosen->fakultas }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $dosen->email }}</td>
                    </tr>
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $dosen->telepon }}</td>
                    </tr>
                    <tr>
                        <th>Status Akun</th>
                        <td>
                            @if($dosen->user)
                                @if($dosen->user->is_active)
                                    <span class="badge badge-success">Akun Aktif</span>
                                @else
                                    <span class="badge badge-danger">Akun Nonaktif</span>
                                @endif
                            @else
                                <span class="badge badge-warning">Belum Punya Akun</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Data Dibuat</th>
                        <td>{{ $dosen->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td>{{ $dosen->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        @if($dosen->kelompokPkls->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Kelompok Bimbingan</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelompok</th>
                                <th>Perusahaan</th>
                                <th>Jumlah Anggota</th>
                                <th>Periode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dosen->kelompokPkls as $index => $kelompok)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kelompok->nama_kelompok }}</td>
                                <td>{{ $kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
                                <td class="text-center">{{ $kelompok->anggota->count() }} orang</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($kelompok->tanggal_mulai)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($kelompok->tanggal_selesai)->format('d/m/Y') }}
                                </td>
                                <td>
                                    @if($kelompok->status == 'aktif')
                                        <span class="badge badge-success">Aktif</span>
                                    @elseif($kelompok->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($kelompok->status == 'selesai')
                                        <span class="badge badge-info">Selesai</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($kelompok->status) }}</span>
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