<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KebutuhanPakaian extends Model
{
    use HasFactory;

    // TAMBAHKAN BARIS INI
    protected $table = 'kebutuhan_pakaian'; // Memberi tahu Laravel nama tabel yang benar (tanpa 's')

    protected $guarded = ['id'];

    public function donasi()
    {
        // Satu kebutuhan bisa dipenuhi oleh banyak donasi (misal butuh 100, ada 2 donatur nyumbang 50-50)
        return $this->hasMany(Donasi::class, 'kebutuhan_id');
    }
    
    public function user()
    {
        // Siapa yang request kebutuhan ini?
        return $this->belongsTo(User::class);
    }
}
