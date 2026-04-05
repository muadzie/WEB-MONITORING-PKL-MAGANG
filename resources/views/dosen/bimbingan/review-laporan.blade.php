@extends('layouts.app')

@section('title', 'Review Laporan')
@section('page-title', 'Review Laporan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Review Laporan</h3>
        <a href="{{ route('dosen.laporan.index') }}" class="btn btn-secondary btn-sm float-right">Kembali</a>
    </div>
    <div class="card-body">
        <div class="alert alert-primary">Halaman review laporan - Sedang dalam pengembangan</div>
    </div>
</div>
@endsection