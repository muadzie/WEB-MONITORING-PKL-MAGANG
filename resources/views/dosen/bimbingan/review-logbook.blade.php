@extends('layouts.app')

@section('title', 'Review Logbook')
@section('page-title', 'Review Logbook Kegiatan')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Logbook</h3>
                <div class="card-tools">
                    <a href="{{ route('dosen.logbook.pending') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nama Siswa</th>
                        <td>{{ $logbook->kelompokSiswa->siswa->name }}</td>
                    </tr>
                    <tr>
                        <th>NIM</th>
                        <td>{{ $logbook->kelompokSiswa->nim }}</td>
                    </tr>
                    <tr>
                        <th>Kelompok</th>
                        <td>{{ $logbook->kelompokSiswa->kelompok->nama_kelompok }}</td>
                    </tr>
                    <tr>
                        <th>Perusahaan</th>
                        <td>{{ $logbook->kelompokSiswa->kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $logbook->tanggal->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Kegiatan</th>
                        <td>{{ $logbook->kegiatan }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $logbook->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th>Jam</th>
                        <td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
                    </tr>
                    @if($logbook->dokumentasi)
                    <tr>
                        <th>Dokumentasi</th>
                        <td>
                            <img src="{{ asset('storage/'.$logbook->dokumentasi) }}" 
                                 class="img-fluid" style="max-height: 300px;">
                            <br>
                            <a href="{{ route('dosen.logbook.download', $logbook->id) }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-download"></i> Download
                            </a>
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
            <form action="{{ route('approval.logbook.dosen', $logbook->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action" 
                                   id="approve" value="approve" checked>
                            <label class="form-check-label text-success" for="approve">
                                <i class="fas fa-check"></i> Setujui
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action" 
                                   id="reject" value="reject">
                            <label class="form-check-label text-danger" for="reject">
                                <i class="fas fa-times"></i> Tolak
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="catatan">Catatan</label>
                        <textarea class="form-control" name="catatan" id="catatan" 
                                  rows="4" placeholder="Masukkan catatan jika perlu"></textarea>
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