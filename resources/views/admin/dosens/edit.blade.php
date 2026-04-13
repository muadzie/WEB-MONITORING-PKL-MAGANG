@extends('layouts.app')

@section('title', 'Edit Guru')
@section('page-title', 'Edit Data Guru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Edit Guru</h3>
            </div>
            <form action="{{ route('admin.dosens.update', $dosen->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nidn">NISN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nidn') is-invalid @enderror" 
                                       id="nidn" name="nidn" value="{{ old('nidn', $dosen->nidn) }}" required>
                                @error('nidn')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_dosen">Nama Guru <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_dosen') is-invalid @enderror" 
                                       id="nama_dosen" name="nama_dosen" value="{{ old('nama_dosen', $dosen->nama_dosen) }}" required>
                                @error('nama_dosen')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gelar_belakang">Gelar Belakang</label>
                                <input type="text" class="form-control @error('gelar_belakang') is-invalid @enderror" 
                                       id="gelar_belakang" name="gelar_belakang" value="{{ old('gelar_belakang', $dosen->gelar_belakang) }}">
                                @error('gelar_belakang')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telepon">Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                       id="telepon" name="telepon" value="{{ old('telepon', $dosen->telepon) }}" required>
                                @error('telepon')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $dosen->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jurusan">Jurusan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" 
                                       id="jurusan" name="jurusan" value="{{ old('jurusan', $dosen->jurusan) }}" required>
                                @error('jurusan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="is_active">Status</label>
                                <select class="form-control @error('is_active') is-invalid @enderror" id="is_active" name="is_active">
                                    <option value="1" {{ $dosen->is_active ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ !$dosen->is_active ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('is_active')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('foto') is-invalid @enderror" 
                                           id="foto" name="foto" accept="image/*">
                                    <label class="custom-file-label" for="foto">Pilih file</label>
                                </div>
                                @error('foto')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Foto Saat Ini</label><br>
                            <img src="{{ $dosen->foto ? asset('storage/'.$dosen->foto) : asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}" 
                                 class="img-circle img-size-64" alt="Dosen Image">
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('admin.dosens.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                 <div class="form-group">
        <label for="foto">Foto Profil</label>
        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
        @if($dosen->foto)
            <img src="{{ asset('storage/'.$dosen->foto) }}" class="mt-2" style="height: 50px;">
        @endif
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