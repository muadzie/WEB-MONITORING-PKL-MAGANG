@extends('layouts.app')

@section('title', 'Detail Perusahaan')
@section('page-title', 'Detail Data Perusahaan')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    @php
                        $fotoPerusahaan = $perusahaan->logo ?? $perusahaan->user->foto ?? null;
                    @endphp
                    <img class="profile-user-img img-fluid"
                         src="{{ $fotoPerusahaan ? asset('storage/'.$fotoPerusahaan) : asset('vendor/adminlte/dist/img/avatar.png') }}"
                         alt="Logo Perusahaan"
                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; display: block; margin: 0 auto; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                </div>
                <h3 class="profile-username text-center">{{ $perusahaan->nama_perusahaan }}</h3>
                <p class="text-muted text-center">{{ $perusahaan->bidang_usaha }}</p>
                <p class="text-center">
                    @if($perusahaan->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-danger">Nonaktif</span>
                    @endif
                </p>
                <a href="{{ route('admin.perusahaans.edit', $perusahaan->id) }}" class="btn btn-primary btn-block">
                    <i class="fas fa-edit"></i> Edit Perusahaan
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Detail</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.perusahaans.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nama Perusahaan</th>
                        <td>{{ $perusahaan->nama_perusahaan }}</td>
                    </tr>
                    <tr>
                        <th>Bidang Usaha</th>
                        <td>{{ $perusahaan->bidang_usaha }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $perusahaan->alamat }}</td>
                    </tr>
                    @if($perusahaan->latitude && $perusahaan->longitude)
                    <tr>
                        <th>Koordinat</th>
                        <td>Lat: {{ $perusahaan->latitude }}, Lng: {{ $perusahaan->longitude }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Telepon</th>
                        <td>{{ $perusahaan->telepon }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $perusahaan->email }}</td>
                    </tr>
                    <tr>
                        <th>Kontak Person</th>
                        <td>{{ $perusahaan->kontak_person }} ({{ $perusahaan->jabatan_kontak }})</td>
                    </tr>
                    @if($perusahaan->deskripsi)
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $perusahaan->deskripsi }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Status Akun</th>
                        <td>
                            @if($perusahaan->user)
                                @if($perusahaan->user->is_active)
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
                        <td>{{ $perusahaan->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td>{{ $perusahaan->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        @if($perusahaan->kelompokPkls->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Kelompok PKL di Perusahaan Ini</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelompok</th>
                                <th>Dosen Pembimbing</th>
                                <th>Jumlah Anggota</th>
                                <th>Periode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perusahaan->kelompokPkls as $index => $kelompok)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $kelompok->nama_kelompok }}</td>
                                <td>{{ $kelompok->dosen->nama_dosen ?? '-' }}</td>
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