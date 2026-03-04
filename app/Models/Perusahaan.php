<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $table = 'perusahaans';
    
    protected $fillable = [
        'nama_perusahaan', 'alamat', 'telepon', 'email', 
        'bidang_usaha', 'deskripsi', 'kontak_person', 
        'jabatan_kontak', 'logo', 'user_id', 'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelompokPkls()
    {
        return $this->hasMany(KelompokPkl::class);
    }
}