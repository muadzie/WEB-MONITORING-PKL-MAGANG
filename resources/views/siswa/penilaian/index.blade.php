@extends('layouts.app')

@section('title', 'Nilai PKL')
@section('page-title', 'Nilai PKL')

@section('content')
@if(isset($message))
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> {{ $message }}
</div>
@else
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Penilaian Guru Pembimbing</h3>
            </div>
            <div class="card-body">
                @if($nilaiDosen)
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Nilai Laporan</th>
                            <td>
                                <h4>{{ $nilaiDosen->nilai_laporan ?? '-' }}</h4>
                                <small class="text-muted">/100</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Nilai Presentasi</th>
                            <td>
                                <h4>{{ $nilaiDosen->nilai_presentasi ?? '-' }}</h4>
                                <small class="text-muted">/100</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Nilai Sikap</th>
                            <td>
                                <h4>{{ $nilaiDosen->nilai_sikap ?? '-' }}</h4>
                                <small class="text-muted">/100</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Nilai Akhir Guru</th>
                            <td>
                                <h2 class="text-primary">{{ $nilaiDosen->nilai_akhir ?? '-' }}</h2>
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $nilaiDosen->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <strong>Grade:</strong>
                        @if($nilaiDosen->nilai_akhir >= 85)
                            <span class="badge badge-success" style="font-size: 1.2rem;">A</span>
                        @elseif($nilaiDosen->nilai_akhir >= 70)
                            <span class="badge badge-info" style="font-size: 1.2rem;">B</span>
                        @elseif($nilaiDosen->nilai_akhir >= 60)
                            <span class="badge badge-warning" style="font-size: 1.2rem;">C</span>
                        @elseif($nilaiDosen->nilai_akhir >= 50)
                            <span class="badge badge-secondary" style="font-size: 1.2rem;">D</span>
                        @else
                            <span class="badge badge-danger" style="font-size: 1.2rem;">E</span>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Belum ada penilaian dari dosen pembimbing.
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Penilaian Pembimbing PT</h3>
            </div>
            <div class="card-body">
                @if($nilaiPt)
                    <table class="table table-bordered">
                        <tr>
                            <th width="200">Nilai Kinerja</th>
                            <td>
                                <h4>{{ $nilaiPt->nilai_kinerja ?? '-' }}</h4>
                                <small class="text-muted">/100</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Nilai Kedisiplinan</th>
                            <td>
                                <h4>{{ $nilaiPt->nilai_kedisiplinan ?? '-' }}</h4>
                                <small class="text-muted">/100</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Nilai Kerjasama</th>
                            <td>
                                <h4>{{ $nilaiPt->nilai_kerjasama ?? '-' }}</h4>
                                <small class="text-muted">/100</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Nilai Inisiatif</th>
                            <td>
                                <h4>{{ $nilaiPt->nilai_inisiatif ?? '-' }}</h4>
                                <small class="text-muted">/100</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Nilai Akhir PT</th>
                            <td>
                                <h2 class="text-success">{{ $nilaiPt->nilai_akhir ?? '-' }}</h2>
                            </td>
                        </tr>
                        <tr>
                            <th>Catatan</th>
                            <td>{{ $nilaiPt->catatan ?? '-' }}</td>
                        </tr>
                    </table>
                    
                    <div class="mt-3">
                        <strong>Grade:</strong>
                        @if($nilaiPt->nilai_akhir >= 85)
                            <span class="badge badge-success" style="font-size: 1.2rem;">A</span>
                        @elseif($nilaiPt->nilai_akhir >= 70)
                            <span class="badge badge-info" style="font-size: 1.2rem;">B</span>
                        @elseif($nilaiPt->nilai_akhir >= 60)
                            <span class="badge badge-warning" style="font-size: 1.2rem;">C</span>
                        @elseif($nilaiPt->nilai_akhir >= 50)
                            <span class="badge badge-secondary" style="font-size: 1.2rem;">D</span>
                        @else
                            <span class="badge badge-danger" style="font-size: 1.2rem;">E</span>
                        @endif
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Belum ada penilaian dari pembimbing PT.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($nilaiDosen && $nilaiPt)
<div class="row mt-4">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Rekap Nilai Akhir</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary"><i class="fas fa-chalkboard-teacher"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Nilai Guru</span>
                                <span class="info-box-number">{{ number_format($nilaiDosen->nilai_akhir, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-building"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Nilai PT</span>
                                <span class="info-box-number">{{ number_format($nilaiPt->nilai_akhir, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Nilai Akhir</span>
                                <span class="info-box-number">{{ number_format($nilaiAkhir, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-success text-center mt-3">
                    <h4>
                        @if($nilaiAkhir >= 85)
                            Grade A (Sangat Baik)
                        @elseif($nilaiAkhir >= 70)
                            Grade B (Baik)
                        @elseif($nilaiAkhir >= 60)
                            Grade C (Cukup)
                        @elseif($nilaiAkhir >= 50)
                            Grade D (Kurang)
                        @else
                            Grade E (Sangat Kurang)
                        @endif
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($penilaians->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Riwayat Penilaian</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penilai</th>
                            <th>Nilai Laporan</th>
                            <th>Nilai Presentasi</th>
                            <th>Nilai Sikap</th>
                            <th>Nilai Kinerja</th>
                            <th>Nilai Disiplin</th>
                            <th>Nilai Akhir</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penilaians as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $p->penilai_label }}</td>
                            <td>{{ $p->nilai_laporan ?? '-' }}</td>
                            <td>{{ $p->nilai_presentasi ?? '-' }}</td>
                            <td>{{ $p->nilai_sikap ?? '-' }}</td>
                            <td>{{ $p->nilai_kinerja ?? '-' }}</td>
                            <td>{{ $p->nilai_kedisiplinan ?? '-' }}</td>
                            <td><strong>{{ $p->nilai_akhir ?? '-' }}</strong></td>
                            <td>{{ $p->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endif
@endsection