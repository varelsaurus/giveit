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
        Schema::create('kebutuhan_pakaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penerima
            $table->string('jenis_pakaian');
            $table->integer('jumlah');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Belum Terpenuhi', 'Terpenuhi']).default('Belum Terpenuhi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebutuhan_pakaians');
    }
};
