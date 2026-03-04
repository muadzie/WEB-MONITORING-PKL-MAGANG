@extends('layouts.app')

@section('title', 'Detail Kelompok PKL')
@section('page-title', 'Detail Kelompok PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Kelompok</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.kelompok.edit', $kelompok->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.kelompok.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nama Kelompok</th>
                        <td>{{ $kelompok->nama_kelompok }}</td>
                    </tr>
                    <tr>
                        <th>Dosen Pembimbing</th>
                        <td>
                            {{ $kelompok->dosen->gelar_depan ? $kelompok->dosen->gelar_depan.' ' : '' }}
                            {{ $kelompok->dosen->nama_dosen ?? '-' }}
                            {{ $kelompok->dosen->gelar_belakang ? ', '.$kelompok->dosen->gelar_belakang : '' }}
                            <br>
                            <small>NIDN: {{ $kelompok->dosen->nidn ?? '-' }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Perusahaan/PT</th>
                        <td>
                            {{ $kelompok->perusahaan->nama_perusahaan ?? '-' }}
                            <br>
                            <small>{{ $kelompok->perusahaan->alamat ?? '-' }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Periode PKL</th>
                        <td>
                            {{ $kelompok->tanggal_mulai->format('d F Y') }} 
                            s/d 
                            {{ $kelompok->tanggal_selesai->format('d F Y') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($kelompok->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($kelompok->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($kelompok->status == 'selesai')
                                <span class="badge badge-info">Selesai</span>
                            @elseif($kelompok->status == 'dibatalkan')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                    @if($kelompok->catatan)
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $kelompok->catatan }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $kelompok->created_at->format('d F Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Update</th>
                        <td>{{ $kelompok->updated_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Anggota Kelompok</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Prodi</th>
                            <th>Status</th>
                            <th>Email</th>
                            <th>Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelompok->anggota as $index => $anggota)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $anggota->nim }}</td>
                            <td>{{ $anggota->siswa->name }}</td>
                            <td>{{ $anggota->kelas }}</td>
                            <td>{{ $anggota->prodi }}</td>
                            <td>
                                @if($anggota->status_anggota == 'ketua')
                                    <span class="badge badge-primary">Ketua</span>
                                @else
                                    <span class="badge badge-secondary">Anggota</span>
                                @endif
                            </td>
                            <td>{{ $anggota->siswa->email }}</td>
                            <td>{{ $anggota->siswa->phone ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if($kelompok->status == 'pending')
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Approval Kelompok</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.kelompok.approve', $kelompok->id) }}" method="POST" class="form-inline">
                    @csrf
                    <div class="form-group mr-2">
                        <select name="status" class="form-control" required>
                            <option value="aktif">Aktifkan Kelompok</option>
                            <option value="dibatalkan">Batalkan Kelompok</option>
                        </select>
                    </div>
                    <div class="form-group mr-2">
                        <input type="text" name="catatan" class="form-control" placeholder="Catatan (opsional)">
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check"></i> Proses Approval
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection