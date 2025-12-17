<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKurir extends Model
{
    use HasFactory;

    // Kita gunakan $fillable agar jelas kolom apa saja yang diizinkan
    protected $fillable = [
        'user_id',
        'donasi_id',
        'pengajuan_id',
        'status',
        'tanggal_pengiriman',
        'estimasi_waktu', // Pastikan namanya ini
    ];

    // Relasi ke User (Kurir)
    public function kurir() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Donasi (Barang)
    public function donasi() {
        return $this->belongsTo(Donasi::class);
    }
    
    // Relasi ke Pengajuan (Penerima - Jika ada)
    public function pengajuan() {
        return $this->belongsTo(PengajuanDonasi::class);
    }
}