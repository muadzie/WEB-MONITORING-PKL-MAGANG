@extends('layouts.app')

@section('title', 'Manajemen Kelompok PKL')
@section('page-title', 'Manajemen Kelompok PKL')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Kelompok PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.kelompok.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Kelompok
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.kelompok.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Semua Status</option>
                                @foreach($statusList as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="dosen_id" class="form-control">
                                <option value="">Semua Dosen</option>
                                @foreach($dosens as $dosen)
                                    <option value="{{ $dosen->id }}" {{ request('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->nama_dosen }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
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
                            <a href="{{ route('admin.kelompok.index') }}" class="btn btn-secondary btn-block">
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
                                <th>Perusahaan</th>
                                <th>Jumlah Anggota</th>
                                <th>Periode</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kelompoks as $index => $kelompok)
                            <tr>
                                <td>{{ $kelompoks->firstItem() + $index }}</td>
                                <td>{{ $kelompok->nama_kelompok }}</td>
                                <td>{{ $kelompok->dosen->nama_dosen ?? '-' }}</td>
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
                                    @elseif($kelompok->status == 'dibatalkan')
                                        <span class="badge badge-danger">Dibatalkan</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($kelompok->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.kelompok.show', $kelompok->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.kelompok.edit', $kelompok->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($kelompok->status == 'pending')
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#approveModal{{ $kelompok->id }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    @endif
                                    <form action="{{ route('admin.kelompok.destroy', $kelompok->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kelompok ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Approve Modal -->
                            @if($kelompok->status == 'pending')
                            <div class="modal fade" id="approveModal{{ $kelompok->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Approve Kelompok</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.kelompok.approve', $kelompok->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <select name="status" class="form-control" required>
                                                        <option value="aktif">Aktifkan</option>
                                                        <option value="dibatalkan">Batalkan</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Catatan</label>
                                                    <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan catatan jika perlu"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data</td>
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