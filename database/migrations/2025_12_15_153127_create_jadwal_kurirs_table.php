<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jadwal_kurirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kurir yang ambil tugas
            $table->foreignId('donasi_id')->constrained('donasis')->onDelete('cascade');
            $table->foreignId('pengajuan_id')->constrained('pengajuan_donasis')->onDelete('cascade');
            
            $table->date('tanggal_pengiriman');
            $table->string('estimasi_waktu'); // Contoh: "10:00 - 12:00"
            
            // Status: Menjemput Barang -> Mengantar Barang -> Selesai
            $table->string('status')->default('Menjemput Barang'); 
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
