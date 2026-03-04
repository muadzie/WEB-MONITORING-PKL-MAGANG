@extends('layouts.app')

@section('title', 'Logbook Pending')
@section('page-title', 'Logbook Perlu Review')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Logbook Pending</h3>
                <div class="card-tools">
                    <form method="GET" action="{{ route('dosen.logbook.pending') }}" class="form-inline">
                        <input type="text" name="search" class="form-control form-control-sm mr-2" 
                               placeholder="Cari siswa/kegiatan" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kelompok</th>
                            <th>Kegiatan</th>
                            <th>Jam</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logbooks as $logbook)
                        <tr>
                            <td>{{ $logbooks->firstItem() + $loop->index }}</td>
                            <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $logbook->kelompokSiswa->siswa->name }}</td>
                            <td>{{ $logbook->kelompokSiswa->kelompok->nama_kelompok }}</td>
                            <td>{{ Str::limit($logbook->kegiatan, 50) }}</td>
                            <td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
                            <td>
                                <a href="{{ route('dosen.logbook.review', $logbook->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Review
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">
                                <div class="alert alert-success mb-0">
                                    <i class="fas fa-check-circle"></i> Tidak ada logbook pending
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $logbooks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection