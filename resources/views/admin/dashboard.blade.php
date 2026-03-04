@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalSiswa ?? 0 }}</h3>
                <p>Total Siswa</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <a href="{{ route('admin.users.index') }}?role=siswa" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalDosen ?? 0 }}</h3>
                <p>Total Dosen</p>
            </div>
            <div class="icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <a href="{{ route('admin.dosens.index') }}" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalPT ?? 0 }}</h3>
                <p>Total PT</p>
            </div>
            <div class="icon">
                <i class="fas fa-building"></i>
            </div>
            <a href="{{ route('admin.perusahaans.index') }}" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $kelompokAktif ?? 0 }}</h3>
                <p>Kelompok Aktif</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.kelompok.index') }}?status=aktif" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Statistik Kelompok PKL</h3>
            </div>
            <div class="card-body">
                <canvas id="kelompokChart" style="min-height: 250px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Statistik Logbook</h3>
            </div>
            <div class="card-body">
                <canvas id="logbookChart" style="min-height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kelompok PKL Terbaru</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Nama Kelompok</th>
                            <th>Dosen</th>
                            <th>Perusahaan</th>
                            <th>Tanggal Mulai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelompokTerbaru ?? [] as $kelompok)
                        <tr>
                            <td>{{ $kelompok->nama_kelompok }}</td>
                            <td>{{ $kelompok->dosen->nama_dosen ?? '-' }}</td>
                            <td>{{ $kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
                            <td>{{ $kelompok->tanggal_mulai->format('d/m/Y') }}</td>
                            <td>
                                @if($kelompok->status == 'aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($kelompok->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($kelompok->status) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
    // Kelompok Chart
    var kelompokChartCanvas = $('#kelompokChart').get(0).getContext('2d');
    new Chart(kelompokChartCanvas, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Aktif', 'Selesai'],
            datasets: [{
                data: [{{ $kelompokPending ?? 0 }}, {{ $kelompokAktif ?? 0 }}, {{ $kelompokSelesai ?? 0 }}],
                backgroundColor: ['#f39c12', '#00a65a', '#3c8dbc']
            }]
        }
    });
    
    // Logbook Chart
    var logbookChartCanvas = $('#logbookChart').get(0).getContext('2d');
    new Chart(logbookChartCanvas, {
        type: 'bar',
        data: {
            labels: ['Pending', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [{{ $logbookPending ?? 0 }}, {{ $logbookDisetujui ?? 0 }}, {{ $logbookDitolak ?? 0 }}],
                backgroundColor: ['#f39c12', '#00a65a', '#dd4b39']
            }]
        }
    });
});
</script>
@endpush