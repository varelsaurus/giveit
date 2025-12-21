<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanPakaian extends Model
{
    use HasFactory;

    // PASTIKAN NAMA TABEL BENAR (Sesuai database kamu)
    protected $table = 'kebutuhan_pakaians'; 

    protected $fillable = [
        'user_id',
        'jenis_pakaian', // Atau 'nama_barang' (sesuaikan DB)
        'jumlah',
        'deskripsi',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}