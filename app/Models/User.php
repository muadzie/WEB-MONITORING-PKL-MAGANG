<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nomor_induk',
        'phone',
        'address',
        'foto',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // ============= RELATIONSHIPS =============

    /**
     * Get the dosen associated with the user.
     */
    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    /**
     * Get the perusahaan associated with the user.
     */
    public function perusahaan()
    {
        return $this->hasOne(Perusahaan::class);
    }

    /**
     * Get the kelompokSiswa for the user.
     */
    public function kelompokSiswa()
    {
        return $this->hasMany(KelompokSiswa::class, 'siswa_id');
    }

    /**
     * Get the notifikasis for the user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    // ============= ROLE CHECKS =============

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is dosen.
     */
    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }

    /**
     * Check if user is pt.
     */
    public function isPT(): bool
    {
        return $this->role === 'pt';
    }

    /**
     * Check if user is siswa.
     */
    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }
}