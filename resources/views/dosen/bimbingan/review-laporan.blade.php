@extends('layouts.app')

@section('title', 'Review Logbook')
@section('page-title', 'Review Logbook Kegiatan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Logbook</h3>
                <a href="{{ route('dosen.logbook.pending') }}" class="btn btn-secondary btn-sm float-right">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th>Tanggal</th><td>{{ \Carbon\Carbon::parse($logbook->tanggal)->format('d F Y') }}</td></tr>
                    <tr><th>Siswa</th><td>{{ $logbook->kelompokSiswa->siswa->name }}</td></tr>
                    <tr><th>NIM</th><td>{{ $logbook->kelompokSiswa->nim }}</td></tr>
                    <tr><th>Kelompok</th><td>{{ $logbook->kelompokSiswa->kelompok->nama_kelompok }}</td></tr>
                    <tr><th>Kegiatan</th><td>{{ $logbook->kegiatan }}</td></tr>
                    <tr><th>Deskripsi</th><td>{{ $logbook->deskripsi }}</td></tr>
                    <tr><th>Jam</th><td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td></tr>
                    <tr><th>Status</th>
                        <td>
                            @if($logbook->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($logbook->status == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @if($logbook->dokumentasi)
                    <tr><th>Dokumentasi</th>
                        <td>
                            <img src="{{ asset('storage/'.$logbook->dokumentasi) }}" class="img-fluid" style="max-height: 200px;">
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Form Review</h3>
            </div>
            <form action="{{ route('dosen.logbook.approve', $logbook->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action" id="approve" value="approve" checked>
                            <label class="form-check-label text-success" for="approve">
                                <i class="fas fa-check"></i> Setujui
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action" id="reject" value="reject">
                            <label class="form-check-label text-danger" for="reject">
                                <i class="fas fa-times"></i> Tolak
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="4" placeholder="Catatan untuk siswa..."></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-paper-plane"></i> Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection