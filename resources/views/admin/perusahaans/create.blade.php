@extends('layouts.app')

@section('title', 'Tambah Perusahaan')
@section('page-title', 'Tambah Perusahaan Baru')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Tambah Perusahaan</h3>
            </div>
            <form action="{{ route('admin.perusahaans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_perusahaan">Nama Perusahaan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" 
                                       id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required>
                                @error('nama_perusahaan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bidang_usaha">Bidang Usaha <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('bidang_usaha') is-invalid @enderror" 
                                       id="bidang_usaha" name="bidang_usaha" value="{{ old('bidang_usaha') }}" required>
                                @error('bidang_usaha')
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
                                <label for="kontak_person">Nama Kontak Person <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('kontak_person') is-invalid @enderror" 
                                       id="kontak_person" name="kontak_person" value="{{ old('kontak_person') }}" required>
                                @error('kontak_person')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jabatan_kontak">Jabatan Kontak Person <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('jabatan_kontak') is-invalid @enderror" 
                                       id="jabatan_kontak" name="jabatan_kontak" value="{{ old('jabatan_kontak') }}" required>
                                @error('jabatan_kontak')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Perusahaan</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="logo">Logo Perusahaan</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('logo') is-invalid @enderror" 
                                           id="logo" name="logo" accept="image/*">
                                    <label class="custom-file-label" for="logo">Pilih file</label>
                                </div>
                                @error('logo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="create_user" name="create_user" value="1" {{ old('create_user') ? 'checked' : '' }}>
                            <label class="form-check-label" for="create_user">
                                Buatkan akun login untuk perusahaan ini
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
                    <a href="{{ route('admin.perusahaans.index') }}" class="btn btn-secondary">
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