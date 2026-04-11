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
                    <a href="{{ route('dosen.penilaian.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <form action="{{ route('dosen.penilaian.store') }}" method="POST">
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
                                        <strong>Perusahaan:</strong> {{ $kelompokSiswa->kelompok->perusahaan->nama_perusahaan ?? '-' }}
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
                                           id="nilai_laporan" name="nilai_laporan" value="{{ old('nilai_laporan') }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_laporan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Nilai untuk kualitas laporan PKL</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nilai_presentasi">Nilai Presentasi <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_presentasi') is-invalid @enderror" 
                                           id="nilai_presentasi" name="nilai_presentasi" value="{{ old('nilai_presentasi') }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_presentasi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Nilai untuk presentasi/sidang PKL</small>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nilai_sikap">Nilai Sikap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('nilai_sikap') is-invalid @enderror" 
                                           id="nilai_sikap" name="nilai_sikap" value="{{ old('nilai_sikap') }}" 
                                           min="0" max="100" step="0.01" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">/100</span>
                                    </div>
                                </div>
                                @error('nilai_sikap')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Nilai untuk sikap selama PKL</small>
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
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Penilaian
                    </button>
                    <a href="{{ route('dosen.penilaian.select-siswa') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection