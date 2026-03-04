@extends('layouts.app')

@section('title', 'Rekap Kelompok PKL')
@section('page-title', 'Rekap Kelompok PKL')

@section('content')
<!-- Statistik Cards -->
<div class="row">
    <div class="col-lg-2 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $statistik['total'] }}</h3>
                <p>Total Kelompok</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $statistik['aktif'] }}</h3>
                <p>Aktif</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $statistik['pending'] }}</h3>
                <p>Pending</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $statistik['selesai'] }}</h3>
                <p>Selesai</p>
            </div>
            <div class="icon"><i class="fas fa-flag-checkered"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $statistik['dibatalkan'] }}</h3>
                <p>Dibatalkan</p>
            </div>
            <div class="icon"><i class="fas fa-ban"></i></div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Data Kelompok</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.rekap.kelompok') }}" class="form-inline">
            <div class="form-group mr-2">
                <label for="tahun" class="mr-2">Tahun:</label>
                <select name="tahun" id="tahun" class="form-control">
                    <option value="">Semua Tahun</option>
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group mr-2">
                <label for="status" class="mr-2">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.rekap.kelompok') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-sync"></i> Reset
            </a>
            <a href="{{ route('admin.rekap.export', 'kelompok') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success ml-2">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </form>
    </div>
</div>

<!-- Tabel Data Kelompok -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Kelompok PKL</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelompok</th>
                        <th>Dosen Pembimbing</th>
                        <th>Perusahaan</th>
                        <th>Jumlah Anggota</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelompoks as $index => $kelompok)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kelompok->nama_kelompok }}</td>
                        <td>
                            {{ $kelompok->dosen->gelar_depan ? $kelompok->dosen->gelar_depan.' ' : '' }}
                            {{ $kelompok->dosen->nama_dosen ?? '-' }}
                            {{ $kelompok->dosen->gelar_belakang ? ', '.$kelompok->dosen->gelar_belakang : '' }}
                        </td>
                        <td>{{ $kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
                        <td class="text-center">{{ $kelompok->anggota_count }}</td>
                        <td>
                            {{ $kelompok->tanggal_mulai->format('d/m/Y') }} <br>
                            <small>s/d</small> <br>
                            {{ $kelompok->tanggal_selesai->format('d/m/Y') }}
                        </td>
                        <td>
                            @if($kelompok->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($kelompok->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($kelompok->status == 'selesai')
                                <span class="badge badge-info">Selesai</span>
                            @elseif($kelompok->status == 'dibatalkan')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.kelompok.show', $kelompok->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data kelompok</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if(method_exists($kelompoks, 'links'))
    <div class="card-footer">
        {{ $kelompoks->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection