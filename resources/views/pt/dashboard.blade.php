@extends('layouts.app')

@section('title', 'Dashboard PT')
@section('page-title', 'Dashboard Perusahaan/PT')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalKelompok }}</h3>
                <p>Total Kelompok PKL</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('pt.monitoring.index') }}" class="small-box-footer">
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
            <a href="{{ route('pt.monitoring.index') }}?status=aktif" class="small-box-footer">
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
            <a href="{{ route('pt.logbook.index') }}?status=pending" class="small-box-footer">
                Review <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $logbookDisetujui }}</h3>
                <p>Logbook Disetujui</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-double"></i>
            </div>
            <a href="{{ route('pt.logbook.index') }}?status=disetujui" class="small-box-footer">
                Lihat <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kelompok PKL Terbaru</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Kelompok</th>
                            <th>Dosen Pembimbing</th>
                            <th>Jumlah Anggota</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelompokTerbaru as $kelompok)
                        <tr>
                            <td>{{ $kelompok->nama_kelompok }}</td>
                            <td>{{ $kelompok->dosen->nama_dosen ?? '-' }}</td>
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
                                <a href="{{ route('pt.monitoring.show', $kelompok->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada kelompok PKL</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('pt.monitoring.index') }}" class="btn btn-primary btn-sm">
                    Lihat Semua Kelompok
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
                                <a href="{{ route('pt.logbook.review', $logbook->id) }}" class="btn btn-info btn-sm">
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
                <a href="{{ route('pt.logbook.index') }}" class="btn btn-primary btn-sm">
                    Lihat Semua Logbook
                </a>
                <a href="{{ route('pt.logbook.index') }}?status=pending" class="btn btn-warning btn-sm">
                    Lihat Pending
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Aktivitas -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Grafik Aktivitas PKL</h3>
            </div>
            <div class="card-body">
                <canvas id="aktivitasChart" style="min-height: 250px;"></canvas>
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
    var ctx = $('#aktivitasChart').get(0).getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Kelompok', 'Kelompok Aktif', 'Kelompok Selesai', 'Logbook Pending', 'Logbook Disetujui'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $totalKelompok }}, {{ $kelompokAktif }}, {{ $kelompokSelesai }}, {{ $logbookPending }}, {{ $logbookDisetujui }}],
                backgroundColor: [
                    'rgba(60, 141, 188, 0.8)',
                    'rgba(0, 166, 90, 0.8)',
                    'rgba(0, 166, 90, 0.8)',
                    'rgba(243, 156, 18, 0.8)',
                    'rgba(0, 166, 90, 0.8)'
                ],
                borderColor: [
                    'rgba(60, 141, 188, 1)',
                    'rgba(0, 166, 90, 1)',
                    'rgba(0, 166, 90, 1)',
                    'rgba(243, 156, 18, 1)',
                    'rgba(0, 166, 90, 1)'
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