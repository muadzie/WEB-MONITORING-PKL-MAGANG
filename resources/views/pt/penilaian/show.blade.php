@extends('layouts.app')

@section('title', 'Detail Penilaian')
@section('page-title', 'Detail Penilaian PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Penilaian PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('pt.penilaian.edit', $penilaian->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('pt.penilaian.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Mahasiswa</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="150">Nama</th>
                                        <td>{{ $penilaian->kelompokSiswa->siswa->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>NIM</th>
                                        <td>{{ $penilaian->kelompokSiswa->nim }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kelas</th>
                                        <td>{{ $penilaian->kelompokSiswa->kelas }}</td>
                                    </tr>
                                    <tr>
                                        <th>Prodi</th>
                                        <td>{{ $penilaian->kelompokSiswa->prodi }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kelompok</th>
                                        <td>{{ $penilaian->kelompokSiswa->kelompok->nama_kelompok }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dosen Pembimbing</th>
                                        <td>{{ $penilaian->kelompokSiswa->kelompok->dosen->nama_dosen ?? '-' }}</td>
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
                                    <tr>
                                        <th width="150">Nilai Kinerja</th>
                                        <td>
                                            <h3>{{ $penilaian->nilai_kinerja ?? '-' }} / 100</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Kedisiplinan</th>
                                        <td>
                                            <h3>{{ $penilaian->nilai_kedisiplinan ?? '-' }} / 100</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Kerjasama</th>
                                        <td>
                                            <h3>{{ $penilaian->nilai_kerjasama ?? '-' }} / 100</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Inisiatif</th>
                                        <td>
                                            <h3>{{ $penilaian->nilai_inisiatif ?? '-' }} / 100</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Akhir</th>
                                        <td>
                                            <h2 class="text-primary">{{ $penilaian->nilai_akhir ?? '-' }}</h2>
                                        </td>
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
                
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informasi Sistem</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="200">Tanggal Penilaian</th>
                                        <td>{{ $penilaian->created_at->format('d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Terakhir Update</th>
                                        <td>{{ $penilaian->updated_at->format('d F Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Penilai</th>
                                        <td>{{ $penilaian->penilaiUser->name ?? 'PT' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection