@extends('layouts.app')

@section('title', '403 - Forbidden')
@section('page-title', 'Akses Ditolak')

@section('content')
<div class="error-page">
    <h2 class="headline text-danger">403</h2>
    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-danger"></i> Akses Ditolak</h3>
        <p>
            Anda tidak memiliki izin untuk mengakses halaman ini.
            <a href="{{ route('dashboard') }}">Kembali ke dashboard</a>
        </p>
    </div>
</div>
@endsection