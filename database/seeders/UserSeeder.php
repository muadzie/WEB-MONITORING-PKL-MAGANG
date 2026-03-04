<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@monitoring.test',
            'password' => Hash::make('password'),
            'nomor_induk' => 'ADM001',
            'phone' => '081234567890',
            'address' => 'Jl. Contoh No. 1',
            'role' => 'admin',
            'is_active' => true,
        ]);
        
        // Create Dosen
        $dosenUser = User::create([
            'name' => 'Dr. Ahmad Syauqi',
            'email' => 'dosen@monitoring.test',
            'password' => Hash::make('password'),
            'nomor_induk' => '197001012005011001',
            'phone' => '081234567891',
            'address' => 'Jl. Contoh No. 2',
            'role' => 'dosen',
            'is_active' => true,
        ]);
        
        // Create PT
        $ptUser = User::create([
            'name' => 'PT Maju Bersama',
            'email' => 'pt@monitoring.test',
            'password' => Hash::make('password'),
            'nomor_induk' => 'PT001',
            'phone' => '081234567892',
            'address' => 'Jl. Contoh No. 3',
            'role' => 'pt',
            'is_active' => true,
        ]);
        
        // Create Siswa
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'siswa@monitoring.test',
            'password' => Hash::make('password'),
            'nomor_induk' => '2021001',
            'phone' => '081234567893',
            'address' => 'Jl. Contoh No. 4',
            'role' => 'siswa',
            'is_active' => true,
        ]);
        
        User::create([
            'name' => 'Ani Wijayanti',
            'email' => 'siswa2@monitoring.test',
            'password' => Hash::make('password'),
            'nomor_induk' => '2021002',
            'phone' => '081234567894',
            'address' => 'Jl. Contoh No. 5',
            'role' => 'siswa',
            'is_active' => true,
        ]);
    }
}