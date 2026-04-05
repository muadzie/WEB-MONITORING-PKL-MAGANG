@extends('layouts.app')

@section('title', 'Detail Kelompok')
@section('page-title', 'Detail Kelompok Bimbingan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Kelompok</h3>
        <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-secondary btn-sm float-right">Kembali</a>
    </div>
    <div class="card-body">
        <div class="alert alert-info">Halaman detail kelompok - Sedang dalam pengembangan</div>
    </div>
</div>
@endsection