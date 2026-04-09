@extends('layouts.app')

@section('title', 'Ajukan Izin / Sakit')
@section('page-title', 'Form Pengajuan Izin / Sakit')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Pengajuan Izin / Sakit</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.ijin-sakit.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('siswa.ijin-sakit.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Selama masa izin/sakit yang disetujui, Anda <strong>TIDAK perlu mengisi logbook</strong>. 
                        Pengajuan akan direview oleh dosen pembimbing.
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis">Jenis <span class="text-danger">*</span></label>
                                <select class="form-control @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                                    <option value="">Pilih Jenis</option>
                                    <option value="izin" {{ old('jenis') == 'izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="sakit" {{ old('jenis') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                </select>
                                @error('jenis')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                       id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
                                @error('tanggal_mulai')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="tanggal_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                       id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
                                @error('tanggal_selesai')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alasan">Alasan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alasan') is-invalid @enderror" 
                                  id="alasan" name="alasan" rows="4" required>{{ old('alasan') }}</textarea>
                        @error('alasan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Jelaskan alasan izin/sakit secara detail (minimal 10 karakter)</small>
                    </div>

                    <div class="form-group">
                        <label for="bukti_foto">Bukti Foto <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('bukti_foto') is-invalid @enderror" 
                                   id="bukti_foto" name="bukti_foto" accept="image/*" required>
                            <label class="custom-file-label" for="bukti_foto">Pilih file</label>
                        </div>
                        @error('bukti_foto')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">
                            @if(old('jenis') == 'sakit')
                                Upload surat keterangan dokter atau bukti lainnya
                            @else
                                Upload bukti pendukung (surat izin, dll)
                            @endif
                            Format: JPG, PNG. Maks 2MB
                        </small>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Ajukan
                    </button>
                    <a href="{{ route('siswa.ijin-sakit.index') }}" class="btn btn-secondary">
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