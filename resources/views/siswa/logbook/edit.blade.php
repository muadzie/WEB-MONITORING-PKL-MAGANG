@extends('layouts.app')

@section('title', 'Edit Logbook')
@section('page-title', 'Edit Logbook Kegiatan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Logbook</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.logbook.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('siswa.logbook.update', $logbook->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Logbook hanya dapat diedit jika status masih <strong>Pending</strong>.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal">Tanggal Kegiatan <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                                       id="tanggal" name="tanggal" value="{{ old('tanggal', $logbook->tanggal->format('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('jam_mulai') is-invalid @enderror" 
                                       id="jam_mulai" name="jam_mulai" value="{{ old('jam_mulai', $logbook->jam_mulai) }}" required>
                                @error('jam_mulai')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('jam_selesai') is-invalid @enderror" 
                                       id="jam_selesai" name="jam_selesai" value="{{ old('jam_selesai', $logbook->jam_selesai) }}" required>
                                @error('jam_selesai')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('kegiatan') is-invalid @enderror" 
                               id="kegiatan" name="kegiatan" value="{{ old('kegiatan', $logbook->kegiatan) }}" required>
                        @error('kegiatan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                  id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi', $logbook->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="dokumentasi">Dokumentasi Baru (Kosongkan jika tidak diubah)</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('dokumentasi') is-invalid @enderror" 
                                   id="dokumentasi" name="dokumentasi" accept="image/*">
                            <label class="custom-file-label" for="dokumentasi">Pilih file gambar</label>
                        </div>
                        @error('dokumentasi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    @if($logbook->dokumentasi)
                    <div class="form-group">
                        <label>Dokumentasi Saat Ini:</label><br>
                        <img src="{{ asset('storage/'.$logbook->dokumentasi) }}" class="img-thumbnail" style="max-height: 150px;">
                    </div>
                    @endif
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Logbook
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
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush