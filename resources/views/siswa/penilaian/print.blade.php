@extends('layouts.print')

@section('title', 'Cetak Nilai PKL')
@section('content')
<div class="text-center mb-4">
    <h3>Hasil Penilaian PKL</h3>
    <p>{{ $penilaian->siswa?->name ?? '-' }} - {{ $penilaian->siswa?->nim ?? '-' }}</p>
    <hr>
</div>

<table class="table table-bordered">
    <tr>
        <th width="200">Komponen Penilaian</th>
        <th>Nilai</th>
    </tr>
    @if(isset($penilaian->nilai_laporan))
    <tr>
        <td>Nilai Laporan</td>
        <td>{{ $penilaian->nilai_laporan }}</td>
    </tr>
    @endif
    @if(isset($penilaian->nilai_presentasi))
    <tr>
        <td>Nilai Presentasi</td>
        <td>{{ $penilaian->nilai_presentasi }}</td>
    </tr>
    @endif
    @if(isset($penilaian->nilai_sikap))
    <tr>
        <td>Nilai Sikap</td>
        <td>{{ $penilaian->nilai_sikap }}</td>
    </tr>
    @endif
    @if(isset($penilaian->nilai_kinerja))
    <tr>
        <td>Nilai Kinerja</td>
        <td>{{ $penilaian->nilai_kinerja }}</td>
    </tr>
    @endif
    @if(isset($penilaian->nilai_kedisiplinan))
    <tr>
        <td>Nilai Kedisiplinan</td>
        <td>{{ $penilaian->nilai_kedisiplinan }}</td>
    </tr>
    @endif
    @if(isset($penilaian->nilai_kerjasama))
    <tr>
        <td>Nilai Kerjasama</td>
        <td>{{ $penilaian->nilai_kerjasama }}</td>
    </tr>
    @endif
    @if(isset($penilaian->nilai_inisiatif))
    <tr>
        <td>Nilai Inisiatif</td>
        <td>{{ $penilaian->nilai_inisiatif }}</td>
    </tr>
    @endif
    <tr class="table-active">
        <th>Nilai Akhir</th>
        <th>{{ $penilaian->nilai_akhir ?? '-' }}</th>
    </tr>
</table>

@if(isset($penilaian->catatan))
<div class="card mt-3">
    <div class="card-header">
        <h5>Catatan</h5>
    </div>
    <div class="card-body">
        <p>{{ $penilaian->catatan }}</p>
    </div>
</div>
@endif

<div class="row mt-4">
    <div class="col-12 text-center">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>
</div>

<script>
    window.print();
</script>
@endsection
