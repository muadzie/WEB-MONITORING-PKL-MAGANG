@extends('layouts.app')

@section('title', 'Tambah Logbook')
@section('page-title', 'Tambah Logbook Kegiatan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Logbook</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.logbook.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('siswa.logbook.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Kegiatan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                       id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                       id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', '08:00') }}" required>
                                @error('jam_mulai')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" 
                                       id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', '17:00') }}" required>
                                @error('jam_selesai')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kegiatan') is-invalid @enderror" 
                               id="kegiatan" name="kegiatan" value="{{ old('kegiatan') }}" 
                               placeholder="Contoh: Membuat program, Meeting dengan pembimbing, dll" required>
                        @error('kegiatan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="5" 
                                  placeholder="Jelaskan detail kegiatan yang dilakukan..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Minimal 10 karakter, jelaskan kegiatan secara detail</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="dokumentasi">Dokumentasi (Foto)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('dokumentasi') is-invalid @enderror" 
                                   id="dokumentasi" name="dokumentasi" accept="image/*">
                            <label class="custom-file-label" for="dokumentasi">Pilih file gambar</label>
                        </div>
                        @error('dokumentasi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG. Maksimal 2MB. (Opsional)</small>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        Logbook yang sudah dikirim akan direview oleh dosen pembimbing dan pembimbing PT.
                        Status logbook akan berubah menjadi "Pending" sampai direview.
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Logbook
                    </button>
                    <a href="{{ route('siswa.logbook.index') }}" class="btn btn-secondary">
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
    // Preview file name
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    
    // Validasi jam selesai harus setelah jam mulai
    $('#jam_mulai, #jam_selesai').on('change', function() {
        var jamMulai = $('#jam_mulai').val();
        var jamSelesai = $('#jam_selesai').val();
        
        if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
            alert('Jam selesai harus setelah jam mulai!');
            $('#jam_selesai').val('');
        }
    });
</script>
@endpush