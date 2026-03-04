@extends('layouts.app')

@section('title', 'Detail Laporan')
@section('page-title', 'Detail Laporan PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Laporan PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.laporan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    @if(in_array($laporan->status, ['draft', 'direvisi']))
                        <a href="{{ route('siswa.laporan.edit', $laporan->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endif
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
                        <th>Status</th>
                        <td>
                            @if($laporan->status == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($laporan->status == 'diajukan')
                                <span class="badge badge-warning">Diajukan</span>
                            @elseif($laporan->status == 'direview')
                                <span class="badge badge-info">Direview</span>
                            @elseif($laporan->status == 'direvisi')
                                <span class="badge badge-primary">Perlu Revisi</span>
                            @elseif($laporan->status == 'ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                            @else
                                <span class="badge badge-secondary">Draft</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Upload</th>
                        <td>{{ $laporan->created_at->format('d F Y H:i') }}</td>
                    </tr>
                    @if($laporan->reviewed_at)
                    <tr>
                        <th>Tanggal Review</th>
                        <td>{{ $laporan->reviewed_at->format('d F Y H:i') }}</td>
                    </tr>
                    @endif
                    @if($laporan->reviewer)
                    <tr>
                        <th>Reviewer</th>
                        <td>{{ $laporan->reviewer->name }}</td>
                    </tr>
                    @endif
                </table>
                
                @if($laporan->catatan_revisi)
                <div class="alert alert-info mt-3">
                    <h5><i class="fas fa-comment"></i> Catatan Revisi:</h5>
                    <p class="mb-0">{{ $laporan->catatan_revisi }}</p>
                </div>
                @endif
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-file-pdf"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">File Laporan</span>
                                <span class="info-box-number">
                                    <a href="{{ route('siswa.laporan.download', [$laporan->id, 'laporan']) }}" class="btn btn-primary btn-sm">
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
                                    <a href="{{ route('siswa.laporan.download', [$laporan->id, 'presentasi']) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                @if($laporan->status == 'draft' || $laporan->status == 'direvisi')
                <div class="row mt-3">
                    <div class="col-md-12">
                        <form action="{{ route('siswa.laporan.submit', $laporan->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Submit laporan untuk direview?')">
                                <i class="fas fa-paper-plane"></i> Submit Laporan untuk Direview
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection