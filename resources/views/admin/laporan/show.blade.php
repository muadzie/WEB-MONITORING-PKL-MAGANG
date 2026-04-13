@extends('layouts.app')

@section('title', 'Detail Laporan')
@section('page-title', 'Detail Laporan PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Laporan</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Judul Laporan</th>
                        <td>{{ $laporan->judul_laporan }}</td>
                    </tr>
                    <tr>
                        <th>Abstrak</th>
                        <td>{{ $laporan->abstrak }}</td>
                    </tr>
                    <tr>
                        <th>Siswa</th>
                        <td>{{ $laporan->kelompokSiswa->siswa->name }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $laporan->kelompokSiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td>{{ $laporan->kelompokSiswa->kelas }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>{{ $laporan->kelompokSiswa->prodi }}</td>
                    </tr>
                    <tr>
                        <th>Kelompok</th>
                        <td>{{ $laporan->kelompokSiswa->kelompok->nama_kelompok }}</td>
                    </tr>
                    <tr>
                        <th>Guru Pembimbing</th>
                        <td>{{ $laporan->kelompokSiswa->kelompok->dosen->nama_dosen ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Perusahaan</th>
                        <td>{{ $laporan->kelompokSiswa->kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($laporan->status == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($laporan->status == 'diajukan')
                                <span class="badge badge-warning">Diajukan</span>
                            @elseif($laporan->status == 'direview')
                                <span class="badge badge-info">Direview</span>
                            @elseif($laporan->status == 'direvisi')
                                <span class="badge badge-primary">Direvisi</span>
                            @elseif($laporan->status == 'ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                            @else
                                <span class="badge badge-secondary">Draft</span>
                            @endif
                        </td>
                    </tr>
                    @if($laporan->catatan_revisi)
                    <tr>
                        <th>Catatan Revisi</th>
                        <td class="text-danger">{{ $laporan->catatan_revisi }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Tanggal Upload</th>
                        <td>{{ $laporan->created_at->format('d F Y H:i') }}</td>
                    </tr>
                    @if($laporan->reviewed_at)
                    <tr>
                        <th>Tanggal Review</th>
                        <td>{{ $laporan->reviewed_at->format('d F Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Reviewer</th>
                        <td>{{ $laporan->reviewer->name ?? '-' }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">File Laporan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-file-pdf"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">File Laporan</span>
                                <span class="info-box-number">
                                    <a href="{{ route('admin.laporan.download', [$laporan->id, 'laporan']) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @if($laporan->file_presentasi)
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-file-powerpoint"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">File Presentasi</span>
                                <span class="info-box-number">
                                    <a href="{{ route('admin.laporan.download', [$laporan->id, 'presentasi']) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection