@extends('layouts.app')

@section('title', 'Laporan Ditolak')
@section('page-title', 'Laporan Ditolak')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Laporan Ditolak</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Semua Laporan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Laporan</th>
                                <th>Siswa</th>
                                <th>Kelompok</th>
                                <th>Reviewer</th>
                                <th>Catatan</th>
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
                                <td>{{ $laporan->reviewer->name ?? '-' }}</td>
                                <td>{{ Str::limit($laporan->catatan_revisi, 50) ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada laporan ditolak</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection