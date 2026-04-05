@extends('layouts.app')

@section('title', 'Absensi PKL')
@section('page-title', 'Absensi PKL')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> 
            Lokasi magang Anda: <strong>{{ $perusahaan->nama_perusahaan }}</strong><br>
            Alamat: {{ $perusahaan->alamat }}
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
                @if($todayAbsen)
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle fa-3x"></i>
                        <h4>Anda sudah absen hari ini</h4>
                        <p>Jam Masuk: {{ $todayAbsen->jam_masuk ? \Carbon\Carbon::parse($todayAbsen->jam_masuk)->format('H:i:s') : '-' }}</p>
                        @if($todayAbsen->jam_keluar)
                            <p>Jam Keluar: {{ \Carbon\Carbon::parse($todayAbsen->jam_keluar)->format('H:i:s') }}</p>
                        @else
                            <button id="btnAbsenKeluar" class="btn btn-warning mt-3">
                                <i class="fas fa-sign-out-alt"></i> Absen Keluar
                            </button>
                        @endif
                    </div>
                @else
                    <div id="absenForm">
                        <div id="map" style="height: 300px; margin-bottom: 15px;"></div>
                        <button id="btnAbsen" class="btn btn-success btn-lg">
                            <i class="fas fa-fingerprint"></i> Absen Masuk
                        </button>
                        <p class="text-muted mt-3">
                            <small>Pastikan Anda berada di lokasi magang (radius 100 meter)</small>
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
                        @foreach($absensis as $absen)
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
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $absensis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" rel="stylesheet">
<style>
    #map { border-radius: 10px; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let map, userMarker, companyMarker;

function initMap() {
    map = L.map('map').setView([{{ $perusahaan->latitude ?? -6.2 }}, {{ $perusahaan->longitude ?? 106.8 }}], 15);
    
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OSM</a>'
    }).addTo(map);
    
    // Marker perusahaan
    companyMarker = L.marker([{{ $perusahaan->latitude ?? -6.2 }}, {{ $perusahaan->longitude ?? 106.8 }}])
        .addTo(map)
        .bindPopup('Lokasi Magang: {{ $perusahaan->nama_perusahaan }}')
        .openPopup();
    
    // Circle radius 100m
    L.circle([{{ $perusahaan->latitude ?? -6.2 }}, {{ $perusahaan->longitude ?? 106.8 }}], {
        color: 'blue',
        fillColor: '#30f',
        fillOpacity: 0.1,
        radius: 100
    }).addTo(map);
    
    // Cek lokasi user
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const userLat = position.coords.latitude;
            const userLng = position.coords.longitude;
            
            userMarker = L.marker([userLat, userLng])
                .addTo(map)
                .bindPopup('Lokasi Anda')
                .openPopup();
            
            // Simpan lokasi ke form
            window.userLocation = { lat: userLat, lng: userLng };
            window.mapFitted = true;
        });
    }
}

document.getElementById('btnAbsen')?.addEventListener('click', function() {
    if (!window.userLocation) {
        alert('Mohon izinkan akses lokasi');
        return;
    }
    
    fetch('{{ route("siswa.absensi.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            latitude: window.userLocation.lat,
            longitude: window.userLocation.lng
        })
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if (data.success) location.reload();
    });
});

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
        alert(data.message);
        if (data.success) location.reload();
    });
});

initMap();
</script>
@endpush