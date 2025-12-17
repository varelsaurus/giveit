<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'), // Ganti password sesuai keinginan
            'role' => 'admin', // PERBAIKAN: Pakai 'role' (string), bukan 'role_id'
            'alamat' => 'Kantor Pusat',
            'no_hp' => '081234567890',
        ]);

        // 2. Buat Akun KURIR (Contoh)
        User::create([
            'name' => 'Kurir Express',
            'email' => 'kurir@mail.com',
            'password' => Hash::make('password'),
            'role' => 'kurir',
            'alamat' => 'Bandung Kota',
            'no_hp' => '081298765432',
        ]);

        // 3. Buat Akun DONATUR (Contoh)
        User::create([
            'name' => 'Donatur A',
            'email' => 'donatur@mail.com',
            'password' => Hash::make('password'),
            'role' => 'donatur',
            'alamat' => 'Jl. Dago No. 10',
            'no_hp' => '081211112222',
        ]);

        // 4. Buat Akun PENERIMA (Contoh)
        User::create([
            'name' => 'Penerima Manfaat',
            'email' => 'penerima@mail.com',
            'password' => Hash::make('password'),
            'role' => 'penerima_donor', // Pastikan stringnya sama dengan logic di Controller
            'alamat' => 'Jl. Cibaduyut',
            'no_hp' => '081233334444',
        ]);
    }
}