@extends('layouts.app')

@section('title', 'Test Dashboard Dosen')
@section('page-title', 'Test Dashboard')

@section('content')
<div class="alert alert-success">
    <h4><i class="fas fa-check-circle"></i> Berhasil!</h4>
    <p>Ini adalah halaman test dashboard dosen dengan controller terpisah.</p>
    <p>User: {{ Auth::user()->name }}</p>
    <p>Role: {{ Auth::user()->role }}</p>
</div>
@endsection