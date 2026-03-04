@extends('layouts.app')

@section('title', 'Laporan Disetujui')
@section('page-title', 'Laporan Disetujui')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Laporan Disetujui</h3>
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
                                <th>Tanggal Review</th>
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
                                <td>{{ $laporan->reviewed_at ? $laporan->reviewed_at->format('d/m/Y H:i') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.laporan.show', $laporan->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.laporan.download', [$laporan->id, 'laporan']) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada laporan disetujui</td>
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