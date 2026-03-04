@extends('layouts.app')

@section('title', 'Semua Laporan')
@section('page-title', 'Semua Laporan PKL')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Semua Laporan PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.laporan.pending') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-clock"></i> Lihat Pending
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.laporan.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="direview" {{ request('status') == 'direview' ? 'selected' : '' }}>Direview</option>
                                <option value="direvisi" {{ request('status') == 'direvisi' ? 'selected' : '' }}>Direvisi</option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari judul/nama" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block" type="submit">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Laporan</th>
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
                                    @elseif($laporan->status == 'direview')
                                        <span class="badge badge-info">Direview</span>
                                    @elseif($laporan->status == 'direvisi')
                                        <span class="badge badge-primary">Direvisi</span>
                                    @elseif($laporan->status == 'ditolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @else
                                        <span class="badge badge-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.laporan.download', [$laporan->id, 'laporan']) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    @if($laporan->file_presentasi)
                                    <a href="{{ route('admin.laporan.download', [$laporan->id, 'presentasi']) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-file-powerpoint"></i>
                                    </a>
                                    @endif
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
                
                <div class="mt-3">
                    {{ $laporans->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection