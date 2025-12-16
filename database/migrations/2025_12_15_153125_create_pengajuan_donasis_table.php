<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan nama tabel di sini adalah 'pengajuan_donasis' (jamak/plural)
        Schema::create('pengajuan_donasis', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke User (Penerima Donor)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Relasi ke Donasi (Barang yang diajukan)
            $table->foreignId('donasi_id')->constrained('donasis')->onDelete('cascade');
            
            // Status Pengajuan
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'])->default('Menunggu');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_donasis');
    }
};