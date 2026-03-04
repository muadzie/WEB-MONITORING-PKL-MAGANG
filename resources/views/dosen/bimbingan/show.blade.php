@extends('layouts.app')

@section('title', 'Detail Kelompok Bimbingan')
@section('page-title', 'Detail Kelompok Bimbingan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Kelompok</h3>
                <div class="card-tools">
                    <a href="{{ route('dosen.bimbingan.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="200">Nama Kelompok</th>
                        <td>{{ $kelompok->nama_kelompok }}</td>
                    </tr>
                    <tr>
                        <th>Perusahaan</th>
                        <td>{{ $kelompok->perusahaan->nama_perusahaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Perusahaan</th>
                        <td>{{ $kelompok->perusahaan->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Periode PKL</th>
                        <td>{{ $kelompok->tanggal_mulai->format('d F Y') }} - {{ $kelompok->tanggal_selesai->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($kelompok->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($kelompok->status == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @elseif($kelompok->status == 'selesai')
                                <span class="badge badge-info">Selesai</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Anggota Kelompok</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Prodi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelompok->anggota as $index => $anggota)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $anggota->nim }}</td>
                            <td>{{ $anggota->siswa->name }}</td>
                            <td>{{ $anggota->kelas }}</td>
                            <td>{{ $anggota->prodi }}</td>
                            <td>
                                @if($anggota->status_anggota == 'ketua')
                                    <span class="badge badge-primary">Ketua</span>
                                @else
                                    <span class="badge badge-secondary">Anggota</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Statistik Logbook</h3>
            </div>
            <div class="card-body">
                <canvas id="logbookChart" style="height: 200px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Logbook Kegiatan</h3>
                <div class="card-tools">
                    <a href="{{ route('dosen.logbook.pending') }}?kelompok={{ $kelompok->id }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-clock"></i> Lihat Pending
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Siswa</th>
                            <th>Kegiatan</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logbooks as $logbook)
                        <tr>
                            <td>{{ $logbook->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $logbook->kelompokSiswa->siswa->name }}</td>
                            <td>{{ Str::limit($logbook->kegiatan, 50) }}</td>
                            <td>{{ $logbook->jam_mulai }} - {{ $logbook->jam_selesai }}</td>
                            <td>
                                @if($logbook->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($logbook->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @else
                                    <span class="badge badge-danger">Ditolak</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('dosen.logbook.review', $logbook->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada logbook</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $logbooks->links() }}
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Laporan PKL</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Laporan</th>
                            <th>Siswa</th>
                            <th>Status</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporans as $laporan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $laporan->judul_laporan }}</td>
                            <td>{{ $laporan->kelompokSiswa->siswa->name }}</td>
                            <td>
                                @if($laporan->status == 'diajukan')
                                    <span class="badge badge-warning">Diajukan</span>
                                @elseif($laporan->status == 'direview')
                                    <span class="badge badge-info">Direview</span>
                                @elseif($laporan->status == 'direvisi')
                                    <span class="badge badge-primary">Direvisi</span>
                                @elseif($laporan->status == 'disetujui')
                                    <span class="badge badge-success">Disetujui</span>
                                @elseif($laporan->status == 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $laporan->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('dosen.laporan.review', $laporan->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada laporan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
$(function() {
    // Hitung statistik logbook
    var total = {{ $logbooks->total() }};
    var pending = {{ $logbooks->where('status', 'pending')->count() }};
    var approved = {{ $logbooks->where('status', 'disetujui')->count() }};
    var rejected = {{ $logbooks->where('status', 'ditolak')->count() }};
    
    var ctx = $('#logbookChart').get(0).getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Disetujui', 'Ditolak'],
            datasets: [{
                data: [pending, approved, rejected],
                backgroundColor: ['#f39c12', '#00a65a', '#dd4b39']
            }]
        }
    });
});
</script>
@endpush