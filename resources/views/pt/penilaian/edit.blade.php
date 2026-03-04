@extends('layouts.app')

@section('title', 'Edit Penilaian')
@section('page-title', 'Edit Penilaian PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Nilai PKL</h3>
                <div class="card-tools">
                    <a href="{{ route('pt.penilaian.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('pt.penilaian.update', $penilaian->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    <!-- Informasi Siswa -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="callout callout-info">
                                <h5><i class="fas fa-info-circle"></i> Informasi Siswa:</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Nama:</strong> {{ $penilaian->kelompokSiswa->siswa->name }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>NIM:</strong> {{ $penilaian->kelompokSiswa->nim }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Kelas:</strong> {{ $penilaian->kelompokSiswa->kelas }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Prodi:</strong> {{ $penilaian->kelompokSiswa->prodi }}
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
                                           id="nilai_kinerja" name="nilai_kinerja" value="{{ old('nilai_kinerja', $penilaian->nilai_kinerja) }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_kinerja')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_kedisiplinan">Nilai Kedisiplinan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_kedisiplinan') is-invalid @enderror" 
                                           id="nilai_kedisiplinan" name="nilai_kedisiplinan" value="{{ old('nilai_kedisiplinan', $penilaian->nilai_kedisiplinan) }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_kedisiplinan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_kerjasama">Nilai Kerjasama <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_kerjasama') is-invalid @enderror" 
                                           id="nilai_kerjasama" name="nilai_kerjasama" value="{{ old('nilai_kerjasama', $penilaian->nilai_kerjasama) }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_kerjasama')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_inisiatif">Nilai Inisiatif <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_inisiatif') is-invalid @enderror" 
                                           id="nilai_inisiatif" name="nilai_inisiatif" value="{{ old('nilai_inisiatif', $penilaian->nilai_inisiatif) }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_inisiatif')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="catatan">Catatan</label>
                                <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                          id="catatan" name="catatan" rows="4">{{ old('catatan', $penilaian->catatan) }}</textarea>
                                @error('catatan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box bg-info">
                                <span class="info-box-icon"><i class="fas fa-calculator"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Nilai Akhir Saat Ini</span>
                                    <span class="info-box-number">{{ $penilaian->nilai_akhir ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Penilaian
                    </button>
                    <a href="{{ route('pt.penilaian.index') }}" class="btn btn-secondary">
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
            $('#nilai-akhir-preview').text(total.toFixed(2));
        }
        
        $('#nilai_kinerja, #nilai_kedisiplinan, #nilai_kerjasama, #nilai_inisiatif').on('keyup change', hitungNilaiAkhir);
    });
</script>
@endpush