<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'logbooks';
    
    protected $fillable = [
        'kelompok_siswa_id', 'tanggal', 'kegiatan', 'deskripsi',
        'jam_mulai', 'jam_selesai', 'dokumentasi', 'status',
        'catatan_dosen', 'catatan_pt', 'approved_by_dosen',
        'approved_by_pt', 'approved_at_dosen', 'approved_at_pt'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime',
        'jam_selesai' => 'datetime',
        'approved_at_dosen' => 'datetime',
        'approved_at_pt' => 'datetime',
    ];

    public function kelompokSiswa()
    {
        return $this->belongsTo(KelompokSiswa::class);
    }

    public function approverDosen()
    {
        return $this->belongsTo(User::class, 'approved_by_dosen');
    }

    public function approverPt()
    {
        return $this->belongsTo(User::class, 'approved_by_pt');
    }
    // app/Models/Logbook.php

// Scope untuk logbook yang perlu approval
public function scopeNeedApproval($query)
{
    return $query->where('status', 'pending');
}

// Cek apakah sudah di-approve dosen
public function isApprovedByDosen()
{
    return !is_null($this->approved_by_dosen);
}

// Cek apakah sudah di-approve PT
public function isApprovedByPt()
{
    return !is_null($this->approved_by_pt);
}
}