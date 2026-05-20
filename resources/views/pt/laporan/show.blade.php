@extends('layouts.app')

@section('title', 'Detail Laporan')
@section('page-title', 'Detail Laporan PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Laporan</h3>
                <div class="card-tools">
                    <a href="{{ route('pt.laporan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('pt.laporan.download', $laporan->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-download"></i> Download
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
                        <th>Siswa</th>
                        <td>{{ $laporan->kelompokSiswa?->siswa?->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $laporan->kelompokSiswa?->nim ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kelompok</th>
                        <td>{{ $laporan->kelompokSiswa?->kelompok?->nama_kelompok ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($laporan->status == 'diajukan')
                                <span class="badge badge-warning">Diajukan</span>
                            @elseif($laporan->status == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($laporan->status == 'direvisi')
                                <span class="badge badge-info">Direvisi</span>
                            @elseif($laporan->status == 'ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($laporan->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Diajukan</th>
                        <td>{{ $laporan->created_at->format('d F Y H:i') }}</td>
                    </tr>
                </table>

                <div class="card card-outline card-info mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Abstrak</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $laporan->abstrak }}</p>
                    </div>
                </div>

                @if($laporan->catatan_revisi)
                <div class="card card-outline card-warning mt-3">
                    <div class="card-header">
                        <h5 class="card-title">Catatan Revisi</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $laporan->catatan_revisi }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
