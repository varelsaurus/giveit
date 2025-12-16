<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua Role ID
        $roles = Role::pluck('id', 'name');

        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $roles['admin'],
        ]);

        User::create([
            'name' => 'Donatur A',
            'email' => 'donatur@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $roles['donatur'],
        ]);

        User::create([
            'name' => 'Penerima B',
            'email' => 'penerima@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $roles['penerima_donor'],
        ]);

        User::create([
            'name' => 'Kurir C',
            'email' => 'kurir@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $roles['kurir'],
        ]);
    }
}