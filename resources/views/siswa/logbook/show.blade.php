@extends('layouts.app')

@section('title', 'Detail Logbook')
@section('page-title', 'Detail Logbook Kegiatan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Logbook</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.logbook.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    @if($logbook->status == 'pending')
                        <a href="{{ route('siswa.logbook.edit', $logbook->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Tanggal</th>
                        <td>{{ $logbook->tanggal->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Kegiatan</th>
                        <td>{{ $logbook->kegiatan }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $logbook->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th>Jam</th>
                        <td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($logbook->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($logbook->status == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                </table>
                
                @if($logbook->dokumentasi)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Dokumentasi</h3>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/'.$logbook->dokumentasi) }}" class="img-fluid" style="max-height: 400px;">
                                <br>
                                <a href="{{ asset('storage/'.$logbook->dokumentasi) }}" download class="btn btn-primary mt-3">
                                    <i class="fas fa-download"></i> Download Gambar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($logbook->catatan_dosen || $logbook->catatan_pt)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title">Catatan Review</h3>
                            </div>
                            <div class="card-body">
                                @if($logbook->catatan_dosen)
                                <div class="alert alert-info">
                                    <strong>Catatan Dosen:</strong>
                                    <p class="mb-0">{{ $logbook->catatan_dosen }}</p>
                                </div>
                                @endif
                                
                                @if($logbook->catatan_pt)
                                <div class="alert alert-success">
                                    <strong>Catatan PT:</strong>
                                    <p class="mb-0">{{ $logbook->catatan_pt }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Approval</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-{{ $logbook->approved_by_dosen ? 'success' : 'secondary' }}">
                                                <i class="fas fa-chalkboard-teacher"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Dosen Pembimbing</span>
                                                <span class="info-box-number">
                                                    @if($logbook->approved_by_dosen)
                                                        Disetujui pada {{ $logbook->approved_at_dosen->format('d/m/Y H:i') }}
                                                    @else
                                                        Menunggu Review
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-{{ $logbook->approved_by_pt ? 'success' : 'secondary' }}">
                                                <i class="fas fa-building"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Pembimbing PT</span>
                                                <span class="info-box-number">
                                                    @if($logbook->approved_by_pt)
                                                        Disetujui pada {{ $logbook->approved_at_pt->format('d/m/Y H:i') }}
                                                    @else
                                                        Menunggu Review
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection