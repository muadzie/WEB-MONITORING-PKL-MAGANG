@extends('layouts.app')

@section('title', 'Review Logbook')
@section('page-title', 'Review Logbook')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Review Logbook</h3>
        <a href="{{ route('dosen.logbook.pending') }}" class="btn btn-secondary btn-sm float-right">Kembali</a>
    </div>
    <div class="card-body">
        <div class="alert alert-warning">Halaman review logbook - Sedang dalam pengembangan</div>
    </div>
</div>
@endsection