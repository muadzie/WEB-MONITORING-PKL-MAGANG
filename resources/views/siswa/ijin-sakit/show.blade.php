@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan Izin / Sakit')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Pengajuan</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.ijin-sakit.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Jenis</th>
                                <td>
                                    @if($ijinSakit->jenis == 'izin')
                                        <span class="badge badge-info">Izin</span>
                                    @else
                                        <span class="badge badge-warning">Sakit</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Periode</th>
                                <td>{{ \Carbon\Carbon::parse($ijinSakit->tanggal_mulai)->format('d F Y') }} - {{ \Carbon\Carbon::parse($ijinSakit->tanggal_selesai)->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Alasan</th>
                                <td>{{ $ijinSakit->alasan }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($ijinSakit->status == 'pending')
                                        <span class="badge badge-warning">Menunggu Persetujuan</span>
                                    @elseif($ijinSakit->status == 'disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @if($ijinSakit->catatan_dosen)
                            <tr>
                                <th>Catatan Dosen</th>
                                <td>{{ $ijinSakit->catatan_dosen }}</td>
                            </tr>
                            @endif
                            @if($ijinSakit->approved_at)
                            <tr>
                                <th>Tanggal Diproses</th>
                                <td>{{ \Carbon\Carbon::parse($ijinSakit->approved_at)->format('d F Y H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h5 class="card-title">Bukti Foto</h5>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/'.$ijinSakit->bukti_foto) }}" class="img-fluid" style="max-height: 300px;">
                                <br>
                                <a href="{{ asset('storage/'.$ijinSakit->bukti_foto) }}" download class="btn btn-primary mt-3">
                                    <i class="fas fa-download"></i> Download Bukti
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection