<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanDonasi extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_donasi'; // Memastikan nama tabel benar
    protected $fillable = ['user_id', 'donasi_id', 'status'];

    // Relasi ke Penerima (User)
    public function penerima()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Barang Donasi
    public function donasi()
    {
        return $this->belongsTo(Donasi::class, 'donasi_id');
    }
}