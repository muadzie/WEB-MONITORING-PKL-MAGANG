@extends('layouts.app')

@section('title', 'Tambah Dosen')
@section('page-title', 'Tambah Dosen Baru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Dosen</h3>
            </div>
            <form action="{{ route('admin.dosens.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nidn">NIDN <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nidn') is-invalid @enderror" 
                                       id="nidn" name="nidn" value="{{ old('nidn') }}" required>
                                @error('nidn')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_dosen">Nama Dosen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_dosen') is-invalid @enderror" 
                                       id="nama_dosen" name="nama_dosen" value="{{ old('nama_dosen') }}" required>
                                @error('nama_dosen')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gelar_depan">Gelar Depan</label>
                                <input type="text" class="form-control @error('gelar_depan') is-invalid @enderror" 
                                       id="gelar_depan" name="gelar_depan" value="{{ old('gelar_depan') }}">
                                @error('gelar_depan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="gelar_belakang">Gelar Belakang</label>
                                <input type="text" class="form-control @error('gelar_belakang') is-invalid @enderror" 
                                       id="gelar_belakang" name="gelar_belakang" value="{{ old('gelar_belakang') }}">
                                @error('gelar_belakang')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="telepon">Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                       id="telepon" name="telepon" value="{{ old('telepon') }}" required>
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
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jurusan">Jurusan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" 
                                       id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required>
                                @error('jurusan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fakultas">Fakultas <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('fakultas') is-invalid @enderror" 
                                       id="fakultas" name="fakultas" value="{{ old('fakultas') }}" required>
                                @error('fakultas')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
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
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="create_user" name="create_user" value="1" {{ old('create_user') ? 'checked' : '' }}>
                            <label class="form-check-label" for="create_user">
                                Buatkan akun login untuk dosen ini
                            </label>
                        </div>
                    </div>
                    
                    <div id="userAccountFields" style="display: {{ old('create_user') ? 'block' : 'none' }};">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    @error('password')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.dosens.index') }}" class="btn btn-secondary">
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
        // Toggle user account fields
        $('#create_user').change(function() {
            if ($(this).is(':checked')) {
                $('#userAccountFields').slideDown();
                $('#password').prop('required', true);
                $('#password_confirmation').prop('required', true);
            } else {
                $('#userAccountFields').slideUp();
                $('#password').prop('required', false);
                $('#password_confirmation').prop('required', false);
            }
        });
        
        // File input preview
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>
@endpush