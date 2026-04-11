@extends('layouts.app')

@section('title', 'Laporan PKL')
@section('page-title', 'Laporan PKL Mahasiswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Laporan PKL</h3>
                <div class="card-tools">
                    <form method="GET" action="{{ route('dosen.laporan.index') }}" class="form-inline">
                        <div class="input-group input-group-sm">
                            <select name="status" class="form-control form-control-sm mr-2">
                                <option value="">Semua Status</option>
                                <option value="diajukan" {{ request('status') == 'diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="direview" {{ request('status') == 'direview' ? 'selected' : '' }}>Direview</option>
                                <option value="direvisi" {{ request('status') == 'direvisi' ? 'selected' : '' }}>Direvisi</option>
                                <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari judul/nama..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('dosen.laporan.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-sync"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                @if(isset($laporans) && $laporans->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">Judul Laporan</th>
                                    <th width="15%">Siswa</th>
                                    <th width="10%">NIM</th>
                                    <th width="10%">Tanggal Upload</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($laporans as $index => $laporan)
                                <tr>
                                    <td>{{ $laporans->firstItem() + $index }}</td>
                                    <td>
                                        {{ $laporan->judul_laporan }}
                                        @if($laporan->status == 'direvisi')
                                            <i class="fas fa-exclamation-circle text-warning" title="Perlu revisi"></i>
                                        @endif
                                    </td>
                                    <td>{{ $laporan->kelompokSiswa->siswa->name ?? '-' }}</td>
                                    <td>{{ $laporan->kelompokSiswa->nim ?? '-' }}</td>
                                    <td>{{ $laporan->created_at->format('d/m/Y') }}</td>
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
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('dosen.laporan.review', $laporan->id) }}" class="btn btn-info" title="Review">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($laporan->file_laporan)
                                                <a href="{{ route('dosen.laporan.download', [$laporan->id, 'laporan']) }}" class="btn btn-primary" title="Download Laporan">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            @endif
                                            @if($laporan->file_presentasi)
                                                <a href="{{ route('dosen.laporan.download', [$laporan->id, 'presentasi']) }}" class="btn btn-success" title="Download Presentasi">
                                                    <i class="fas fa-file-powerpoint"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>Menampilkan {{ $laporans->firstItem() }} - {{ $laporans->lastItem() }} dari {{ $laporans->total() }} data</div>
                            <div>{{ $laporans->withQueryString()->links() }}</div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info m-3">
                        <i class="fas fa-info-circle"></i> Belum ada laporan yang diajukan.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection