<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';
    
    protected $fillable = [
        'nidn', 'nama_dosen', 'gelar_depan', 'gelar_belakang',
        'jurusan', 'fakultas', 'telepon', 'email', 'foto', 
        'user_id', 'is_active'
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