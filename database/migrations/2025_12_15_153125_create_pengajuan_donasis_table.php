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
        Schema::create('pengajuan_donasi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('donasi_id')->constrained('donasis'); // Donasi yang diajukan
        $table->foreignId('kebutuhan_id')->nullable()->constrained('kebutuhan_pakaian'); // Kebutuhan yang terdaftar
        $table->foreignId('penerima_id')->constrained('users'); // User Penerima yang mengajukan
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
