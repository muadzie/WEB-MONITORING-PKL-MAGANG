@extends('layouts.app')

@section('title', 'Monitoring Siswa PKL')
@section('page-title', 'Monitoring Siswa PKL')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Kelompok PKL di Perusahaan Anda</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('pt.monitoring.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama kelompok" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('pt.monitoring.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kelompok</th>
                                <th>Dosen Pembimbing</th>
                                <th>Jumlah Anggota</th>
                                <th>Periode PKL</th>
                                <th>Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kelompoks as $index => $kelompok)
                            <tr>
                                <td>{{ $kelompoks->firstItem() + $index }}</td>
                                <td>{{ $kelompok->nama_kelompok }}</td>
                                <td>{{ $kelompok->dosen->nama_dosen ?? '-' }}</td>
                                <td class="text-center">{{ $kelompok->anggota->count() }} orang</td>
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
                                    <a href="{{ route('pt.monitoring.show', $kelompok->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada kelompok PKL</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $kelompoks->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection