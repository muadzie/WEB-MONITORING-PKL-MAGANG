<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Logbook extends Model
{
    use HasFactory;

    protected $table = 'logbooks';
    
    protected $fillable = [
        'kelompok_siswa_id', 'tanggal', 'kegiatan', 'deskripsi',
        'jam_mulai', 'jam_selesai', 'dokumentasi', 'status',
        'catatan_dosen', 'catatan_pt', 'approved_by_dosen',
        'approved_by_pt', 'approved_at_dosen', 'approved_at_pt',
        'status_hari', 'ijin_sakit_id', 'approval_dosen', 'approval_pt'
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

    public function ijinSakit()
    {
        return $this->belongsTo(IjinSakit::class);
    }

    // Cek status approval
    public function isApprovedByDosen()
    {
        return $this->approval_dosen === 'disetujui';
    }

    public function isApprovedByPt()
    {
        return $this->approval_pt === 'disetujui';
    }

    public function isFullyApproved()
    {
        return $this->isApprovedByDosen() && $this->isApprovedByPt();
    }

    public static function canCreateLogbook($siswaId)
    {
        $today = Carbon::today();
        
        $ijinSakit = IjinSakit::where('siswa_id', $siswaId)
                    ->where('status', 'disetujui')
                    ->whereDate('tanggal_mulai', '<=', $today)
                    ->whereDate('tanggal_selesai', '>=', $today)
                    ->exists();
        
        return !$ijinSakit;
    }
}