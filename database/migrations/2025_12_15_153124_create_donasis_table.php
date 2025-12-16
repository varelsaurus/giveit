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
        $table->foreignId('user_id')->constrained(); // Donatur
        $table->string('jenis_pakaian');
        $table->text('deskripsi')->nullable();
        $table->enum('status', ['Tersedia', 'Diajukan', 'Dalam Pengiriman', 'Selesai'])->default('Tersedia');
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
