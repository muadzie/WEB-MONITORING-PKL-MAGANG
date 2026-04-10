@extends('layouts.app')

@section('title', 'Penilaian PKL')
@section('page-title', 'Penilaian PKL Mahasiswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Penilaian PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('pt.penilaian.create') }}" class="btn btn-primary btn-sm">
    <i class="fas fa-plus"></i> Input Nilai Baru
</a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('pt.penilaian.index') }}" class="mb-3">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="kelompok_id" class="form-control">
                                <option value="">Semua Kelompok</option>
                                @foreach($kelompoks as $kelompok)
                                    <option value="{{ $kelompok->id }}" {{ request('kelompok_id') == $kelompok->id ? 'selected' : '' }}>
                                        {{ $kelompok->nama_kelompok }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('pt.penilaian.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </form>

                <!-- Tabel Penilaian -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Siswa</th>
                                <th>NIM</th>
                                <th>Kelompok</th>
                                <th>Nilai Kinerja</th>
                                <th>Nilai Kedisiplinan</th>
                                <th>Nilai Kerjasama</th>
                                <th>Nilai Inisiatif</th>
                                <th>Nilai Akhir</th>
                                <th>Tanggal</th>
                                <th width="12%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($penilaians as $index => $penilaian)
                            <tr>
                                <td>{{ $penilaians->firstItem() + $index }}</td>
                                <td>{{ $penilaian->kelompokSiswa->siswa->name }}</td>
                                <td>{{ $penilaian->kelompokSiswa->nim }}</td>
                                <td>{{ $penilaian->kelompokSiswa->kelompok->nama_kelompok }}</td>
                                <td class="text-center">{{ $penilaian->nilai_kinerja ?? '-' }}</td>
                                <td class="text-center">{{ $penilaian->nilai_kedisiplinan ?? '-' }}</td>
                                <td class="text-center">{{ $penilaian->nilai_kerjasama ?? '-' }}</td>
                                <td class="text-center">{{ $penilaian->nilai_inisiatif ?? '-' }}</td>
                                <td class="text-center">
                                    <strong>{{ $penilaian->nilai_akhir ?? '-' }}</strong>
                                </td>
                                <td>{{ $penilaian->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('pt.penilaian.show', $penilaian->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pt.penilaian.edit', $penilaian->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('pt.penilaian.destroy', $penilaian->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus penilaian ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle"></i> Belum ada data penilaian.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $penilaians->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection