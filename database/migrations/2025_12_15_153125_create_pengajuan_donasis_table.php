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
        Schema::create('pengajuan_donasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penerima
            $table->foreignId('donasi_id')->constrained('donasis')->onDelete('cascade'); // Barang yg diminta
            $table->text('alasan')->nullable();
            // Status: Menunggu -> Disetujui Admin -> Kurir Menuju Lokasi -> Diterima -> Ditolak
            $table->string('status')->default('Menunggu'); 
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