@extends('layouts.app')

@section('title', 'Logbook Pending')
@section('page-title', 'Logbook Perlu Review Dosen')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Logbook Menunggu Review Dosen</h3>
                <div class="card-tools">
                    <div class="btn-group">
                        <a href="{{ route('dosen.logbook.pending') }}?status=pending" class="btn btn-warning btn-sm">
                            <i class="fas fa-clock"></i> Pending
                        </a>
                        <a href="{{ route('dosen.logbook.pending') }}?status=disetujui" class="btn btn-success btn-sm">
                            <i class="fas fa-check"></i> Disetujui
                        </a>
                        <a href="{{ route('dosen.logbook.pending') }}?status=ditolak" class="btn btn-danger btn-sm">
                            <i class="fas fa-times"></i> Ditolak
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Form Filter -->
                <form method="GET" action="{{ route('dosen.logbook.pending') }}" class="mb-3">
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
                                @foreach($kelompoks ?? [] as $kelompok)
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
                            <div class="btn-group w-100">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('dosen.logbook.pending') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Tabel Logbook -->
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
                                <th width="10%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logbooks as $index => $logbook)
                            @php
                                $fotoPath = $logbook->dokumentasi ? 'storage/' . $logbook->dokumentasi : null;
                                $fotoExists = $fotoPath && Storage::disk('public')->exists($logbook->dokumentasi);
                            @endphp
                            <tr>
                                <td>{{ $logbooks->firstItem() + $index }}</td>
                                <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $logbook->kelompokSiswa->siswa->name }}</td>
                                <td>{{ $logbook->kelompokSiswa->nim }}</td>
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
                                    <div class="btn-group btn-group-sm">
                                        <!-- Tombol Preview -->
                                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#previewModal{{ $logbook->id }}" title="Preview">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Tombol Review (hanya jika status pending) -->
                                        @if($logbook->status == 'pending')
                                            <a href="{{ route('dosen.logbook.review', $logbook->id) }}" class="btn btn-warning" title="Review">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                    </div>
                                    
                                    <!-- Modal Preview -->
                                    <div class="modal fade" id="previewModal{{ $logbook->id }}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-book"></i> Preview Logbook
                                                    </h5>
                                                    <button type="button" class="close text-white" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Informasi Logbook -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <table class="table table-sm table-bordered">
                                                                <tr>
                                                                    <th width="40%">Tanggal</th>
                                                                    <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Siswa</th>
                                                                    <td>{{ $logbook->kelompokSiswa->siswa->name }} ({{ $logbook->kelompokSiswa->nim }})</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Kelompok</th>
                                                                    <td>{{ $logbook->kelompokSiswa->kelompok->nama_kelompok }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Jam</th>
                                                                    <td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Status</th>
                                                                    <td>
                                                                        @if($logbook->status == 'pending')
                                                                            <span class="badge badge-warning">Pending</span>
                                                                        @elseif($logbook->status == 'disetujui')
                                                                            <span class="badge badge-success">Disetujui</span>
                                                                        @else
                                                                            <span class="badge badge-danger">Ditolak</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Status Review Dosen</th>
                                                                    <td>
                                                                        @if($logbook->approved_by_dosen)
                                                                            <span class="badge badge-success">Sudah Direview</span>
                                                                        @else
                                                                            <span class="badge badge-danger">Belum Direview</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Status Review PT</th>
                                                                    <td>
                                                                        @if($logbook->approved_by_pt)
                                                                            <span class="badge badge-success">Sudah Direview</span>
                                                                        @else
                                                                            <span class="badge badge-warning">Belum Direview</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="callout callout-info">
                                                                <strong>Kegiatan:</strong>
                                                                <p>{{ $logbook->kegiatan }}</p>
                                                            </div>
                                                            <div class="callout callout-default">
                                                                <strong>Deskripsi:</strong>
                                                                <p>{{ $logbook->deskripsi }}</p>
                                                            </div>
                                                            @if($logbook->catatan_dosen)
                                                            <div class="callout callout-warning">
                                                                <strong>Catatan Dosen:</strong>
                                                                <p>{{ $logbook->catatan_dosen }}</p>
                                                            </div>
                                                            @endif
                                                            @if($logbook->catatan_pt)
                                                            <div class="callout callout-danger">
                                                                <strong>Catatan PT:</strong>
                                                                <p>{{ $logbook->catatan_pt }}</p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Dokumentasi dengan Download -->
                                                    @if($logbook->dokumentasi)
                                                    <div class="card card-outline card-primary mt-3">
                                                        <div class="card-header">
                                                            <h5 class="card-title">
                                                                <i class="fas fa-image"></i> Dokumentasi
                                                            </h5>
                                                        </div>
                                                        <div class="card-body text-center">
                                                            @if($fotoExists)
                                                                <img src="{{ asset($fotoPath) }}" 
                                                                     class="img-fluid img-thumbnail" 
                                                                     style="max-height: 250px; cursor: pointer;"
                                                                     onclick="window.open(this.src)">
                                                                <div class="btn-group mt-3">
                                                                    <a href="{{ asset($fotoPath) }}" class="btn btn-primary btn-sm" target="_blank">
                                                                        <i class="fas fa-external-link-alt"></i> Lihat
                                                                    </a>
                                                                    <a href="{{ asset($fotoPath) }}" class="btn btn-success btn-sm" download>
                                                                        <i class="fas fa-download"></i> Download
                                                                    </a>
                                                                </div>
                                                            @else
                                                                <div class="alert alert-warning">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                    File dokumentasi tidak ditemukan.<br>
                                                                    <small>Path: {{ $logbook->dokumentasi }}</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="alert alert-secondary mt-3">
                                                        <i class="fas fa-camera"></i> Tidak ada dokumentasi
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    @if($logbook->status == 'pending' && !$logbook->approved_by_dosen)
                                                        <a href="{{ route('dosen.logbook.review', $logbook->id) }}" class="btn btn-warning">
                                                            <i class="fas fa-edit"></i> Review Sekarang
                                                        </a>
                                                    @endif
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle"></i> Tidak ada data logbook
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

@push('styles')
<style>
    .modal-lg {
        max-width: 900px;
    }
    .callout {
        padding: 12px;
        margin-bottom: 12px;
        border-left: 4px solid;
        border-radius: 4px;
    }
    .callout-info { border-left-color: #17a2b8; background: #e3f2fd; }
    .callout-default { border-left-color: #6c757d; background: #f8f9fa; }
    .callout-warning { border-left-color: #ffc107; background: #fff3cd; }
    .callout-danger { border-left-color: #dc3545; background: #f8d7da; }
    .btn-group-sm .btn {
        margin: 0 2px;
        padding: 5px 10px;
    }
    .table th {
        background-color: #f4f6f9;
    }
</style>
@endpush