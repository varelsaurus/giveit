<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa admin yang buat
            $table->string('judul'); // Contoh: "Laporan Januari 2025"
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->integer('total_donasi_tercatat'); // Disimpan otomatis/input
            $table->text('catatan')->nullable(); // Input manual admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};