@extends('layouts.app')

@section('title', 'Pilih Siswa')
@section('page-title', 'Pilih Siswa untuk Penilaian')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pilih Siswa yang Akan Dinilai</h3>
                <div class="card-tools">
                    <a href="{{ route('dosen.penilaian.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($kelompoks->isEmpty())
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Belum ada kelompok yang selesai PKL. Penilaian hanya dapat dilakukan untuk kelompok dengan status "Selesai".
                    </div>
                @else
                    @foreach($kelompoks as $kelompok)
                        <div class="card mb-3">
                            <div class="card-header bg-info">
                                <h4 class="card-title">{{ $kelompok->nama_kelompok }}</h4>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIM</th>
                                            <th>Nama Siswa</th>
                                            <th>Kelas</th>
                                            <th>Prodi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kelompok->anggota as $index => $anggota)
                                            @php
                                                $sudahDinilai = App\Models\Penilaian::where('kelompok_siswa_id', $anggota->id)
                                                                  ->where('penilai', 'dosen')
                                                                  ->exists();
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $anggota->nim }}</td>
                                                <td>{{ $anggota->siswa->name }}</td>
                                                <td>{{ $anggota->kelas }}</td>
                                                <td>{{ $anggota->prodi }}</td>
                                                <td>
                                                    @if($sudahDinilai)
                                                        <span class="badge badge-success">Sudah Dinilai</span>
                                                    @else
                                                        <span class="badge badge-warning">Belum Dinilai</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($sudahDinilai)
                                                        <a href="{{ route('dosen.penilaian.edit', App\Models\Penilaian::where('kelompok_siswa_id', $anggota->id)->where('penilai', 'dosen')->first()->id) }}" class="btn btn-warning btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    @else
                                                        <a href="{{ route('dosen.penilaian.create', ['kelompok_siswa_id' => $anggota->id]) }}" class="btn btn-primary btn-sm">
                                                            <i class="fas fa-star"></i> Nilai
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection