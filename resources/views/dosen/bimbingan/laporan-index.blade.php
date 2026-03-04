@extends('layouts.app')

@section('title', 'Laporan PKL')
@section('page-title', 'Laporan PKL Mahasiswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Laporan PKL</h3>
                <div class="card-tools">
                    <form method="GET" action="{{ route('dosen.laporan.index') }}" class="form-inline">
                        <select name="status" class="form-control form-control-sm mr-2">
                            <option value="">Semua Status</option>
                            <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="direview" {{ request('status') == 'direview' ? 'selected' : '' }}>Direview</option>
                            <option value="direvisi" {{ request('status') == 'direvisi' ? 'selected' : '' }}>Direvisi</option>
                            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <input type="text" name="search" class="form-control form-control-sm mr-2" 
                               placeholder="Cari judul" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
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
                            <td>{{ $laporans->firstItem() + $loop->index }}</td>
                            <td>{{ $laporan->judul_laporan }}</td>
                            <td>{{ $laporan->kelompokSiswa->siswa->name }}</td>
                            <td>{{ $laporan->kelompokSiswa->kelompok->nama_kelompok }}</td>
                            <td>
                                @if($laporan->status == 'diajukan')
                                    <span class="badge badge-warning">Diajukan</span>
                                @elseif($laporan->status == 'direview')
                                    <span class="badge badge-info">Direview</span>
                                @elseif($laporan->status == 'direvisi')
                                    <span class="badge badge-primary">Direvisi</span>
                                @elseif($laporan->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($laporan->status == 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $laporan->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('dosen.laporan.review', $laporan->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Review
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada laporan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection