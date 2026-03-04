@extends('layouts.app')

@section('title', 'Rekap Tahunan PKL')
@section('page-title', 'Rekap Tahunan PKL')

@section('content')
<!-- Filter Tahun -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pilih Tahun</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.rekap.tahunan') }}" class="form-inline">
            <div class="form-group mr-2">
                <label for="tahun" class="mr-2">Tahun:</label>
                <select name="tahun" id="tahun" class="form-control">
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Tampilkan
            </button>
            <a href="{{ route('admin.rekap.export', 'tahunan') }}?tahun={{ $tahun }}" class="btn btn-success ml-2">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </form>
    </div>
</div>

<!-- Statistik Tahunan -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $statistik['total_siswa'] }}</h3>
                <p>Siswa Baru</p>
            </div>
            <div class="icon"><i class="fas fa-user-graduate"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $statistik['total_kelompok'] }}</h3>
                <p>Kelompok PKL</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $statistik['total_logbook'] }}</h3>
                <p>Logbook</p>
            </div>
            <div class="icon"><i class="fas fa-book"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $statistik['total_laporan'] }}</h3>
                <p>Laporan</p>
            </div>
            <div class="icon"><i class="fas fa-file-alt"></i></div>
        </div>
    </div>
</div>

<!-- Grafik Kelompok per Bulan -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kelompok PKL per Bulan ({{ $tahun }})</h3>
            </div>
            <div class="card-body">
                <canvas id="kelompokChart" style="min-height: 250px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Logbook per Bulan ({{ $tahun }})</h3>
            </div>
            <div class="card-body">
                <canvas id="logbookChart" style="min-height: 250px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Detail -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Kelompok PKL per Bulan</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah Kelompok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelompokPerBulan as $data)
                        <tr>
                            <td>{{ DateTime::createFromFormat('!m', $data->bulan)->format('F') }}</td>
                            <td>{{ $data->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Logbook per Bulan</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Jumlah Logbook</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logbookPerBulan as $data)
                        <tr>
                            <td>{{ DateTime::createFromFormat('!m', $data->bulan)->format('F') }}</td>
                            <td>{{ $data->total }}</td>
                        </tr>
                        @endforeach
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
    // Data untuk chart
    var bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    var dataKelompok = Array(12).fill(0);
    var dataLogbook = Array(12).fill(0);
    
    @foreach($kelompokPerBulan as $data)
        dataKelompok[{{ $data->bulan - 1 }}] = {{ $data->total }};
    @endforeach
    
    @foreach($logbookPerBulan as $data)
        dataLogbook[{{ $data->bulan - 1 }}] = {{ $data->total }};
    @endforeach
    
    // Chart Kelompok
    var kelompokChartCanvas = $('#kelompokChart').get(0).getContext('2d');
    new Chart(kelompokChartCanvas, {
        type: 'bar',
        data: {
            labels: bulan,
            datasets: [{
                label: 'Jumlah Kelompok',
                data: dataKelompok,
                backgroundColor: 'rgba(60, 141, 188, 0.8)',
                borderColor: 'rgba(60, 141, 188, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    // Chart Logbook
    var logbookChartCanvas = $('#logbookChart').get(0).getContext('2d');
    new Chart(logbookChartCanvas, {
        type: 'line',
        data: {
            labels: bulan,
            datasets: [{
                label: 'Jumlah Logbook',
                data: dataLogbook,
                backgroundColor: 'rgba(0, 166, 90, 0.2)',
                borderColor: 'rgba(0, 166, 90, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush