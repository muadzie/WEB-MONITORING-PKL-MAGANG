@extends('layouts.app')

@section('title', 'Edit Laporan')
@section('page-title', 'Edit Laporan PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Laporan PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.laporan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('siswa.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        @if($laporan->status == 'direvisi')
                            <strong>Perhatian:</strong> Laporan Anda memerlukan revisi. Silakan perbaiki sesuai catatan dosen.
                        @else
                            <strong>Perhatian:</strong> Laporan masih dalam status Draft. Anda dapat mengeditnya sebelum disubmit.
                        @endif
                    </div>
                    
                    @if($laporan->catatan_revisi)
                    <div class="alert alert-info">
                        <strong>Catatan Revisi dari Dosen:</strong><br>
                        {{ $laporan->catatan_revisi }}
                    </div>
                    @endif
                    
                    <div class="form-group">
                        <label for="judul_laporan">Judul Laporan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul_laporan') is-invalid @enderror" 
                               id="judul_laporan" name="judul_laporan" value="{{ old('judul_laporan', $laporan->judul_laporan) }}" required>
                        @error('judul_laporan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="abstrak">Abstrak <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('abstrak') is-invalid @enderror" 
                                  id="abstrak" name="abstrak" rows="5" required>{{ old('abstrak', $laporan->abstrak) }}</textarea>
                        @error('abstrak')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_laporan">File Laporan Baru (Kosongkan jika tidak diubah)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('file_laporan') is-invalid @enderror" 
                                           id="file_laporan" name="file_laporan" accept=".pdf,.doc,.docx">
                                    <label class="custom-file-label" for="file_laporan">Pilih file laporan</label>
                                </div>
                                @error('file_laporan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">File saat ini: {{ basename($laporan->file_laporan) }}</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_presentasi">File Presentasi Baru (Kosongkan jika tidak diubah)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('file_presentasi') is-invalid @enderror" 
                                           id="file_presentasi" name="file_presentasi" accept=".pdf,.pptx,.ppt">
                                    <label class="custom-file-label" for="file_presentasi">Pilih file presentasi</label>
                                </div>
                                @error('file_presentasi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                @if($laporan->file_presentasi)
                                    <small class="text-muted">File saat ini: {{ basename($laporan->file_presentasi) }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('siswa.laporan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush