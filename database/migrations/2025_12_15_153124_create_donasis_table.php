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
        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Donatur
            
            // Relasi ini sekarang aman karena tabel kebutuhan_pakaians sudah dibuat sebelumnya
            $table->foreignId('kebutuhan_id')
                  ->nullable()
                  ->constrained('kebutuhan_pakaians')
                  ->onDelete('set null');
            
            $table->string('nama_barang');
            $table->text('deskripsi');
            $table->string('foto')->nullable();
            $table->integer('jumlah');
            $table->enum('status', ['pending', 'approved', 'rejected', 'proses_kurir', 'selesai'])->default('pending');
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