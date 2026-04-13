@extends('layouts.app')

@section('title', 'Absensi PKL')
@section('page-title', 'Absensi PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            <strong>Lokasi Magang:</strong> {{ $perusahaan->nama_perusahaan }}<br>
            <strong>Alamat:</strong> {{ $perusahaan->alamat }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">Absen Hari Ini</h3>
            </div>
            <div class="card-body text-center">
                @if(isset($isExpired) && $isExpired)
                    <div class="alert alert-danger">
                        <i class="fas fa-ban fa-3x"></i>
                        <h4>Masa PKL Telah Berakhir</h4>
                        <p>Anda tidak dapat melakukan absensi karena periode PKL sudah selesai.</p>
                    </div>
                @elseif($todayAbsen)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle fa-3x"></i>
                        <h4>Anda sudah absen hari ini</h4>
                        <p><strong>Jam Masuk:</strong> {{ $todayAbsen->jam_masuk ? \Carbon\Carbon::parse($todayAbsen->jam_masuk)->format('H:i:s') : '-' }}</p>
                        @if($todayAbsen->jam_keluar)
                            <p><strong>Jam Keluar:</strong> {{ \Carbon\Carbon::parse($todayAbsen->jam_keluar)->format('H:i:s') }}</p>
                        @else
                            <button id="btnAbsenKeluar" class="btn btn-warning mt-3">
                                <i class="fas fa-sign-out-alt"></i> Absen Keluar
                            </button>
                        @endif
                    </div>
                @else
                    <div id="absenForm">
                        <div id="map" style="height: 300px; margin-bottom: 15px; border-radius: 10px;"></div>
                        
                        <div id="location-status" class="alert alert-secondary">
                            <i class="fas fa-spinner fa-spin"></i> Mendeteksi lokasi Anda...
                        </div>
                        
                        <div id="distance-info" class="mb-3"></div>
                        
                        <button id="btnAbsen" class="btn btn-success btn-lg" disabled>
                            <i class="fas fa-fingerprint"></i> Absen Masuk
                        </button>
                        <p class="text-muted mt-3">
                            <small>Pastikan Anda berada di radius 100 meter dari lokasi magang</small>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Absensi</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absensis as $absen)
                            <tr>
                                <td>{{ $absen->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $absen->jam_masuk ? \Carbon\Carbon::parse($absen->jam_masuk)->format('H:i:s') : '-' }}</td>
                                <td>{{ $absen->jam_keluar ? \Carbon\Carbon::parse($absen->jam_keluar)->format('H:i:s') : '-' }}</td>
                                <td>
                                    @if($absen->status == 'hadir')
                                        <span class="badge badge-success">Hadir</span>
                                    @elseif($absen->status == 'izin')
                                        <span class="badge badge-info">Izin</span>
                                    @elseif($absen->status == 'sakit')
                                        <span class="badge badge-warning">Sakit</span>
                                    @else
                                        <span class="badge badge-danger">Alpha</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada riwayat absensi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $absensis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 300px; border-radius: 10px; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map, userMarker, companyMarker, circle;
let userLocation = null;
let distance = null;
const RADIUS = 100; // meter

// Koordinat perusahaan (dari database)
const companyLat = {{ $perusahaan->latitude ?? -6.200000 }};
const companyLng = {{ $perusahaan->longitude ?? 106.816666 }};

// Apakah PKL sudah berakhir (dari server)
const isExpired = {{ isset($isExpired) && $isExpired ? 'true' : 'false' }};

// Jika sudah expired, tidak perlu inisialisasi map dan tombol
if (!isExpired) {
    // Fungsi hitung jarak (Haversine formula)
    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // meter
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = lat2 * Math.PI / 180;
        const Δφ = (lat2 - lat1) * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        return R * c;
    }

    function initMap() {
        map = L.map('map').setView([companyLat, companyLng], 16);
        
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        // Marker perusahaan
        companyMarker = L.marker([companyLat, companyLng])
            .addTo(map)
            .bindPopup('<strong>Lokasi Magang</strong><br>{{ $perusahaan->nama_perusahaan }}')
            .openPopup();
        
        // Circle radius 100 meter
        circle = L.circle([companyLat, companyLng], {
            color: '#ff4444',
            fillColor: '#ff4444',
            fillOpacity: 0.1,
            radius: RADIUS
        }).addTo(map);
        
        // Cek lokasi pengguna
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;
                
                userLocation = { lat: userLat, lng: userLng };
                distance = calculateDistance(userLat, userLng, companyLat, companyLng);
                
                updateLocationStatus(distance);
                
                userMarker = L.marker([userLat, userLng])
                    .addTo(map)
                    .bindPopup('<strong>Lokasi Anda</strong><br>Jarak: ' + distance.toFixed(2) + ' meter')
                    .openPopup();
                
                const bounds = L.latLngBounds([[companyLat, companyLng], [userLat, userLng]]);
                map.fitBounds(bounds, { padding: [50, 50] });
                
            }, function(error) {
                document.getElementById('location-status').innerHTML = 
                    '<i class="fas fa-exclamation-triangle text-warning"></i> ' +
                    'Tidak dapat mendeteksi lokasi Anda. Pastikan GPS diaktifkan.';
            });
        } else {
            document.getElementById('location-status').innerHTML = 
                '<i class="fas fa-exclamation-triangle text-danger"></i> ' +
                'Browser Anda tidak mendukung GPS.';
        }
    }

    function updateLocationStatus(distance) {
        const statusDiv = document.getElementById('location-status');
        const distanceDiv = document.getElementById('distance-info');
        const btnAbsen = document.getElementById('btnAbsen');
        
        distanceDiv.innerHTML = '<strong>Jarak Anda dari lokasi magang:</strong> ' + distance.toFixed(2) + ' meter';
        
        if (distance <= RADIUS) {
            statusDiv.innerHTML = '<i class="fas fa-check-circle text-success"></i> ' +
                '✅ Anda berada dalam radius magang (' + distance.toFixed(2) + ' meter). Silakan absen.';
            statusDiv.className = 'alert alert-success';
            btnAbsen.disabled = false;
        } else {
            statusDiv.innerHTML = '<i class="fas fa-times-circle text-danger"></i> ' +
                '❌ Anda berada di luar radius magang (' + distance.toFixed(2) + ' meter). ' +
                'Harap mendekat ke lokasi (maksimal 100 meter).';
            statusDiv.className = 'alert alert-danger';
            btnAbsen.disabled = true;
        }
    }

    // Tombol Absen Masuk
    document.getElementById('btnAbsen')?.addEventListener('click', function() {
        if (!userLocation) {
            alert('Lokasi tidak terdeteksi. Silakan refresh halaman.');
            return;
        }
        
        if (distance > RADIUS) {
            alert('Anda berada di luar radius magang. Harap mendekat ke lokasi.');
            return;
        }
        
        fetch('{{ route("siswa.absensi.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                latitude: userLocation.lat,
                longitude: userLocation.lng
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'Absen masuk berhasil!');
                location.reload();
            } else {
                alert(data.error || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });

    // Tombol Absen Keluar
    document.getElementById('btnAbsenKeluar')?.addEventListener('click', function() {
        fetch('{{ route("siswa.absensi.keluar") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'Absen keluar berhasil!');
                location.reload();
            } else {
                alert(data.error || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });

    // Jalankan inisialisasi peta
    initMap();
} else {
    // Jika PKL sudah berakhir, tampilkan pesan di map container (opsional)
    document.getElementById('map')?.remove(); // atau sembunyikan
    document.getElementById('absenForm').innerHTML = '<div class="alert alert-danger">Masa PKL telah berakhir, absen tidak dapat dilakukan.</div>';
}
</script>
@endpush