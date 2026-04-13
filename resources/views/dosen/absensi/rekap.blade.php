@extends('layouts.app')

@section('title', 'Rekap Absensi PKL')
@section('page-title', 'Rekap Absensi PKL')

@section('content')
<!-- Statistik Cards -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $statistik['total_hadir'] ?? 0 }}</h3>
                <p>Total Hadir</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
            <div class="small-box-footer">
                <i class="fas fa-calendar-alt"></i> Hari ini
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $statistik['total_izin'] ?? 0 }}</h3>
                <p>Total Izin</p>
            </div>
            <div class="icon"><i class="fas fa-file-alt"></i></div>
            <div class="small-box-footer">
                <i class="fas fa-calendar-alt"></i> Hari ini
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $statistik['total_sakit'] ?? 0 }}</h3>
                <p>Total Sakit</p>
            </div>
            <div class="icon"><i class="fas fa-thermometer-half"></i></div>
            <div class="small-box-footer">
                <i class="fas fa-calendar-alt"></i> Hari ini
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $statistik['total_alpha'] ?? 0 }}</h3>
                <p>Total Alpha</p>
            </div>
            <div class="icon"><i class="fas fa-times-circle"></i></div>
            <div class="small-box-footer">
                <i class="fas fa-calendar-alt"></i> Hari ini
            </div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-filter"></i> Filter Data Absensi
        </h3>
        <div class="card-tools">
            <div class="btn-group">
                {{-- Tombol export akan mengikuti filter yang dipilih (termasuk kelompok) --}}
                <a href="{{ route('dosen.absensi.export-excel', request()->all()) }}" class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Export Detail
                </a>
                <a href="{{ route('dosen.absensi.export-rekap-siswa', request()->all()) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-chart-bar"></i> Export Rekap per Siswa
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('dosen.absensi.rekap') }}" id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Kelompok</label>
                        <select name="kelompok_id" class="form-control">
                            <option value="">Semua Kelompok</option>
                            @foreach($kelompoks ?? [] as $kelompok)
                                <option value="{{ $kelompok->id }}" {{ request('kelompok_id') == $kelompok->id ? 'selected' : '' }}>
                                    {{ $kelompok->nama_kelompok }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="d-flex">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="fas fa-search"></i> Tampilkan
                            </button>
                            <a href="{{ route('dosen.absensi.rekap') }}" class="btn btn-secondary">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Chart Section -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> Statistik Kehadiran
                </h3>
            </div>
            <div class="card-body">
                <canvas id="kehadiranChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i> Tren Kehadiran per Hari
                </h3>
            </div>
            <div class="card-body">
                <canvas id="trenChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Data Absensi -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-table"></i> Data Absensi Siswa
        </h3>
        <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 250px;">
                <input type="text" id="searchInput" class="form-control float-right" placeholder="Cari nama/NIM...">
                <div class="input-group-append">
                    <button class="btn btn-default" id="searchBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="absensiTable">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Nama Siswa</th>
                        <th width="10%">NIM</th>
                        <th width="15%">Kelompok</th>
                        <th width="10%">Jam Masuk</th>
                        <th width="10%">Jam Keluar</th>
                        <th width="10%">Status</th>
                        <th width="15%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensis ?? [] as $index => $absen)
                    <tr>
                        <td>{{ $absensis->firstItem() + $index }}</td>
                        <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $absen->siswa->name }}</td>
                        <td>{{ $absen->siswa->nomor_induk }}</td>
                        <td>{{ $absen->kelompokSiswa->kelompok->nama_kelompok }}</td>
                        <td>{{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i:s') : '-' }}</td>
                        <td>{{ $absen->jam_keluar ? \Carbon\Carbon::parse($absen->jam_keluar)->format('H:i:s') : '-' }}</td>
                        <td>
                            @if($absen->status == 'hadir')
                                <span class="badge badge-success"><i class="fas fa-check"></i> Hadir</span>
                            @elseif($absen->status == 'izin')
                                <span class="badge badge-info"><i class="fas fa-file-alt"></i> Izin</span>
                            @elseif($absen->status == 'sakit')
                                <span class="badge badge-warning"><i class="fas fa-thermometer-half"></i> Sakit</span>
                            @else
                                <span class="badge badge-danger"><i class="fas fa-times"></i> Alpha</span>
                            @endif
                        </td>
                        <td>{{ $absen->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle"></i> Belum ada data absensi
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <small class="text-muted">
                    <i class="fas fa-database"></i> Total Data: {{ $absensis->total() ?? 0 }}
                </small>
            </div>
            <div>
                {{ $absensis->withQueryString()->links() ?? '' }}
            </div>
        </div>
    </div>
</div>

<!-- Informasi Tambahan -->
<div class="row">
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Siswa</span>
                <span class="info-box-number">{{ $siswas->count() ?? 0 }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-calendar-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Periode PKL</span>
                <span class="info-box-number">{{ request('tanggal_mulai') ?: '-' }} s/d {{ request('tanggal_selesai') ?: '-' }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-chart-line"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Persentase Kehadiran</span>
                <span class="info-box-number">
                    @php
                        $total = ($statistik['total_hadir'] ?? 0) + ($statistik['total_izin'] ?? 0) + ($statistik['total_sakit'] ?? 0) + ($statistik['total_alpha'] ?? 0);
                        $hadir = $statistik['total_hadir'] ?? 0;
                        $persen = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;
                    @endphp
                    {{ $persen }}%
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/chart.js/Chart.min.css') }}">
<style>
    .table th {
        background-color: #f4f6f9;
        font-weight: 600;
    }
    .badge {
        font-size: 12px;
        padding: 5px 10px;
    }
    .info-box {
        margin-bottom: 0;
    }
    .small-box {
        transition: all 0.3s ease;
    }
    .small-box:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
$(document).ready(function() {
    // ==================== CHART KEHADIRAN ====================
    var ctx1 = document.getElementById('kehadiranChart').getContext('2d');
    new Chart(ctx1, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
            datasets: [{
                data: [
                    {{ $statistik['total_hadir'] ?? 0 }},
                    {{ $statistik['total_izin'] ?? 0 }},
                    {{ $statistik['total_sakit'] ?? 0 }},
                    {{ $statistik['total_alpha'] ?? 0 }}
                ],
                backgroundColor: ['#28a745', '#17a2b8', '#ffc107', '#dc3545'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            var value = context.raw || 0;
                            var total = context.dataset.data.reduce((a, b) => a + b, 0);
                            var percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // ==================== CHART TREN (contoh, bisa diganti dengan data real) ====================
    var trenLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    var trenData = [45, 52, 48, 55, 50, 30];
    
    var ctx2 = document.getElementById('trenChart').getContext('2d');
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: trenLabels,
            datasets: [{
                label: 'Jumlah Kehadiran',
                data: trenData,
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderColor: '#28a745',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#28a745',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Jumlah Siswa' } },
                x: { title: { display: true, text: 'Hari' } }
            }
        }
    });

    // ==================== FITUR PENCARIAN ====================
    $('#searchBtn, #searchInput').on('keyup click', function() {
        var searchText = $('#searchInput').val().toLowerCase();
        $('#absensiTable tbody tr').each(function() {
            var rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.indexOf(searchText) !== -1);
        });
    });
});
</script>
@endpush