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
                    <a href="{{ route('dosen.penilaian.select-siswa') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Input Nilai Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('dosen.penilaian.index') }}" class="mb-3">
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
                            <a href="{{ route('dosen.penilaian.index') }}" class="btn btn-secondary btn-block">
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
                                <th>Nilai Laporan</th>
                                <th>Nilai Presentasi</th>
                                <th>Nilai Sikap</th>
                                <th>Nilai Akhir</th>
                                <th>Tanggal Penilaian</th>
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
                                <td class="text-center">{{ $penilaian->nilai_laporan ?? '-' }}</td>
                                <td class="text-center">{{ $penilaian->nilai_presentasi ?? '-' }}</td>
                                <td class="text-center">{{ $penilaian->nilai_sikap ?? '-' }}</td>
                                <td class="text-center">
                                    <strong>{{ $penilaian->nilai_akhir ?? '-' }}</strong>
                                </td>
                                <td>{{ $penilaian->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('dosen.penilaian.show', $penilaian->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('dosen.penilaian.edit', $penilaian->id) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dosen.penilaian.destroy', $penilaian->id) }}" method="POST" class="d-inline">
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
                                <td colspan="10" class="text-center">
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