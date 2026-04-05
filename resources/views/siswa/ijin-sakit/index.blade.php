@extends('layouts.app')

@section('title', 'Izin / Sakit')
@section('page-title', 'Pengajuan Izin / Sakit')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Pengajuan Izin / Sakit</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.ijin-sakit.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Ajukan Izin / Sakit
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ijinSakits as $index => $item)
                        <tr>
                            <td>{{ $ijinSakits->firstItem() + $index }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}</td>
                            <td>
                                @if($item->jenis == 'izin')
                                    <span class="badge badge-info">Izin</span>
                                @else
                                    <span class="badge badge-warning">Sakit</span>
                                @endif
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($item->alasan, 50) }}</td>
                            <td>
                                @if($item->status == 'pending')
                                    <span class="badge badge-warning">Menunggu</span>
                                @elseif($item->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('siswa.ijin-sakit.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($item->status == 'pending')
                                    <form action="{{ route('siswa.ijin-sakit.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Batalkan pengajuan?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada pengajuan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $ijinSakits->links() }}
            </div>
        </div>
    </div>
</div>

<div class="alert alert-info mt-3">
    <i class="fas fa-info-circle"></i>
    <strong>Informasi:</strong> Selama masa izin/sakit yang disetujui, Anda TIDAK perlu mengisi logbook. 
    Sistem akan otomatis mencatat status izin/sakit pada logbook.
</div>
@endsection