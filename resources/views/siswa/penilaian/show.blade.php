@extends('layouts.app')

@section('title', 'Detail Penilaian')
@section('page-title', 'Detail Penilaian PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Penilaian oleh {{ ucfirst($penilaian->penilai) }}</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.penilaian.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Penilaian</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">Penilai</th>
                                        <td>
                                            @if($penilaian->penilai == 'dosen')
                                                <span class="badge badge-primary">Guru Pembimbing</span>
                                            @else
                                                <span class="badge badge-success">Pembimbing PT</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama Penilai</th>
                                        <td>{{ $penilaian->penilaiUser->name ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Penilaian</th>
                                        <td>{{ $penilaian->created_at->format('d F Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Detail Nilai</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    @if($penilaian->penilai == 'dosen')
                                        <tr>
                                            <th>Nilai Laporan</th>
                                            <td><h4>{{ $penilaian->nilai_laporan }} / 100</h4></td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Presentasi</th>
                                            <td><h4>{{ $penilaian->nilai_presentasi }} / 100</h4></td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Sikap</th>
                                            <td><h4>{{ $penilaian->nilai_sikap }} / 100</h4></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <th>Nilai Kinerja</th>
                                            <td><h4>{{ $penilaian->nilai_kinerja }} / 100</h4></td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Kedisiplinan</th>
                                            <td><h4>{{ $penilaian->nilai_kedisiplinan }} / 100</h4></td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Kerjasama</th>
                                            <td><h4>{{ $penilaian->nilai_kerjasama }} / 100</h4></td>
                                        </tr>
                                        <tr>
                                            <th>Nilai Inisiatif</th>
                                            <td><h4>{{ $penilaian->nilai_inisiatif }} / 100</h4></td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Nilai Akhir</th>
                                        <td><h2 class="text-primary">{{ $penilaian->nilai_akhir }}</h2></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($penilaian->catatan)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Catatan</h3>
                            </div>
                            <div class="card-body">
                                <p class="lead">{{ $penilaian->catatan }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection