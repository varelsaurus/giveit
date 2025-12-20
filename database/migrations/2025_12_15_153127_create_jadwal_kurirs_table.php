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
        // xxxx_create_delivery_schedules_table.php
        Schema::create('jadwal_kurirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Kurir
            $table->foreignId('donasi_id')->constrained('donasis')->onDelete('cascade');
            $table->foreignId('pengajuan_id')->nullable()->constrained('pengajuan_donasis')->onDelete('cascade');
            
            $table->date('tanggal_pengiriman');
            $table->string('estimasi_waktu')->nullable();
            $table->enum('status', ['waiting', 'on_the_way', 'delivered', 'failed'])->default('waiting');
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
