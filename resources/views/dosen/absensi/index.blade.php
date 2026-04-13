@extends('layouts.app')

@section('title', 'Absensi Siswa')
@section('page-title', 'Absensi Siswa Bimbingan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Absensi Siswa Bimbingan</h3>
        <div class="card-tools">
            <a href="{{ route('dosen.absensi.export-excel') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('dosen.absensi.rekap') }}" class="btn btn-info btn-sm">
                <i class="fas fa-chart-bar"></i> Rekap Absensi
            </a>
        </div>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('dosen.absensi.siswa') }}" class="form-inline mb-3">
            <div class="form-group mr-2">
                <label class="mr-2">Pilih Kelompok:</label>
                <select name="kelompok_id" class="form-control" required>
                    <option value="">-- Pilih Kelompok --</option>
                    @foreach($kelompoks as $kelompok)
                        <option value="{{ $kelompok->id }}" {{ request('kelompok_id') == $kelompok->id ? 'selected' : '' }}>
                            {{ $kelompok->nama_kelompok }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>

        @if($selectedKelompok)
            <h4>Kelompok: {{ $selectedKelompok->nama_kelompok }}</h4>
            
            @if(isset($isExpired) && $isExpired)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> 
                    Masa PKL kelompok ini telah berakhir pada tanggal 
                    <strong>{{ \Carbon\Carbon::parse($selectedKelompok->tanggal_selesai)->format('d F Y') }}</strong>. 
                    Tidak dapat melakukan absen baru, tetapi Anda masih bisa mengekspor data absensi.
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama Siswa</th>
                            <th>Status Absen Hari Ini</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswas as $index => $siswa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswa->nomor_induk }}</td>
                            <td>{{ $siswa->name }}</td>
                            <td>
    @if($isExpired)
        <span class="badge badge-secondary"><i class="fas fa-flag-checkered"></i> PKL Selesai</span>
    @elseif($siswa->absensi_hari_ini)
        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Sudah Absen</span>
    @else
        <span class="badge badge-danger"><i class="fas fa-clock"></i> Belum Absen</span>
    @endif
</td>
                            <td class="text-center">
                                @if(!isset($isExpired) || !$isExpired)
                                    @if(!$siswa->absensi_hari_ini)
                                        <button class="btn btn-success btn-sm btn-absen" 
                                                data-id="{{ $siswa->id }}" 
                                                data-name="{{ $siswa->name }}">
                                            <i class="fas fa-fingerprint"></i> Absenkan
                                        </button>
                                    @else
                                        <span class="text-muted">Sudah diabsen</span>
                                    @endif
                                @endif

                                {{-- Tombol export selalu ada --}}
                                <a href="{{ route('dosen.absensi.export-siswa', $siswa->id) }}" 
                                   class="btn btn-primary btn-sm" 
                                   title="Export Absensi Siswa Ini">
                                    <i class="fas fa-download"></i> Export
                                </a>
                             </div>
                           
                         </div>
                        @endforeach
                    </tbody>
                 </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.btn-absen').click(function() {
        let id = $(this).data('id');
        let name = $(this).data('name');
        
        if (confirm('Absenkan ' + name + ' sebagai hadir?')) {
            $.ajax({
                url: '{{ url("dosen/absensi/absen-siswa") }}/' + id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload();
                    } else {
                        alert(response.error);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + (xhr.responseJSON?.error || 'Unknown error'));
                }
            });
        }
    });
});
</script>
@endpush