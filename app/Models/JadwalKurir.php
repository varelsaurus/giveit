<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKurir extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke User (Kurir itu sendiri)
    public function kurir()
    {
        return $this->belongsTo(User::class, 'kurir_id');
    }

    // Relasi ke Pengajuan (Untuk tahu barang apa yang diambil)
    public function pengajuan()
    {
        return $this->belongsTo(PengajuanDonasi::class, 'pengajuan_id');
    }
}