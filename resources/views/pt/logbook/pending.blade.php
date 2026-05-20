@extends('layouts.app')

@section('title', 'Logbook Pending')
@section('page-title', 'Logbook Menunggu Review')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Logbook Pending</h3>
                <div class="card-tools">
                    <a href="{{ route('pt.logbook.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-list"></i> Semua Logbook
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
                                <th width="20%">Kegiatan</th>
                                <th width="10%">Jam</th>
                                <th width="15%">Aksi</th>
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
                                <td class="text-center">{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
                                <td class="text-center">
                                    <a href="{{ route('pt.logbook.review', $logbook->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Review
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="alert alert-success mb-0">
                                        <i class="fas fa-check-circle"></i> Semua logbook sudah direview
                                    </div>
                                </td>
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
