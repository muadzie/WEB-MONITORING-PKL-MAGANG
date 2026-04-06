@extends('layouts.app')

@section('title', 'Laporan PKL')
@section('page-title', 'Laporan PKL Mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Laporan PKL</h3>
    </div>
    <div class="card-body">
        @if(isset($laporans) && $laporans->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan</th>
                            <th>Siswa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporans as $index => $laporan)
                        <tr>
                            <td>{{ $laporans->firstItem() + $index }}</td>
                            <td>{{ $laporan->judul_laporan }}</td>
                            <td>{{ $laporan->kelompokSiswa->siswa->name ?? '-' }}</td>
                            <td>
                                @if($laporan->status == 'diajukan')
                                    <span class="badge badge-warning">Diajukan</span>
                                @elseif($laporan->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($laporan->status == 'direvisi')
                                    <span class="badge badge-primary">Direvisi</span>
                                @elseif($laporan->status == 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($laporan->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dosen.laporan.review', $laporan->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Review
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $laporans->links() }}
            </div>
        @else
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Belum ada laporan.
            </div>
        @endif
    </div>
</div>
@endsection