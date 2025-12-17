<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KebutuhanPakaian extends Model
{
    use HasFactory;

    // HAPUS baris 'protected $table' jika ada, ATAU pastikan ada 's' nya
    protected $table = 'kebutuhan_pakaians'; 

    protected $guarded = ['id'];

    // Relasi ke User (Penerima)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Donasi (Barang yang masuk untuk kebutuhan ini)
    public function donasi()
    {
        return $this->hasMany(Donasi::class, 'kebutuhan_id');
    }
}