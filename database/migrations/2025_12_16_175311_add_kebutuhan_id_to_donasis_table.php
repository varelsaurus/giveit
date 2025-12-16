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
        Schema::table('donasis', function (Blueprint $table) {
            // Kolom ini nyambung ke tabel kebutuhan_pakaians
            // Nullable = Donatur boleh donasi inisiatif sendiri tanpa ada request
            $table->foreignId('kebutuhan_id')
                  ->nullable()
                  ->constrained('kebutuhan_pakaians')
                  ->onDelete('set null');
        });
    }
    
    public function down()
    {
        Schema::table('donasis', function (Blueprint $table) {
            $table->dropForeign(['kebutuhan_id']);
            $table->dropColumn('kebutuhan_id');
        });
    }
};
