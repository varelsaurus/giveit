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
        // database/migrations/xxxx_create_jadwal_kurirs_table.php (Contoh)
        Schema::create('jadwal_kurirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurir_id')->constrained('users'); // User Kurir
            $table->foreignId('pengajuan_id')->constrained('pengajuan_donasi'); 
            $table->dateTime('tanggal_waktu_ambil');
            $table->dateTime('tanggal_waktu_kirim');
            $table->string('alamat_ambil');
            $table->string('alamat_kirim');
            $table->enum('status', ['Menunggu Ambil', 'Dalam Perjalanan', 'Selesai'])->default('Menunggu Ambil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kurirs');
    }
};
