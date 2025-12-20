<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKurir extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'donasi_id',
        'pengajuan_id', // Opsional
        'tanggal_pengambilan', // <--- INI WAJIB DITAMBAHKAN
        'estimasi_waktu',
        'status',
        'catatan', // <--- INI JUGA DITAMBAHKAN
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Donasi
    public function donasi()
    {
        return $this->belongsTo(Donasi::class);
    }
}