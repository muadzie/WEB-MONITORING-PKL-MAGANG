@extends('layouts.app')

@section('title', 'Semua Logbook')
@section('page-title', 'Semua Logbook PKL')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Semua Logbook</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.logbook.index') }}?status=pending" class="btn btn-warning btn-sm">
                        <i class="fas fa-clock"></i> Pending
                    </a>
                    <a href="{{ route('admin.logbook.index') }}?status=disetujui" class="btn btn-success btn-sm">
                        <i class="fas fa-check"></i> Disetujui
                    </a>
                    <a href="{{ route('admin.logbook.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-sync"></i> Semua
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Tanggal</th>
                                <th width="15%">Siswa</th>
                                <th width="10%">NIM</th>
                                <th width="15%">Kelompok</th>
                                <th width="25%">Kegiatan</th>
                                <th width="10%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logbooks as $index => $logbook)
                            <tr>
                                <td class="text-center">{{ $logbooks->firstItem() + $index }}</td>
                                <td class="text-center">{{ $logbook->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $logbook->kelompokSiswa?->siswa?->name ?? '-' }}</td>
                                <td class="text-center">{{ $logbook->kelompokSiswa?->nim ?? '-' }}</td>
                                <td>{{ $logbook->kelompokSiswa?->kelompok?->nama_kelompok ?? '-' }}</td>
                                <td>{{ Str::limit($logbook->kegiatan, 50) }}</td>
                                <td class="text-center">
                                    @if($logbook->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($logbook->status == 'disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{ $logbook->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            <div class="modal fade" id="detailModal{{ $logbook->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Detail Logbook</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-sm table-bordered">
                                                <tr><th>Tanggal</th><td>{{ $logbook->tanggal->format('d/m/Y') }}</td></tr>
                                                <tr><th>Siswa</th><td>{{ $logbook->kelompokSiswa?->siswa?->name ?? '-' }}</td></tr>
                                                <tr><th>NIM</th><td>{{ $logbook->kelompokSiswa?->nim ?? '-' }}</td></tr>
                                                <tr><th>Kelompok</th><td>{{ $logbook->kelompokSiswa?->kelompok?->nama_kelompok ?? '-' }}</td></tr>
                                                <tr><th>Kegiatan</th><td>{{ $logbook->kegiatan }}</td></tr>
                                                <tr><th>Deskripsi</th><td>{{ $logbook->deskripsi }}</td></tr>
                                                <tr><th>Jam</th><td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td></tr>
                                                <tr><th>Status</th><td>{{ ucfirst($logbook->status) }}</td></tr>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data logbook</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $logbooks->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
