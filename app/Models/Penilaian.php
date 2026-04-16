<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaians';
    
    protected $fillable = [
        'kelompok_siswa_id', 'penilai', 'nilai_laporan',
        'nilai_presentasi', 'nilai_sikap', 'nilai_kinerja',
        'nilai_kedisiplinan', 'nilai_kerjasama', 'nilai_inisiatif',
        'nilai_akhir', 'catatan', 'penilai_id'
    ];

    public function kelompokSiswa()
    {
        return $this->belongsTo(KelompokSiswa::class);
    }

    public function penilaiUser()
    {
        return $this->belongsTo(User::class, 'penilai_id');
    }

    // Hitung nilai akhir otomatis
    public function hitungNilaiAkhir()
    {
        if ($this->penilai === 'dosen') {
            $total = ($this->nilai_laporan + $this->nilai_presentasi + $this->nilai_sikap) / 3;
        } else {
            $total = ($this->nilai_kinerja + $this->nilai_kedisiplinan + 
                     $this->nilai_kerjasama + $this->nilai_inisiatif) / 4;
        }
        
        $this->nilai_akhir = round($total, 2);
        $this->save();
        
        return $this->nilai_akhir;
    }

    public function getPenilaiLabelAttribute()
{
    return match($this->penilai) {
        'dosen' => 'Guru',
        'pt' => 'Perusahaan',
        default => ucfirst($this->penilai)
    };
}
}