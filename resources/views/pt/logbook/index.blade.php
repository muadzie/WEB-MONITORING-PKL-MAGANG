@extends('layouts.app')

@section('title', 'Logbook PKL')
@section('page-title', 'Logbook Kegiatan PKL')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Logbook PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('pt.logbook.index') }}?status=pending" class="btn btn-warning btn-sm">
                        <i class="fas fa-clock"></i> Lihat Pending
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('pt.logbook.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="kelompok_id" class="form-control">
                                <option value="">Semua Kelompok</option>
                                @foreach($kelompoks as $kelompok)
                                    <option value="{{ $kelompok->id }}" {{ request('kelompok_id') == $kelompok->id ? 'selected' : '' }}>
                                        {{ $kelompok->nama_kelompok }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Siswa</th>
                                <th>Kelompok</th>
                                <th>Kegiatan</th>
                                <th>Jam</th>
                                <th>Status</th>
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
                                    @if($logbook->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($logbook->status == 'disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pt.logbook.review', $logbook->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Review
                                    </a>
                                </td>
                            </tr>
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