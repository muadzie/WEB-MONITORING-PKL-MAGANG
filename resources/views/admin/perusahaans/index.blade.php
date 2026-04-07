@extends('layouts.app')

@section('title', 'Manajemen Perusahaan')
@section('page-title', 'Manajemen Perusahaan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Perusahaan/PT</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.perusahaans.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Tambah Perusahaan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.perusahaans.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="bidang_usaha" class="form-control">
                                <option value="">Semua Bidang</option>
                                @foreach($bidangUsahaList as $bidang)
                                    <option value="{{ $bidang }}" {{ request('bidang_usaha') == $bidang ? 'selected' : '' }}>
                                        {{ $bidang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari nama/email/kontak person" value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('admin.perusahaans.index') }}" class="btn btn-secondary btn-block">
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
                                <th width="8%">Logo</th>
                                <th>Nama Perusahaan</th>
                                <th>Bidang Usaha</th>
                                <th>Kontak Person</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($perusahaans as $index => $perusahaan)
                            @php
                                $logoPerusahaan = $perusahaan->logo ?? $perusahaan->user->foto ?? null;
                            @endphp
                            <tr>
                                <td>{{ $perusahaans->firstItem() + $index }}</td>
                                <td>
                                    <img class="profile-user-img img-fluid"
                                         src="{{ $logoPerusahaan ? asset('storage/'.$logoPerusahaan) : asset('vendor/adminlte/dist/img/avatar.png') }}"
                                         alt="{{ $perusahaan->nama_perusahaan }}"
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%; display: block; margin: 0 auto; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                                </td>
                                <td>{{ $perusahaan->nama_perusahaan }}</td>
                                <td>{{ $perusahaan->bidang_usaha }}</td>
                                <td>{{ $perusahaan->kontak_person }}</td>
                                <td>{{ $perusahaan->telepon }}</td>
                                <td>{{ $perusahaan->email }}</td>
                                <td>
                                    @if($perusahaan->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.perusahaans.edit', $perusahaan->id) }}" class="btn btn-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.perusahaans.show', $perusahaan->id) }}" class="btn btn-primary" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.perusahaans.toggle-status', $perusahaan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @if($perusahaan->is_active)
                                                <button type="submit" class="btn btn-warning" title="Nonaktifkan" onclick="return confirm('Nonaktifkan perusahaan ini?')">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-success" title="Aktifkan" onclick="return confirm('Aktifkan perusahaan ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </form>
                                        <form action="{{ route('admin.perusahaans.destroy', $perusahaan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Hapus" onclick="return confirm('Hapus data perusahaan ini? Semua data terkait akan dihapus.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle"></i> Tidak ada data perusahaan
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $perusahaans->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-group-sm .btn {
        margin: 0 2px;
        padding: 5px 10px;
    }
    .btn-group-sm .btn i {
        font-size: 12px;
    }
    .table td {
        vertical-align: middle;
    }
</style>
@endpush