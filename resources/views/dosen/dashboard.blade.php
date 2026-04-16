@extends('layouts.app')

@section('title', 'Dashboard Dosen')
@section('page-title', 'Dashboard Guru Pembimbing')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalKelompok }}</h3>
                <p>Total Kelompok Bimbingan</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('dosen.bimbingan.index') }}" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $kelompokAktif }}</h3>
                <p>Kelompok Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('dosen.bimbingan.index') }}?status=aktif" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $logbookPending }}</h3>
                <p>Logbook Perlu Review</p>
            </div>
            <div class="icon">
                <i class="fas fa-book"></i>
            </div>
            <a href="{{ route('dosen.logbook.pending') }}" class="small-box-footer">
                Review <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
    <div class="small-box bg-danger">
        <div class="inner">
            <h3>{{ $laporanPending }}</h3>
            <p>Laporan Perlu Review</p>
        </div>
        <div class="icon">
            <i class="fas fa-file-alt"></i>
        </div>
        <a href="{{ route('dosen.laporan.index', ['status' => 'diajukan']) }}" class="small-box-footer">
            Review <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kelompok Bimbingan Terbaru</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Kelompok</th>
                            <th>Perusahaan</th>
                            <th>Jumlah Anggota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelompokTerbaru as $kelompok)
                        <tr>
                            <td>{{ $kelompok->nama_kelompok }}</td>
                            <td>{{ $kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
                            <td>{{ $kelompok->anggota->count() }}</td>
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
                            <td>
                                <a href="{{ route('dosen.bimbingan.show', $kelompok->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada kelompok bimbingan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-primary btn-sm">
                    Lihat Semua
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Logbook Terbaru</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelompok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logbookTerbaru as $logbook)
                        <tr>
                            <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $logbook->kelompokSiswa->siswa->name }}</td>
                            <td>{{ $logbook->kelompokSiswa->kelompok->nama_kelompok }}</td>
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
                                <a href="{{ route('dosen.logbook.review', $logbook->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada logbook terbaru</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('dosen.logbook.pending') }}" class="btn btn-warning btn-sm">
                    Lihat Semua Pending
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Aktivitas Bimbingan -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grafik Aktivitas Bimbingan</h3>
            </div>
            <div class="card-body">
                <canvas id="bimbinganChart" style="min-height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
$(function() {
    var ctx = $('#bimbinganChart').get(0).getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Kelompok', 'Kelompok Aktif', 'Logbook Pending', 'Laporan Pending'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $totalKelompok }}, {{ $kelompokAktif }}, {{ $logbookPending }}, {{ $laporanPending }}],
                backgroundColor: [
                    'rgba(60, 141, 188, 0.8)',
                    'rgba(0, 166, 90, 0.8)',
                    'rgba(243, 156, 18, 0.8)',
                    'rgba(221, 75, 57, 0.8)'
                ],
                borderColor: [
                    'rgba(60, 141, 188, 1)',
                    'rgba(0, 166, 90, 1)',
                    'rgba(243, 156, 18, 1)',
                    'rgba(221, 75, 57, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush