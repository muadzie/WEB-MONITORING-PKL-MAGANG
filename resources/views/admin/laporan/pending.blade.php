@extends('layouts.app')

@section('title', 'Laporan Pending')
@section('page-title', 'Laporan Pending')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Laporan Pending (Perlu Review)</h3>
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
                                <th width="5%">No</th>
                                <th>Judul Laporan</th>
                                <th>Siswa</th>
                                <th>NIM</th>
                                <th>Kelompok</th>
                                <th>Dosen Pembimbing</th>
                                <th>Tanggal Upload</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporans as $index => $laporan)
                            <tr>
                                <td>{{ $laporans->firstItem() + $index }}</td>
                                <td>{{ $laporan->judul_laporan }}</td>
                                <td>{{ $laporan->kelompokSiswa->siswa->name }}</td>
                                <td>{{ $laporan->kelompokSiswa->nim }}</td>
                                <td>{{ $laporan->kelompokSiswa->kelompok->nama_kelompok }}</td>
                                <td>{{ $laporan->kelompokSiswa->kelompok->dosen->nama_dosen ?? '-' }}</td>
                                <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
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
                                <td colspan="8" class="text-center">
                                    <div class="alert alert-success mb-0">
                                        <i class="fas fa-check-circle"></i> Tidak ada laporan pending. Semua laporan sudah direview!
                                    </div>
                                </td>
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