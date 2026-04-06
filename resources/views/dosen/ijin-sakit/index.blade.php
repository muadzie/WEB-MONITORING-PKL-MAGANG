@extends('layouts.app')

@section('title', 'Izin / Sakit')
@section('page-title', 'Pengajuan Izin / Sakit')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Pengajuan Izin / Sakit Mahasiswa</h3>
    </div>
    <div class="card-body">
        @if(isset($ijinSakits) && $ijinSakits->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Jenis</th>
                            <th>Periode</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ijinSakits as $item)
                        <tr>
                            <td>{{ $item->siswa->name }} ({{
 $item->siswa->nomor_induk }})</td>
                            <td>{{ ucfirst($item->jenis) }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y') }}</td>
                            <td>{{ Str::limit($item->alasan, 50) }}</td>
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
                                @if($item->status == 'pending')
                                    <form action="{{ route('dosen.ijin-sakit.approve', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Setujui pengajuan ini?')">Setujui</button>
                                    </form>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#rejectModal{{ $item->id }}">Tolak</button>
                                    
                                    <div class="modal fade" id="rejectModal{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('dosen.ijin-sakit.reject', $item->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Tolak Pengajuan</h5>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Catatan Penolakan</label>
                                                            <textarea name="catatan_dosen" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Tolak</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $ijinSakits->links() }}
        @else
            <div class="alert alert-info">Belum ada pengajuan izin/sakit.</div>
        @endif
    </div>
</div>
@endsection