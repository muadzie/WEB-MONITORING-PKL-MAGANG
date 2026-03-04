@extends('layouts.app')

@section('title', 'Tambah Kelompok PKL')
@section('page-title', 'Tambah Kelompok PKL Baru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Kelompok</h3>
            </div>
            <form action="{{ route('admin.kelompok.store') }}" method="POST" id="formKelompok">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_kelompok">Nama Kelompok <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_kelompok') is-invalid @enderror" 
                                       id="nama_kelompok" name="nama_kelompok" value="{{ old('nama_kelompok') }}" required>
                                @error('nama_kelompok')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dosen_id">Dosen Pembimbing <span class="text-danger">*</span></label>
                                <select class="form-control @error('dosen_id') is-invalid @enderror" id="dosen_id" name="dosen_id" required>
                                    <option value="">Pilih Dosen</option>
                                    @foreach($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                                            {{ $dosen->nama_dosen }} ({{ $dosen->nidn }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('dosen_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="perusahaan_id">Perusahaan/PT <span class="text-danger">*</span></label>
                                <select class="form-control @error('perusahaan_id') is-invalid @enderror" id="perusahaan_id" name="perusahaan_id" required>
                                    <option value="">Pilih Perusahaan</option>
                                    @foreach($perusahaans as $perusahaan)
                                        <option value="{{ $perusahaan->id }}" {{ old('perusahaan_id') == $perusahaan->id ? 'selected' : '' }}>
                                            {{ $perusahaan->nama_perusahaan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('perusahaan_id')
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
                    
                    <hr>
                    <h4>Anggota Kelompok</h4>
                    <p class="text-muted">Minimal 1 anggota, maksimal 5 anggota</p>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-success btn-sm" id="tambahAnggota">
                                <i class="fas fa-plus"></i> Tambah Anggota
                            </button>
                        </div>
                    </div>
                    
                    <div id="daftarAnggota">
                        <div class="row anggota-item mb-2">
                            <div class="col-md-3">
                                <select class="form-control siswa-select" name="siswa_ids[]" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach($siswas as $siswa)
                                        <option value="{{ $siswa->id }}" data-nim="{{ $siswa->nomor_induk }}" data-nama="{{ $siswa->name }}">
                                            {{ $siswa->name }} ({{ $siswa->nomor_induk }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="nims[]" placeholder="NIM" readonly>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="kelass[]" placeholder="Kelas" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="prodis[]" placeholder="Prodi" required>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control" name="status_anggota[]">
                                    <option value="anggota">Anggota</option>
                                    <option value="ketua">Ketua</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm hapus-anggota">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.kelompok.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
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
        // Template anggota
        function getAnggotaTemplate() {
            return `
                <div class="row anggota-item mb-2">
                    <div class="col-md-3">
                        <select class="form-control siswa-select" name="siswa_ids[]" required>
                            <option value="">Pilih Siswa</option>
                            @foreach($siswas as $siswa)
                                <option value="{{ $siswa->id }}" data-nim="{{ $siswa->nomor_induk }}" data-nama="{{ $siswa->name }}">
                                    {{ $siswa->name }} ({{ $siswa->nomor_induk }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="nims[]" placeholder="NIM" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="kelass[]" placeholder="Kelas" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="prodis[]" placeholder="Prodi" required>
                    </div>
                    <div class="col-md-2">
                        <select class="form-control" name="status_anggota[]">
                            <option value="anggota">Anggota</option>
                            <option value="ketua">Ketua</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm hapus-anggota">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `;
        }
        
        // Hitung jumlah anggota
        function countAnggota() {
            return $('.anggota-item').length;
        }
        
        // Tambah anggota
        $('#tambahAnggota').click(function() {
            if (countAnggota() < 5) {
                $('#daftarAnggota').append(getAnggotaTemplate());
            } else {
                alert('Maksimal 5 anggota dalam satu kelompok');
            }
        });
        
        // Hapus anggota
        $(document).on('click', '.hapus-anggota', function() {
            if (countAnggota() > 1) {
                $(this).closest('.anggota-item').remove();
            } else {
                alert('Minimal harus ada 1 anggota');
            }
        });
        
        // Auto fill NIM saat pilih siswa
        $(document).on('change', '.siswa-select', function() {
            var nim = $(this).find(':selected').data('nim');
            $(this).closest('.row').find('input[name="nims[]"]').val(nim);
        });
        
        // Validasi sebelum submit
        $('#formKelompok').submit(function(e) {
            var ketuaCount = 0;
            $('select[name="status_anggota[]"]').each(function() {
                if ($(this).val() === 'ketua') ketuaCount++;
            });
            
            if (ketuaCount === 0) {
                e.preventDefault();
                alert('Pilih salah satu anggota sebagai ketua kelompok');
            } else if (ketuaCount > 1) {
                e.preventDefault();
                alert('Hanya boleh ada satu ketua kelompok');
            }
        });
    });
</script>
@endpush