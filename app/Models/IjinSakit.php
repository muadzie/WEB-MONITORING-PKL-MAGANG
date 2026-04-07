<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class IjinSakit extends Model
{
    use HasFactory;

    protected $table = 'ijin_sakit';

    protected $fillable = [
        'siswa_id', 'kelompok_siswa_id', 'tanggal_mulai', 'tanggal_selesai',
        'jenis', 'alasan', 'bukti_foto', 'status', 'catatan_dosen',
        'approved_by', 'approved_at'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'approved_at' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function kelompokSiswa()
    {
        return $this->belongsTo(KelompokSiswa::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}