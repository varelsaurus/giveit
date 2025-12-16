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
}
