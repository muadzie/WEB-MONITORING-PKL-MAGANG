<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokPkl extends Model
{
    use HasFactory;

    protected $table = 'kelompok_pkls';
    
    protected $fillable = [
        'nama_kelompok', 'dosen_id', 'perusahaan_id',
        'tanggal_mulai', 'tanggal_selesai', 'status', 'catatan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    public function anggota()
    {
        return $this->hasMany(KelompokSiswa::class);
    }
    // app/Models/KelompokPkl.php

// Hitung jumlah anggota
public function getJumlahAnggotaAttribute()
{
    return $this->anggota()->count();
}

// Cek apakah kelompok sudah bisa dinilai
public function canBeRated()
{
    return $this->status === 'selesai';
}
}