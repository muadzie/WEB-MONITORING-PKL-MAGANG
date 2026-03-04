@extends('layouts.app')

@section('title', 'Export Data PKL')
@section('page-title', 'Export Data PKL')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Export Data Kelompok</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.export.kelompok') }}" method="GET">
                    @csrf
                    <div class="form-group">
                        <label>Tahun</label>
                        <select name="tahun" class="form-control" required>
                            <option value="">Pilih Tahun</option>
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="aktif">Aktif</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Export Nilai PKL</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.export.nilai') }}" method="GET">
                    @csrf
                    <div class="form-group">
                        <label>Pilih Kelompok</label>
                        <select name="kelompok_id" class="form-control" required>
                            <option value="">Pilih Kelompok</option>
                            @foreach($kelompoks as $kelompok)
                                <option value="{{ $kelompok->id }}">{{ $kelompok->nama_kelompok }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Export Data Siswa</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.export.siswa') }}" method="GET">
                    @csrf
                    <div class="form-group">
                        <label>Angkatan</label>
                        <select name="angkatan" class="form-control">
                            <option value="">Semua Angkatan</option>
                            @for($i = date('Y'); $i >= 2020; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Prodi</label>
                        <input type="text" name="prodi" class="form-control" placeholder="Contoh: TI">
                    </div>
                    <button type="submit" class="btn btn-info btn-block">
                        <i class="fas fa-file-csv"></i> Export CSV
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection