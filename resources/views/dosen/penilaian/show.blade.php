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
                    <a href="{{ route('dosen.penilaian.edit', $penilaian->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('dosen.penilaian.index') }}" class="btn btn-secondary btn-sm">
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
                                        <th>NISN</th>
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
                                        <th>Perusahaan</th>
                                        <td>{{ $penilaian->kelompokSiswa->kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
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
                                        <th width="150">Nilai Laporan</th>
                                        <td>
                                            <h3>{{ $penilaian->nilai_laporan ?? '-' }} / 100</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Presentasi</th>
                                        <td>
                                            <h3>{{ $penilaian->nilai_presentasi ?? '-' }} / 100</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nilai Sikap</th>
                                        <td>
                                            <h3>{{ $penilaian->nilai_sikap ?? '-' }} / 100</h3>
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
                                        <td>{{ $penilaian->penilaiUser->name ?? 'Dosen' }}</td>
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