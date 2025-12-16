<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Panggil RoleSeeder dan UserSeeder
        // RoleSeeder harus dijalankan PERTAMA kali karena UserSeeder membutuhkannya.
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
        ]);
        
        // 2. Kode bawaan untuk User Factory (Opsional, dihapus jika tidak diperlukan)
        // User::factory(10)->create(); 

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        // Catatan: Karena kita sudah mendefinisikan user di UserSeeder (admin, donatur, dll.),
        // kode bawaan factory di atas biasanya dihapus.
    }
}