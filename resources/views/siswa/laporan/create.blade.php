@extends('layouts.app')

@section('title', 'Buat Laporan PKL')
@section('page-title', 'Buat Laporan PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Buat Laporan PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.laporan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('siswa.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        Laporan akan disimpan sebagai <strong>Draft</strong>. Anda dapat mengeditnya sebelum disubmit ke dosen pembimbing.
                    </div>
                    
                    <div class="form-group">
                        <label for="judul_laporan">Judul Laporan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('judul_laporan') is-invalid @enderror" 
                               id="judul_laporan" name="judul_laporan" value="{{ old('judul_laporan') }}" 
                               placeholder="Contoh: Laporan Praktek Kerja Lapangan di PT. ABC" required>
                        @error('judul_laporan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="abstrak">Abstrak <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('abstrak') is-invalid @enderror" 
                                  id="abstrak" name="abstrak" rows="5" 
                                  placeholder="Tulis ringkasan laporan Anda..." required>{{ old('abstrak') }}</textarea>
                        @error('abstrak')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Minimal 50 karakter, maksimal 500 karakter</small>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_laporan">File Laporan (PDF) <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('file_laporan') is-invalid @enderror" 
                                           id="file_laporan" name="file_laporan" accept=".pdf,.doc,.docx" required>
                                    <label class="custom-file-label" for="file_laporan">Pilih file laporan</label>
                                </div>
                                @error('file_laporan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Format: PDF, DOC, DOCX. Maksimal 10MB</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_presentasi">File Presentasi (Opsional)</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('file_presentasi') is-invalid @enderror" 
                                           id="file_presentasi" name="file_presentasi" accept=".pdf,.pptx,.ppt">
                                    <label class="custom-file-label" for="file_presentasi">Pilih file presentasi</label>
                                </div>
                                @error('file_presentasi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Format: PDF, PPT, PPTX. Maksimal 20MB</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Pastikan file laporan Anda sudah benar sebelum diupload. Laporan yang sudah disubmit tidak dapat diedit sebelum mendapat catatan revisi dari dosen.
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan sebagai Draft
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