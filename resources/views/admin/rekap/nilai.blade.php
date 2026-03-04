@extends('layouts.app')

@section('title', 'Rekap Nilai PKL')
@section('page-title', 'Rekap Nilai PKL')

@section('content')
<!-- Statistik Cards -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $statistik['total_penilaian'] }}</h3>
                <p>Total Penilaian</p>
            </div>
            <div class="icon"><i class="fas fa-star"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $statistik['total_dosen'] }}</h3>
                <p>Penilaian Dosen</p>
            </div>
            <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $statistik['total_pt'] }}</h3>
                <p>Penilaian PT</p>
            </div>
            <div class="icon"><i class="fas fa-building"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($statistik['rata_dosen'], 2) }}</h3>
                <p>Rata-rata Dosen</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Nilai</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.rekap.nilai') }}" class="form-inline">
            <div class="form-group mr-2">
                <label for="kelompok_id" class="mr-2">Kelompok:</label>
                <select name="kelompok_id" id="kelompok_id" class="form-control">
                    <option value="">Semua Kelompok</option>
                    @foreach($kelompoks ?? [] as $kelompok)
                        <option value="{{ $kelompok->id }}" {{ request('kelompok_id') == $kelompok->id ? 'selected' : '' }}>
                            {{ $kelompok->nama_kelompok }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mr-2">
                <label for="penilai" class="mr-2">Penilai:</label>
                <select name="penilai" id="penilai" class="form-control">
                    <option value="">Semua Penilai</option>
                    <option value="dosen" {{ request('penilai') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                    <option value="pt" {{ request('penilai') == 'pt' ? 'selected' : '' }}>PT</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.rekap.nilai') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-sync"></i> Reset
            </a>
            <a href="{{ route('admin.rekap.export', 'nilai') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success ml-2">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </form>
    </div>
</div>

<!-- Tabel Nilai -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Nilai PKL</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Kelompok</th>
                        <th>Penilai</th>
                        <th>Nilai Laporan</th>
                        <th>Nilai Presentasi</th>
                        <th>Nilai Sikap</th>
                        <th>Nilai Kinerja</th>
                        <th>Nilai Disiplin</th>
                        <th>Nilai Kerjasama</th>
                        <th>Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penilaians as $index => $nilai)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $nilai->kelompokSiswa->siswa->name }}</td>
                        <td>{{ $nilai->kelompokSiswa->kelompok->nama_kelompok }}</td>
                        <td>
                            <span class="badge badge-{{ $nilai->penilai == 'dosen' ? 'primary' : 'success' }}">
                                {{ ucfirst($nilai->penilai) }}
                            </span>
                        </td>
                        <td>{{ $nilai->nilai_laporan ?? '-' }}</td>
                        <td>{{ $nilai->nilai_presentasi ?? '-' }}</td>
                        <td>{{ $nilai->nilai_sikap ?? '-' }}</td>
                        <td>{{ $nilai->nilai_kinerja ?? '-' }}</td>
                        <td>{{ $nilai->nilai_kedisiplinan ?? '-' }}</td>
                        <td>{{ $nilai->nilai_kerjasama ?? '-' }}</td>
                        <td><strong>{{ $nilai->nilai_akhir ?? '-' }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data penilaian</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection