@extends('layouts.app')

@section('title', 'Laporan PKL')
@section('page-title', 'Laporan PKL Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Laporan PKL</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Siswa</th>
                                <th width="10%">NIM</th>
                                <th width="15%">Kelompok</th>
                                <th width="25%">Judul Laporan</th>
                                <th width="10%">Status</th>
                                <th width="10%">Tanggal</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporans as $index => $laporan)
                            <tr>
                                <td class="text-center">{{ $laporans->firstItem() + $index }}</td>
                                <td>{{ $laporan->kelompokSiswa?->siswa?->name ?? '-' }}</td>
                                <td class="text-center">{{ $laporan->kelompokSiswa?->nim ?? '-' }}</td>
                                <td>{{ $laporan->kelompokSiswa?->kelompok?->nama_kelompok ?? '-' }}</td>
                                <td>{{ Str::limit($laporan->judul_laporan, 50) }}</td>
                                <td class="text-center">
                                    @if($laporan->status == 'diajukan')
                                        <span class="badge badge-warning">Diajukan</span>
                                    @elseif($laporan->status == 'disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                    @elseif($laporan->status == 'direvisi')
                                        <span class="badge badge-info">Direvisi</span>
                                    @elseif($laporan->status == 'ditolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($laporan->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $laporan->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('pt.laporan.show', $laporan->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pt.laporan.download', $laporan->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data laporan</td>
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
