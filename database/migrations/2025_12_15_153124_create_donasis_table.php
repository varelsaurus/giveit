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
        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pemilik donasi (Donatur)
            $table->string('nama_barang');
            $table->text('deskripsi');
            $table->string('image')->nullable();
            $table->string('alamat_jemput')->nullable();
            // Enum Status: Tersedia -> Butuh Kurir -> Proses Pengiriman -> Selesai
            $table->string('status')->default('Tersedia'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasis');
    }
};
