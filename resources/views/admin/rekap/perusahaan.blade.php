@extends('layouts.app')

@section('title', 'Rekap Perusahaan')
@section('page-title', 'Rekap Data Perusahaan')

@section('content')
<!-- Statistik Cards -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $statistik['total'] }}</h3>
                <p>Total Perusahaan</p>
            </div>
            <div class="icon"><i class="fas fa-building"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $statistik['aktif'] }}</h3>
                <p>Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $statistik['nonaktif'] }}</h3>
                <p>Nonaktif</p>
            </div>
            <div class="icon"><i class="fas fa-ban"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $statistik['total_kelompok'] }}</h3>
                <p>Total Kelompok</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Perusahaan</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.rekap.perusahaan') }}" class="form-inline">
            <div class="form-group mr-2">
                <label for="bidang_usaha" class="mr-2">Bidang Usaha:</label>
                <input type="text" name="bidang_usaha" id="bidang_usaha" class="form-control" 
                       value="{{ request('bidang_usaha') }}" placeholder="Contoh: Teknologi">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.rekap.perusahaan') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-sync"></i> Reset
            </a>
            <a href="{{ route('admin.rekap.export', 'perusahaan') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success ml-2">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </form>
    </div>
</div>

<!-- Tabel Perusahaan -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Perusahaan</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Perusahaan</th>
                        <th>Bidang Usaha</th>
                        <th>Kontak Person</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th>Jumlah Kelompok</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perusahaans as $index => $perusahaan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $perusahaan->nama_perusahaan }}</td>
                        <td>{{ $perusahaan->bidang_usaha }}</td>
                        <td>{{ $perusahaan->kontak_person }}</td>
                        <td>{{ $perusahaan->telepon }}</td>
                        <td>{{ $perusahaan->email }}</td>
                        <td class="text-center">{{ $perusahaan->kelompok_pkls_count }}</td>
                        <td>
                            @if($perusahaan->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data perusahaan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection