@extends('layouts.app')

@section('title', 'Input Penilaian')
@section('page-title', 'Input Penilaian PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Input Nilai PKL</h3>
                <div class="card-tools">
                   <a href="{{ route('pt.penilaian.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('pt.penilaian.store') }}" method="POST">
                @csrf
                <input type="hidden" name="kelompok_siswa_id" value="{{ $kelompokSiswa->id }}">
                
                <div class="card-body">
                    <!-- Informasi Siswa -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info-circle"></i> Informasi Siswa:</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Nama:</strong> {{ $kelompokSiswa->siswa->name }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>NIM:</strong> {{ $kelompokSiswa->nim }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Kelas:</strong> {{ $kelompokSiswa->kelas }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Prodi:</strong> {{ $kelompokSiswa->prodi }}
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <strong>Kelompok:</strong> {{ $kelompokSiswa->kelompok->nama_kelompok }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Dosen Pembimbing:</strong> {{ $kelompokSiswa->kelompok->dosen->nama_dosen ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-4">Aspek Penilaian</h4>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_kinerja">Nilai Kinerja <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_kinerja') is-invalid @enderror" 
                                           id="nilai_kinerja" name="nilai_kinerja" value="{{ old('nilai_kinerja') }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_kinerja')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Kualitas kerja selama PKL</small>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_kedisiplinan">Nilai Kedisiplinan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_kedisiplinan') is-invalid @enderror" 
                                           id="nilai_kedisiplinan" name="nilai_kedisiplinan" value="{{ old('nilai_kedisiplinan') }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_kedisiplinan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Ketepatan waktu dan kepatuhan</small>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_kerjasama">Nilai Kerjasama <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_kerjasama') is-invalid @enderror" 
                                           id="nilai_kerjasama" name="nilai_kerjasama" value="{{ old('nilai_kerjasama') }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_kerjasama')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Kemampuan bekerja dalam tim</small>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_inisiatif">Nilai Inisiatif <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_inisiatif') is-invalid @enderror" 
                                           id="nilai_inisiatif" name="nilai_inisiatif" value="{{ old('nilai_inisiatif') }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_inisiatif')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Kemampuan berinisiatif</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="catatan">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                          id="catatan" name="catatan" rows="4">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Catatan tambahan untuk mahasiswa (opsional)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-calculator"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Preview Nilai Akhir</span>
                                    <span class="info-box-number" id="nilai-akhir-preview">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Penilaian
                    </button>
                    <a href="{{ route('pt.penilaian.select-siswa') }}" class="btn btn-secondary">
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
    $(function() {
        // Hitung nilai akhir secara real-time
        function hitungNilaiAkhir() {
            var kinerja = parseFloat($('#nilai_kinerja').val()) || 0;
            var disiplin = parseFloat($('#nilai_kedisiplinan').val()) || 0;
            var kerjasama = parseFloat($('#nilai_kerjasama').val()) || 0;
            var inisiatif = parseFloat($('#nilai_inisiatif').val()) || 0;
            
            var total = (kinerja + disiplin + kerjasama + inisiatif) / 4;
            
            if (total > 0) {
                $('#nilai-akhir-preview').text(total.toFixed(2));
            } else {
                $('#nilai-akhir-preview').text('-');
            }
        }
        
        $('#nilai_kinerja, #nilai_kedisiplinan, #nilai_kerjasama, #nilai_inisiatif').on('keyup change', hitungNilaiAkhir);
    });
</script>
@endpush