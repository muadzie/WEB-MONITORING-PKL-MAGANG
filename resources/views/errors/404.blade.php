@extends('layouts.app')

@section('title', '404 - Not Found')
@section('page-title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="error-page">
    <h2 class="headline text-warning">404</h2>
    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-warning"></i> Halaman Tidak Ditemukan</h3>
        <p>
            Halaman yang Anda cari tidak ada.
            <a href="{{ route('dashboard') }}">Kembali ke dashboard</a>
        </p>
    </div>
</div>
@endsection