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

                    <!-- ========== BAGIAN ALAMAT DENGAN PETA ========== -->
                    <div class="card card-primary mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Lokasi Perusahaan (Pilih di Peta)</h3>
                        </div>
                        <div class="card-body">
                            <!-- Input Alamat -->
                            <div class="form-group">
                                <label for="alamat">Alamat Lengkap <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" 
                                           id="alamat" name="alamat" value="{{ old('alamat') }}" 
                                           placeholder="Contoh: Jl. Sudirman No. 123, Jakarta" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-info" id="search-address-btn" type="button">
                                            <i class="fas fa-search"></i> Cari Alamat
                                        </button>
                                    </div>
                                </div>
                                @error('alamat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Ketik alamat, lalu klik "Cari Alamat" untuk mencari lokasi.</small>
                            </div>

                            <!-- Hidden fields untuk koordinat -->
                            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', '-6.200000') }}">
                            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', '106.816666') }}">

                            <!-- Peta -->
                            <div class="form-group">
                                <label>Pilih Lokasi di Peta</label>
                                <div id="map" style="height: 400px; width: 100%; border-radius: 10px; z-index: 1;"></div>
                                <small class="text-muted mt-2 d-block">
                                    * Geser marker untuk menentukan titik lokasi yang lebih presisi. 
                                    Klik pada peta untuk memindahkan marker.
                                </small>
                            </div>

                            <!-- Informasi Koordinat -->
                            <div class="alert alert-info mt-2" id="coord-info">
                                <i class="fas fa-map-marker-alt"></i> 
                                Koordinat: <span id="coord-display">Belum dipilih (default: Jakarta)</span>
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
                                          id="alamat_text" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
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

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 400px; width: 100%; border-radius: 10px; z-index: 1; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map, marker;
let currentLat = -6.200000;
let currentLng = 106.816666;

// Inisialisasi peta
function initMap() {
    // Cek apakah ada koordinat dari old input
    const oldLat = document.getElementById('latitude').value;
    const oldLng = document.getElementById('longitude').value;
    
    if (oldLat && oldLng && oldLat != '-6.200000') {
        currentLat = parseFloat(oldLat);
        currentLng = parseFloat(oldLng);
    }
    
    map = L.map('map').setView([currentLat, currentLng], 15);
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Marker yang bisa dipindahkan
    marker = L.marker([currentLat, currentLng], { draggable: true }).addTo(map);
    
    // Event ketika marker dipindah
    marker.on('dragend', function(e) {
        const position = marker.getLatLng();
        updateCoordinates(position.lat, position.lng);
        reverseGeocode(position.lat, position.lng);
    });
    
    // Klik pada peta untuk memindahkan marker
    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoordinates(e.latlng.lat, e.latlng.lng);
        reverseGeocode(e.latlng.lat, e.latlng.lng);
    });
    
    // Tampilkan informasi koordinat awal
    updateCoordinatesDisplay(currentLat, currentLng);
}

// Update koordinat di hidden fields
function updateCoordinates(lat, lng) {
    currentLat = lat;
    currentLng = lng;
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
    updateCoordinatesDisplay(lat, lng);
}

function updateCoordinatesDisplay(lat, lng) {
    document.getElementById('coord-display').innerHTML = lat.toFixed(6) + ', ' + lng.toFixed(6);
}

// Reverse geocoding (cari alamat dari koordinat)
function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
        .then(response => response.json())
        .then(data => {
            if (data.display_name) {
                document.getElementById('alamat').value = data.display_name;
                document.getElementById('alamat_text').value = data.display_name;
            }
        })
        .catch(error => console.log('Geocoding error:', error));
}

// Cari alamat dari teks
function searchAddress() {
    const address = document.getElementById('alamat').value;
    if (!address) {
        alert('Silakan isi alamat terlebih dahulu.');
        return;
    }
    
    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lng = parseFloat(data[0].lon);
                
                // Pindahkan peta dan marker
                map.setView([lat, lng], 16);
                marker.setLatLng([lat, lng]);
                
                // Update koordinat
                updateCoordinates(lat, lng);
            } else {
                alert('Alamat tidak ditemukan. Silakan coba alamat yang lebih spesifik.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mencari lokasi.');
        });
}

// Event listeners
document.getElementById('search-address-btn').addEventListener('click', searchAddress);
document.getElementById('alamat').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        searchAddress();
    }
});

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

// Jalankan inisialisasi peta setelah halaman siap
document.addEventListener('DOMContentLoaded', initMap);
</script>
@endpush