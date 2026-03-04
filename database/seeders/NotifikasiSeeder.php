<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notifikasi;
use App\Models\User;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        foreach ($users as $user) {
            Notifikasi::create([
                'user_id' => $user->id,
                'judul' => 'Selamat Datang',
                'pesan' => 'Selamat datang di Sistem Monitoring PKL',
                'tipe' => 'info',
                'url' => '/dashboard',
                'is_read' => false,
            ]);
        }
    }
}