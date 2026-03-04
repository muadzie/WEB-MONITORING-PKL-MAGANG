@extends('layouts.app')

@section('title', 'Detail Monitoring')
@section('page-title', 'Detail Monitoring Kelompok PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Kelompok PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('pt.monitoring.index') }}" class="btn btn-secondary btn-sm">
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
                        <td>{{ $kelompok->dosen->nama_dosen ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Periode PKL</th>
                        <td>{{ $kelompok->tanggal_mulai->format('d F Y') }} - {{ $kelompok->tanggal_selesai->format('d F Y') }}</td>
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
                            @endif
                        </td>
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Prodi</th>
                            <th>Status</th>
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
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Logbook Kegiatan</h3>
                <div class="card-tools">
                    <a href="{{ route('pt.logbook.index') }}?kelompok_id={{ $kelompok->id }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-book"></i> Lihat Semua Logbook
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kegiatan</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logbooks as $logbook)
                        <tr>
                            <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $logbook->kelompokSiswa->siswa->name }}</td>
                            <td>{{ Str::limit($logbook->kegiatan, 50) }}</td>
                            <td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
                            <td>
                                @if($logbook->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($logbook->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('pt.logbook.review', $logbook->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada logbook</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $logbooks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection