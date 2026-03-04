@extends('layouts.app')

@section('title', 'Kelompok Bimbingan')
@section('page-title', 'Kelompok Bimbingan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Kelompok Bimbingan</h3>
                <div class="card-tools">
                    <form method="GET" action="{{ route('dosen.bimbingan.index') }}" class="form-inline">
                        <select name="status" class="form-control form-control-sm mr-2">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-sm btn-secondary ml-2">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </form>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kelompok</th>
                            <th>Perusahaan</th>
                            <th>Jumlah Anggota</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kelompoks as $index => $kelompok)
                        <tr>
                            <td>{{ $kelompoks->firstItem() + $index }}</td>
                            <td>{{ $kelompok->nama_kelompok }}</td>
                            <td>{{ $kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
                            <td>{{ $kelompok->anggota->count() }} orang</td>
                            <td>
                                {{ $kelompok->tanggal_mulai->format('d/m/Y') }} <br>
                                <small>s/d</small> <br>
                                {{ $kelompok->tanggal_selesai->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($kelompok->status == 'aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @elseif($kelompok->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($kelompok->status == 'selesai')
                                    <span class="badge badge-info">Selesai</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($kelompok->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dosen.bimbingan.show', $kelompok->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada kelompok bimbingan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $kelompoks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection