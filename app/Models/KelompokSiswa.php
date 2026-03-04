<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokSiswa extends Model
{
    use HasFactory;

    protected $table = 'kelompok_siswas';
    
    protected $fillable = [
        'kelompok_pkl_id', 'siswa_id', 'nim', 
        'kelas', 'prodi', 'status_anggota'
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function kelompok()
    {
        return $this->belongsTo(KelompokPkl::class, 'kelompok_pkl_id');
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class);
    }
}