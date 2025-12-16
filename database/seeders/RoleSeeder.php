<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'donatur']);
        Role::create(['name' => 'penerima_donor']);
        Role::create(['name' => 'kurir']);
        Role::create(['name' => 'admin']);
    }
}
