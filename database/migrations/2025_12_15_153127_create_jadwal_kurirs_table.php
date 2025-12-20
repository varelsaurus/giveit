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
            
            // Relasi ke User (Kurir)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            // Relasi ke Donasi (Barang yang diambil)
            $table->foreignId('donasi_id')->constrained('donasis')->onDelete('cascade');
            
            // Relasi Pengajuan (Opsional, jika untuk antar ke penerima)
            $table->foreignId('pengajuan_id')->nullable()->constrained('pengajuan_donasis')->onDelete('cascade');
            
            // PERBAIKAN 1: Nama kolom disesuaikan dengan Controller (tanggal_pengambilan)
            $table->date('tanggal_pengambilan'); 
            
            $table->string('estimasi_waktu')->nullable();

            // PERBAIKAN 2: Menambahkan 'dijemput' ke dalam enum
            $table->enum('status', ['waiting', 'dijemput', 'on_the_way', 'delivered', 'failed'])->default('waiting');
            
            // PERBAIKAN 3: Menambahkan kolom catatan (karena di controller ada input catatan)
            $table->text('catatan')->nullable();

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