@extends('layouts.print')

@section('title', 'Cetak Logbook')
@section('content')
<div class="text-center mb-4">
    <h3>Laporan Kegiatan PKL</h3>
    <p>{{ $logbook->kelompokSiswa?->siswa?->name ?? '-' }} - {{ $logbook->kelompokSiswa?->nim ?? '-' }}</p>
    <p>{{ $logbook->kelompokSiswa?->kelompok?->nama_kelompok ?? '-' }}</p>
    <hr>
</div>

<table class="table table-bordered">
    <tr>
        <th width="150">Tanggal</th>
        <td>{{ $logbook->tanggal->format('d F Y') }}</td>
    </tr>
    <tr>
        <th>Kegiatan</th>
        <td>{{ $logbook->kegiatan }}</td>
    </tr>
    <tr>
        <th>Deskripsi</th>
        <td>{{ $logbook->deskripsi }}</td>
    </tr>
    <tr>
        <th>Jam</th>
        <td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ ucfirst($logbook->status) }}</td>
    </tr>
</table>

<div class="row mt-4">
    <div class="col-6 text-center">
        <p>Mengetahui,</p>
        <p>Dosen Pembimbing</p>
        <br><br><br>
        <p>(________________________)</p>
    </div>
    <div class="col-6 text-center">
        <p>Mengetahui,</p>
        <p>Pembimbing PT</p>
        <br><br><br>
        <p>(________________________)</p>
    </div>
</div>

<script>
    window.print();
</script>
@endsection
