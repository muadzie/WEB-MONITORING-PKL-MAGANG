@extends('layouts.app')

@section('title', 'Penilaian PKL')
@section('page-title', 'Penilaian PKL Mahasiswa')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Penilaian</h3>
        <a href="{{ route('dosen.penilaian.create') }}" class="btn btn-primary btn-sm float-right">
            <i class="fas fa-plus"></i> Input Nilai Baru
        </a>
    </div>
    <div class="card-body">
        @if(isset($penilaians) && $penilaians->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Siswa</th>
                            <th>NISN</th>
                            <th>Nilai Laporan</th>
                            <th>Nilai Presentasi</th>
                            <th>Nilai Sikap</th>
                            <th>Nilai Akhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penilaians as $index => $nilai)
                        <tr>
                            <td>{{ $penilaians->firstItem() + $index }}</td>
                            <td>{{ $nilai->kelompokSiswa->siswa->name }}</td>
                            <td>{{ $nilai->kelompokSiswa->nim }}</td>
                            <td>{{ $nilai->nilai_laporan ?? '-' }}</td>
                            <td>{{ $nilai->nilai_presentasi ?? '-' }}</td>
                            <td>{{ $nilai->nilai_sikap ?? '-' }}</td>
                            <td><strong>{{ $nilai->nilai_akhir ?? '-' }}</strong></td>
                            <td>
                                <a href="{{ route('dosen.penilaian.show', $nilai->id) }}" class="btn btn-info btn-sm">Detail</a>
                                <a href="{{ route('dosen.penilaian.edit', $nilai->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $penilaians->links() }}
        @else
            <div class="alert alert-info">Belum ada data penilaian.</div>
        @endif
    </div>
</div>
@endsection