@extends('layouts.app')

@section('title', 'Rekap Logbook')
@section('page-title', 'Rekap Logbook Kegiatan')

@section('content')
<!-- Statistik Cards -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $statistik['total'] }}</h3>
                <p>Total Logbook</p>
            </div>
            <div class="icon"><i class="fas fa-book"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $statistik['pending'] }}</h3>
                <p>Pending</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $statistik['disetujui'] }}</h3>
                <p>Disetujui</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $statistik['ditolak'] }}</h3>
                <p>Ditolak</p>
            </div>
            <div class="icon"><i class="fas fa-times-circle"></i></div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Logbook</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.rekap.logbook') }}" class="form-inline">
            <div class="form-group mr-2">
                <label for="tanggal_mulai" class="mr-2">Tanggal Mulai:</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" 
                       value="{{ request('tanggal_mulai') }}">
            </div>
            <div class="form-group mr-2">
                <label for="tanggal_selesai" class="mr-2">Tanggal Selesai:</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control" 
                       value="{{ request('tanggal_selesai') }}">
            </div>
            <div class="form-group mr-2">
                <label for="status" class="mr-2">Status:</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.rekap.logbook') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-sync"></i> Reset
            </a>
            <a href="{{ route('admin.rekap.export', 'logbook') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success ml-2">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </form>
    </div>
</div>

<!-- Tabel Logbook -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Logbook</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelompok</th>
                        <th>Kegiatan</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logbooks as $index => $logbook)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $logbook->kelompokSiswa->siswa->name }}</td>
                        <td>{{ $logbook->kelompokSiswa->kelompok->nama_kelompok }}</td>
                        <td>{{ Str::limit($logbook->kegiatan, 50) }}</td>
                        <td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
                        <td>
                            @if($logbook->status == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($logbook->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($logbook->approved_by_dosen)
                                <span class="badge badge-info">Dosen ✓</span>
                            @endif
                            @if($logbook->approved_by_pt)
                                <span class="badge badge-info">PT ✓</span>
                            @endif
                            @if(!$logbook->approved_by_dosen && !$logbook->approved_by_pt)
                                <span class="badge badge-secondary">Menunggu</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data logbook</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection