@extends('layouts.app')

@section('title', 'Manajemen Guru')
@section('page-title', 'Manajemen Guru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Guru</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.dosens.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Guru
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.dosens.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="jurusan" class="form-control">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusanList as $jurusan)
                                    <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>
                                        {{ $jurusan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama/NIDN/email" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.dosens.index') }}" class="btn btn-secondary btn-block">
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
                                <th width="8%">Foto</th>
                                <th>NIDN</th>
                                <th>Nama Guru</th>
                                <th>Jurusan</th>
                                <th>Fakultas</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dosens as $index => $dosen)
                            <tr>
                                <td>{{ $dosens->firstItem() + $index }}</td>
                                <td>
                                    <img class="profile-user-img img-fluid"
     src="{{ $dosen->foto ? asset('storage/'.$dosen->foto) : asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}"
     alt="Dosen profile picture"
     style="width: 80px; height: 80px; min-width: 80px; min-height: 80px; object-fit: cover; border-radius: 50%; display: block; margin: 0 auto;  box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                                </td>
                                <td>{{ $dosen->nidn }}</td>
                                <td>
                                    {{ $dosen->gelar_depan ? $dosen->gelar_depan.' ' : '' }}
                                    {{ $dosen->nama_dosen }}
                                    {{ $dosen->gelar_belakang ? ', '.$dosen->gelar_belakang : '' }}
                                </td>
                                <td>{{ $dosen->jurusan }}</td>
                                <td>{{ $dosen->fakultas }}</td>
                                <td>{{ $dosen->email }}</td>
                                <td>{{ $dosen->telepon }}</td>
                                <td>
                                    @if($dosen->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.dosens.edit', $dosen->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.dosens.show', $dosen->id) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.dosens.destroy', $dosen->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data dosen ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $dosens->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection