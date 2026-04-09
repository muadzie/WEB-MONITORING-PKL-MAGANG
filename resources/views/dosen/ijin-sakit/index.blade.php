@extends('layouts.app')

@section('title', 'Pengajuan Izin / Sakit')
@section('page-title', 'Pengajuan Izin / Sakit Mahasiswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Pengajuan</h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Siswa</th>
                                <th>NIM</th>
                                <th>Jenis</th>
                                <th>Periode</th>
                                <th>Alasan</th>
                                <th>Status</th>
                                <th>Bukti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ijinSakits as $index => $item)
                            <tr>
                                <td>{{ $ijinSakits->firstItem() + $index }}</td>
                                <td>{{ $item->siswa->name }}</td>
                                <td>{{ $item->siswa->nomor_induk }}</td>
                                <td>
                                    @if($item->jenis == 'izin')
                                        <span class="badge badge-info">Izin</span>
                                    @else
                                        <span class="badge badge-warning">Sakit</span>
                                    @endif
                                </td>
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
                                <td class="text-center">
                                    @if($item->bukti_foto)
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#fotoModal{{ $item->id }}">
                                            <i class="fas fa-image"></i> Lihat
                                        </button>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        @if($item->status == 'pending')
                                            <form action="{{ route('dosen.ijin-sakit.approve', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success" onclick="return confirm('Setujui pengajuan ini?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal{{ $item->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        {{-- Tombol hapus selalu muncul --}}
                                        <form action="{{ route('dosen.ijin-sakit.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengajuan ini? Data akan dihapus permanen.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                 </div>
                                
                             </div>

                            <!-- Modal Foto -->
                            <div class="modal fade" id="fotoModal{{ $item->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Bukti Foto</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body text-center">
                                            @if($item->bukti_foto && Storage::disk('public')->exists($item->bukti_foto))
                                                <img src="{{ asset('storage/'.$item->bukti_foto) }}" class="img-fluid img-thumbnail">
                                                <br><br>
                                                <a href="{{ asset('storage/'.$item->bukti_foto) }}" class="btn btn-primary" download>
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @else
                                                <div class="alert alert-warning">File tidak ditemukan</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Tolak (hanya untuk status pending) -->
                            @if($item->status == 'pending')
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
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">Belum ada pengajuan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $ijinSakits->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-group-sm .btn {
        margin: 0 2px;
    }
</style>
@endpush