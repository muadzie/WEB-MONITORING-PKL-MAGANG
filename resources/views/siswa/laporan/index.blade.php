@extends('layouts.app')

@section('title', 'Laporan PKL')
@section('page-title', 'Laporan PKL')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Laporan PKL</h3>
                <div class="card-tools">
                    @if($kelompokSiswa && (!$laporans || $laporans->count() == 0))
                        <a href="{{ route('siswa.laporan.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Buat Laporan
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(!$kelompokSiswa)
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Anda belum terdaftar dalam kelompok PKL. Silakan hubungi admin atau dosen pembimbing.
                    </div>
                @elseif($laporans && $laporans->count() > 0)
                    @foreach($laporans as $laporan)
                        <div class="card mb-3">
                            <div class="card-header bg-{{ $laporan->status == 'disetujui' ? 'success' : ($laporan->status == 'ditolak' ? 'danger' : 'warning') }}">
                                <h4 class="card-title">{{ $laporan->judul_laporan }}</h4>
                                <div class="card-tools">
                                    <span class="badge badge-light">
                                        {{ ucfirst($laporan->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p><strong>Abstrak:</strong></p>
                                        <p>{{ Str::limit($laporan->abstrak, 200) }}</p>
                                        <p><small class="text-muted">Dibuat: {{ $laporan->created_at->format('d/m/Y H:i') }}</small></p>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="btn-group-vertical w-100">
                                            <a href="{{ route('siswa.laporan.show', $laporan->id) }}" class="btn btn-info btn-block">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            
                                            @if(in_array($laporan->status, ['draft', 'direvisi']))
                                                <a href="{{ route('siswa.laporan.edit', $laporan->id) }}" class="btn btn-warning btn-block">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <form action="{{ route('siswa.laporan.submit', $laporan->id) }}" method="POST" class="d-inline w-100">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('Submit laporan untuk direview?')">
                                                        <i class="fas fa-paper-plane"></i> Submit
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($laporan->status == 'disetujui')
                                                <a href="{{ route('siswa.laporan.download', [$laporan->id, 'laporan']) }}" class="btn btn-success btn-block">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                                @if($laporan->file_presentasi)
                                                    <a href="{{ route('siswa.laporan.download', [$laporan->id, 'presentasi']) }}" class="btn btn-info btn-block">
                                                        <i class="fas fa-file-powerpoint"></i> Presentasi
                                                    </a>
                                                @endif
                                            @endif
                                            
                                            @if($laporan->status == 'draft')
                                                <form action="{{ route('siswa.laporan.destroy', $laporan->id) }}" method="POST" class="d-inline w-100">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-block" onclick="return confirm('Hapus laporan ini?')">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                @if($laporan->catatan_revisi)
                                    <div class="alert alert-info mt-3">
                                        <strong>Catatan Revisi:</strong><br>
                                        {{ $laporan->catatan_revisi }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        Anda belum memiliki laporan PKL. 
                        <a href="{{ route('siswa.laporan.create') }}" class="alert-link">Buat laporan sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection