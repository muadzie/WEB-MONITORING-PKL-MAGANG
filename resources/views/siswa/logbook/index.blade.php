@extends('layouts.app')

@section('title', 'Logbook Kegiatan')
@section('page-title', 'Logbook Kegiatan PKL')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Logbook Kegiatan</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.logbook.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Logbook
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(!isset($kelompokSiswa) || !$kelompokSiswa)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Anda belum terdaftar dalam kelompok PKL. Silakan hubungi admin atau dosen pembimbing.
                    </div>
                @else
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('siswa.logbook.index') }}" class="mb-3">
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
                                <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                           placeholder="Cari kegiatan" value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('siswa.logbook.index') }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Tabel Logbook -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tanggal</th>
                                    <th>Kegiatan</th>
                                    <th>Jam</th>
                                    <th>Status</th>
                                    <th>Approval</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($logbooks as $index => $logbook)
                                <tr>
                                    <td>{{ $logbooks->firstItem() + $index }}</td>
                                    <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
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
                                        @if($logbook->approved_by_dosen)
                                            <span class="badge badge-info" title="Disetujui Dosen">Dosen ✓</span>
                                        @endif
                                        @if($logbook->approved_by_pt)
                                            <span class="badge badge-info" title="Disetujui PT">PT ✓</span>
                                        @endif
                                        @if(!$logbook->approved_by_dosen && !$logbook->approved_by_pt)
                                            <span class="badge badge-secondary">Menunggu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('siswa.logbook.show', $logbook->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($logbook->status == 'pending')
                                            <a href="{{ route('siswa.logbook.edit', $logbook->id) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('siswa.logbook.destroy', $logbook->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus logbook ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if($logbook->dokumentasi)
                                            <a href="{{ asset('storage/'.$logbook->dokumentasi) }}" target="_blank" class="btn btn-success btn-sm">
                                                <i class="fas fa-image"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="alert alert-info mb-0">
                                            <i class="fas fa-info-circle"></i> Belum ada logbook. 
                                            <a href="{{ route('siswa.logbook.create') }}">Tambah sekarang</a>
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
                @endif
            </div>
        </div>
    </div>
</div>
@endsection