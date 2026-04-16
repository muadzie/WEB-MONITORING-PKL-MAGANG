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
                    <a href="{{ route('dosen.penilaian.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('dosen.penilaian.update', $penilaian->id) }}" method="POST">
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
                                        <strong>NISN:</strong> {{ $penilaian->kelompokSiswa->nim }}
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nilai_laporan">Nilai Laporan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_laporan') is-invalid @enderror" 
                                           id="nilai_laporan" name="nilai_laporan" value="{{ old('nilai_laporan', $penilaian->nilai_laporan) }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_laporan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nilai_presentasi">Nilai Presentasi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_presentasi') is-invalid @enderror" 
                                           id="nilai_presentasi" name="nilai_presentasi" value="{{ old('nilai_presentasi', $penilaian->nilai_presentasi) }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_presentasi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nilai_sikap">Nilai Sikap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_sikap') is-invalid @enderror" 
                                           id="nilai_sikap" name="nilai_sikap" value="{{ old('nilai_sikap', $penilaian->nilai_sikap) }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_sikap')
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
                    <a href="{{ route('dosen.penilaian.index') }}" class="btn btn-secondary">
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
    // Hitung nilai akhir secara real-time (opsional)
    $(function() {
        function hitungNilaiAkhir() {
            var laporan = parseFloat($('#nilai_laporan').val()) || 0;
            var presentasi = parseFloat($('#nilai_presentasi').val()) || 0;
            var sikap = parseFloat($('#nilai_sikap').val()) || 0;
            var total = (laporan + presentasi + sikap) / 3;
            
            if (total > 0) {
                $('#nilai-akhir-preview').text(total.toFixed(2));
            } else {
                $('#nilai-akhir-preview').text('-');
            }
        }
        
        $('#nilai_laporan, #nilai_presentasi, #nilai_sikap').on('keyup change', hitungNilaiAkhir);
    });
</script>
@endpush