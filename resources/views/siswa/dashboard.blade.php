@extends('layouts.app')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalLogbook }}</h3>
                <p>Total Logbook</p>
            </div>
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <a href="{{ route('siswa.logbook.index') }}" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $logbookDisetujui }}</h3>
                <p>Logbook Disetujui</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('siswa.logbook.index') }}?status=disetujui" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $logbookPending }}</h3>
                <p>Logbook Pending</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('siswa.logbook.index') }}?status=pending" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $logbookDitolak }}</h3>
                <p>Logbook Ditolak</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <a href="{{ route('siswa.logbook.index') }}?status=ditolak" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

@if($kelompok)
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Kelompok PKL</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nama Kelompok</th>
                        <td>{{ $kelompok->nama_kelompok }}</td>
                    </tr>
                    <tr>
                        <th>Perusahaan</th>
                        <td>{{ $kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dosen Pembimbing</th>
                        <td>{{ $kelompok->dosen->nama_dosen ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Periode PKL</th>
                        <td>{{ $kelompok->tanggal_mulai->format('d/m/Y') }} - {{ $kelompok->tanggal_selesai->format('d/m/Y') }}</td>
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
                            @else
                                <span class="badge badge-secondary">{{ ucfirst($kelompok->status) }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Progress Logbook</h3>
            </div>
            <div class="card-body">
                <canvas id="logbookChart" style="min-height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Status Laporan PKL</h3>
            </div>
            <div class="card-body">
                @if($laporan)
                    <div class="info-box">
                        <span class="info-box-icon bg-{{ $laporan->status == 'disetujui' ? 'success' : ($laporan->status == 'ditolak' ? 'danger' : 'warning') }}">
                            <i class="fas fa-file-alt"></i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">Laporan: {{ $laporan->judul_laporan }}</span>
                            <span class="info-box-number">
                                @if($laporan->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($laporan->status == 'diajukan')
                                    <span class="badge badge-warning">Diajukan</span>
                                @elseif($laporan->status == 'direvisi')
                                    <span class="badge badge-info">Perlu Revisi</span>
                                @elseif($laporan->status == 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('siswa.laporan.index') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-file-alt"></i> Kelola Laporan
                    </a>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Anda belum mengupload laporan PKL.
                    </div>
                    <a href="{{ route('siswa.laporan.create') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-upload"></i> Upload Laporan
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Nilai PKL</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-chalkboard-teacher"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Nilai Dosen</span>
                                <span class="info-box-number">{{ $penilaianDosen->nilai_akhir ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-building"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Nilai PT</span>
                                <span class="info-box-number">{{ $penilaianPt->nilai_akhir ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($penilaianDosen && $penilaianPt)
                    @php
                        $nilaiAkhir = ($penilaianDosen->nilai_akhir + $penilaianPt->nilai_akhir) / 2;
                    @endphp
                    <div class="alert alert-success text-center">
                        <strong>Nilai Akhir: {{ number_format($nilaiAkhir, 2) }}</strong>
                    </div>
                @endif
                
                <a href="{{ route('siswa.penilaian.index') }}" class="btn btn-info btn-block">
                    <i class="fas fa-star"></i> Lihat Detail Nilai
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Logbook Terbaru</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.logbook.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Logbook
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Kegiatan</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logbooksTerbaru as $logbook)
                        <tr>
                            <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
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
                                <a href="{{ route('siswa.logbook.show', $logbook->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada logbook</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('siswa.logbook.index') }}" class="btn btn-primary btn-sm">
                    Lihat Semua Logbook
                </a>
            </div>
        </div>
    </div>
</div>
@else
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> Anda belum terdaftar dalam kelompok PKL. Silakan hubungi admin atau dosen pembimbing.
</div>
@endif
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
$(function() {
    @if($kelompok)
    var ctx = $('#logbookChart').get(0).getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Disetujui', 'Pending', 'Ditolak'],
            datasets: [{
                data: [{{ $logbookDisetujui }}, {{ $logbookPending }}, {{ $logbookDitolak }}],
                backgroundColor: ['#00a65a', '#f39c12', '#dd4b39']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                position: 'bottom'
            }
        }
    });
    @endif
});
</script>
@endpush