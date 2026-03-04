@extends('layouts.app')

@section('title', 'Rekap Data Siswa')
@section('page-title', 'Rekap Data Siswa')

@section('content')
<!-- Statistik Cards -->
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $statistik['total'] }}</h3>
                <p>Total Siswa</p>
            </div>
            <div class="icon"><i class="fas fa-user-graduate"></i></div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $statistik['sudah_kelompok'] }}</h3>
                <p>Sudah Kelompok</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $statistik['belum_kelompok'] }}</h3>
                <p>Belum Kelompok</p>
            </div>
            <div class="icon"><i class="fas fa-user-clock"></i></div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Data Siswa</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.rekap.siswa') }}" class="form-inline">
            <div class="form-group mr-2">
                <label for="angkatan" class="mr-2">Angkatan:</label>
                <select name="angkatan" id="angkatan" class="form-control">
                    <option value="">Semua Angkatan</option>
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('angkatan') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group mr-2">
                <label for="prodi" class="mr-2">Prodi:</label>
                <input type="text" name="prodi" id="prodi" class="form-control" 
                       value="{{ request('prodi') }}" placeholder="Contoh: TI">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Filter
            </button>
            <a href="{{ route('admin.rekap.siswa') }}" class="btn btn-secondary ml-2">
                <i class="fas fa-sync"></i> Reset
            </a>
            <a href="{{ route('admin.rekap.export', 'siswa') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success ml-2">
                <i class="fas fa-file-csv"></i> Export CSV
            </a>
        </form>
    </div>
</div>

<!-- Tabel Data Siswa -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data Siswa</h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Prodi</th>
                        <th>Kelas</th>
                        <th>Kelompok</th>
                        <th>Status Kelompok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswas as $index => $siswa)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $siswa->nomor_induk }}</td>
                        <td>{{ $siswa->name }}</td>
                        <td>{{ $siswa->email }}</td>
                        <td>{{ $siswa->phone ?? '-' }}</td>
                        <td>
                            @if($siswa->kelompokSiswa->isNotEmpty())
                                {{ $siswa->kelompokSiswa->first()->prodi }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($siswa->kelompokSiswa->isNotEmpty())
                                {{ $siswa->kelompokSiswa->first()->kelas }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($siswa->kelompokSiswa->isNotEmpty())
                                {{ $siswa->kelompokSiswa->first()->kelompok->nama_kelompok }}
                            @else
                                <span class="badge badge-warning">Belum kelompok</span>
                            @endif
                        </td>
                        <td>
                            @if($siswa->kelompokSiswa->isNotEmpty())
                                @php
                                    $status = $siswa->kelompokSiswa->first()->kelompok->status;
                                @endphp
                                @if($status == 'aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($status == 'selesai')
                                    <span class="badge badge-info">Selesai</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($status) }}</span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data siswa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection