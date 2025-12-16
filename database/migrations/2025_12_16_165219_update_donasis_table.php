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
        Schema::table('donasis', function (Blueprint $table) {
            // 1. Tambah kolom 'jumlah' jika belum ada
            if (!Schema::hasColumn('donasis', 'jumlah')) {
                // Kita taruh setelah jenis_pakaian biar rapi
                $table->integer('jumlah')->after('jenis_pakaian'); 
            }

            // 2. Tambah kolom 'foto' untuk fitur upload gambar
            if (!Schema::hasColumn('donasis', 'foto')) {
                // Nullable artinya boleh kosong (opsional)
                $table->string('foto')->nullable()->after('deskripsi'); 
            }
            
            // OPSIONAL: Jika kamu punya kolom lama bernama 'jumlah_pakaian', 
            // kita bisa menghapusnya agar tidak duplikat (uncomment jika perlu)
            // if (Schema::hasColumn('donasis', 'jumlah_pakaian')) {
            //     $table->dropColumn('jumlah_pakaian');
            // }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donasis', function (Blueprint $table) {
            $table->dropColumn(['jumlah', 'foto']);
            
            // Kembalikan kolom lama jika di-rollback (opsional)
            // $table->integer('jumlah_pakaian');
        });
    }
};