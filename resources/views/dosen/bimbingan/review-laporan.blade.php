@extends('layouts.app')

@section('title', 'Review Laporan')
@section('page-title', 'Review Laporan PKL')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Laporan</h3>
                <a href="{{ route('dosen.laporan.index') }}" class="btn btn-secondary btn-sm float-right">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Judul Laporan</th>
                        <td>{{ $laporan->judul_laporan }}</td>
                    </tr>
                    <tr>
                        <th>Abstrak</th>
                        <td>{{ $laporan->abstrak }}</td>
                    </tr>
                    <tr>
                        <th>Siswa</th>
                        <td>{{ $laporan->kelompokSiswa->siswa->name }} ({{ $laporan->kelompokSiswa->nim }})</td>
                    </tr>
                    <tr>
                        <th>Kelompok</th>
                        <td>{{ $laporan->kelompokSiswa->kelompok->nama_kelompok }} ({{ $laporan->kelompokSiswa->kelompok->perusahaan->nama_perusahaan ?? '-' }})</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($laporan->status == 'diajukan')
                                <span class="badge badge-warning">Diajukan</span>
                            @elseif($laporan->status == 'direview')
                                <span class="badge badge-info">Direview</span>
                            @elseif($laporan->status == 'direvisi')
                                <span class="badge badge-primary">Direvisi</span>
                            @elseif($laporan->status == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($laporan->status == 'ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                            @else
                                <span class="badge badge-secondary">Draft</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Upload</th>
                        <td>{{ $laporan->created_at->format('d F Y H:i') }}</td>
                    </tr>
                    @if($laporan->reviewed_at)
                    <tr>
                        <th>Tanggal Review</th>
                        <td>{{ $laporan->reviewed_at->format('d F Y H:i') }}</td>
                    </tr>
                    @endif
                    @if($laporan->catatan_revisi)
                    <tr>
                        <th>Catatan Revisi</th>
                        <td>{{ $laporan->catatan_revisi }}</td>
                    </tr>
                    @endif
                </table>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-file-pdf"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">File Laporan</span>
                                <span class="info-box-number">
                                    <a href="{{ route('dosen.laporan.download', [$laporan->id, 'laporan']) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @if($laporan->file_presentasi)
                    <div class="col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-file-powerpoint"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">File Presentasi</span>
                                <span class="info-box-number">
                                    <a href="{{ route('dosen.laporan.download', [$laporan->id, 'presentasi']) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Form Review</h3>
            </div>
            <form action="{{ route('dosen.laporan.submit-review', $laporan->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">Pilih Status</option>
                            <option value="setujui">Setujui</option>
                            <option value="revisi">Perlu Revisi</option>
                            <option value="tolak">Tolak</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="catatan_revisi">Catatan Revisi</label>
                        <textarea class="form-control" name="catatan_revisi" id="catatan_revisi" rows="6" placeholder="Masukkan catatan revisi (wajib jika status revisi/tolak)"></textarea>
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