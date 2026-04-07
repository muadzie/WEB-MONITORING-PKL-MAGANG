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
                        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Preview Logbook -->
                <div class="callout callout-info">
                    <h5><i class="fas fa-info-circle"></i> Informasi Logbook:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Tanggal:</strong> {{ $logbook->tanggal->format('d F Y') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Jam:</strong> {{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}
                        </div>
                    </div>
                </div>

                <!-- Informasi Siswa -->
                <div class="callout callout-success">
                    <h5><i class="fas fa-user-graduate"></i> Informasi Siswa:</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <strong>Nama:</strong> {{ $logbook->kelompokSiswa->siswa->name }}
                        </div>
                        <div class="col-md-4">
                            <strong>NIM:</strong> {{ $logbook->kelompokSiswa->nim }}
                        </div>
                        <div class="col-md-4">
                            <strong>Kelas:</strong> {{ $logbook->kelompokSiswa->kelas }}
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Kelompok:</strong> {{ $logbook->kelompokSiswa->kelompok->nama_kelompok }}
                        </div>
                        <div class="col-md-6">
                            <strong>Perusahaan:</strong> {{ $logbook->kelompokSiswa->kelompok->perusahaan->nama_perusahaan ?? '-' }}
                        </div>
                    </div>
                </div>

                <!-- Detail Kegiatan -->
                <div class="callout callout-warning">
                    <h5><i class="fas fa-tasks"></i> Detail Kegiatan:</h5>
                    <p><strong>Kegiatan:</strong> {{ $logbook->kegiatan }}</p>
                    <p><strong>Deskripsi:</strong></p>
                    <div class="well well-sm" style="background: #f9f9f9; padding: 15px; border-radius: 5px;">
                        {{ $logbook->deskripsi }}
                    </div>
                </div>

               
      <!-- Dokumentasi -->
@if($logbook->dokumentasi)
    @php
        // Pastikan path benar
        $filePath = 'storage/' . ltrim($logbook->dokumentasi, '/');
        $fullPath = storage_path('app/public/' . str_replace('storage/', '', $logbook->dokumentasi));
        $fileExists = file_exists($fullPath);
    @endphp
    
    <div class="callout callout-default">
        <h5><i class="fas fa-camera"></i> Dokumentasi:</h5>
        
        @if($fileExists)
            <div class="text-center">
                <img src="{{ asset($filePath) }}" 
                     class="img-fluid img-thumbnail" 
                     style="max-height: 300px; cursor: pointer;"
                     onclick="window.open(this.src)">
                <br>
                <div class="btn-group mt-2">
                    <a href="{{ asset($filePath) }}" class="btn btn-primary btn-sm" target="_blank">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                    <a href="{{ asset($filePath) }}" class="btn btn-success btn-sm" download>
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>File tidak ditemukan!</strong><br>
                Path: {{ $logbook->dokumentasi }}<br>
                <small>Silakan upload ulang dokumentasi.</small>
            </div>
        @endif
    </div>
@else
    <div class="callout callout-default">
        <h5><i class="fas fa-camera"></i> Dokumentasi:</h5>
        <p class="text-muted">Tidak ada dokumentasi yang diunggah.</p>
    </div>
@endif

                <!-- Status Review -->
                <div class="callout callout-default">
                    <h5><i class="fas fa-check-circle"></i> Status Review:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Status PT:</strong><br>
                            @if($logbook->approved_by_pt)
                                <span class="badge badge-success">Sudah direview PT</span>
                                @if($logbook->catatan_pt)
                                    <p class="mt-2"><small>Catatan PT: {{ $logbook->catatan_pt }}</small></p>
                                @endif
                            @else
                                <span class="badge badge-warning">Belum direview PT</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Status Dosen:</strong><br>
                            @if($logbook->approved_by_dosen)
                                <span class="badge badge-success">Sudah direview Dosen</span>
                                @if($logbook->catatan_dosen)
                                    <p class="mt-2"><small>Catatan Dosen: {{ $logbook->catatan_dosen }}</small></p>
                                @endif
                            @else
                                <span class="badge badge-danger">Belum direview Dosen</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Form Review Dosen -->
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clipboard-list"></i> Form Review Dosen
                </h3>
            </div>
            <form action="{{ route('dosen.logbook.approve', $logbook->id) }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Status Review</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action" 
                                   id="approve" value="approve" checked>
                            <label class="form-check-label text-success" for="approve">
                                <i class="fas fa-check-circle"></i> Setujui
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="action" 
                                   id="reject" value="reject">
                            <label class="form-check-label text-danger" for="reject">
                                <i class="fas fa-times-circle"></i> Tolak
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="catatan">Catatan Review</label>
                        <textarea class="form-control" name="catatan" id="catatan" 
                                  rows="5" placeholder="Masukkan catatan untuk siswa (opsional)"></textarea>
                        <small class="text-muted">Catatan akan dikirimkan ke siswa sebagai notifikasi</small>
                    </div>

                    <hr>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Informasi:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Logbook yang sudah direview tidak dapat diubah</li>
                            <li>Review akan mengirim notifikasi ke siswa</li>
                            <li>Jika ditolak, siswa harus merevisi logbook</li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-paper-plane"></i> Kirim Review
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Informasi Tambahan -->
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">
                    <i class="fas fa-lightbulb"></i> Tips Review
                </h3>
            </div>
            <div class="card-body">
                <p><i class="fas fa-check-circle text-success"></i> <strong>Setujui</strong> jika kegiatan sesuai dan lengkap.</p>
                <p><i class="fas fa-times-circle text-danger"></i> <strong>Tolak</strong> jika kegiatan tidak sesuai atau kurang lengkap.</p>
                <p><i class="fas fa-comment"></i> Berikan catatan yang jelas agar siswa bisa memperbaiki.</p>
                <p><i class="fas fa-clock"></i> Review yang cepat membantu siswa memantau progress.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .callout {
        padding: 15px;
        margin-bottom: 20px;
        border-left: 5px solid;
        border-radius: 5px;
    }
    .callout-info { border-left-color: #17a2b8; background: #e3f2fd; }
    .callout-success { border-left-color: #28a745; background: #e8f5e9; }
    .callout-warning { border-left-color: #ffc107; background: #fff3e0; }
    .well {
        background: #f5f5f5;
        padding: 15px;
        border-radius: 5px;
    }
</style>
@endpush