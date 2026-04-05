<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis';

    protected $fillable = [
        'siswa_id', 'kelompok_siswa_id', 'tanggal', 'jam_masuk', 'jam_keluar',
        'status', 'keterangan', 'bukti_foto', 'latitude', 'longitude',
        'lokasi_absen', 'is_valid_location', 'dosen_id', 'dosen_absen_at'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
        'is_valid_location' => 'boolean',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function kelompokSiswa()
    {
        return $this->belongsTo(KelompokSiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}