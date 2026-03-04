@extends('layouts.app')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Notifikasi</h3>
        <div class="card-tools">
            <form action="{{ route('notifikasi.read-all') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                </button>
            </form>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="list-group">
            @forelse($notifikasis as $notif)
                <div class="list-group-item {{ !$notif->is_read ? 'list-group-item-info' : '' }}">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            <i class="fas fa-{{ $notif->tipe == 'success' ? 'check-circle text-success' : ($notif->tipe == 'warning' ? 'exclamation-triangle text-warning' : 'info-circle text-info') }}"></i>
                            {{ $notif->judul }}
                        </h5>
                        <small>{{ $notif->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-1">{{ $notif->pesan }}</p>
                    @if($notif->url)
                        <a href="{{ route('notifikasi.read', $notif->id) }}" class="btn btn-sm btn-info mt-2">
                            <i class="fas fa-eye"></i> Lihat
                        </a>
                    @endif
                </div>
            @empty
                <div class="list-group-item text-center">
                    <p class="mb-0">Tidak ada notifikasi</p>
                </div>
            @endforelse
        </div>
    </div>
    <div class="card-footer">
        {{ $notifikasis->links() }}
    </div>
</div>
@endsection