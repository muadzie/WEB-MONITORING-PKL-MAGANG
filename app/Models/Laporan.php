<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporans';
    
    protected $fillable = [
        'kelompok_siswa_id', 'judul_laporan', 'abstrak',
        'file_laporan', 'file_presentasi', 'status',
        'catatan_revisi', 'reviewer_dosen_id', 'reviewed_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function kelompokSiswa()
    {
        return $this->belongsTo(KelompokSiswa::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_dosen_id');
    }
}