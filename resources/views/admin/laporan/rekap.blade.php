@extends('layouts.app')

@section('title', 'Rekap Laporan PKL')
@section('page-title', 'Rekap Laporan PKL')

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $statistik['total'] }}</h3>
                <p>Total Laporan</p>
            </div>
            <div class="icon"><i class="fas fa-file-alt"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $statistik['diajukan'] }}</h3>
                <p>Perlu Review</p>
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

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Filter Laporan</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan.rekap') }}">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="diajukan">Diajukan</option>
                            <option value="direview">Direview</option>
                            <option value="direvisi">Direvisi</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Kelompok</label>
                        <select name="kelompok_id" class="form-control">
                            <option value="">Semua Kelompok</option>
                            @foreach($kelompoks as $kelompok)
                                <option value="{{ $kelompok->id }}">{{ $kelompok->nama_kelompok }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tahun</label>
                        <select name="tahun" class="form-control">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('admin.laporan.rekap') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Laporan</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Siswa</th>
                    <th>Kelompok</th>
                    <th>Status</th>
                    <th>Tanggal Upload</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporans as $laporan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $laporan->judul_laporan }}</td>
                    <td>{{ $laporan->kelompokSiswa->siswa->name }}</td>
                    <td>{{ $laporan->kelompokSiswa->kelompok->nama_kelompok }}</td>
                    <td>
                        @if($laporan->status == 'disetujui')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($laporan->status == 'diajukan')
                            <span class="badge badge-warning">Diajukan</span>
                        @elseif($laporan->status == 'direvisi')
                            <span class="badge badge-info">Direvisi</span>
                        @elseif($laporan->status == 'ditolak')
                            <span class="badge badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($laporan->status) }}</span>
                        @endif
                    </td>
                    <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ asset('storage/'.$laporan->file_laporan) }}" class="btn btn-xs btn-info" target="_blank">
                            <i class="fas fa-download"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $laporans->links() }}
    </div>
</div>
@endsection