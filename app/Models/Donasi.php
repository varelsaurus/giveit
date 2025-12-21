<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kebutuhan_id',
        'nama_barang',
        'deskripsi',
        'jumlah',
        'foto',    // <--- GANTI DARI 'gambar' KE 'foto' (Sesuai Database)
        'status',  // <--- WAJIB ADA
    ];

    public function user() { 
        return $this->belongsTo(User::class);
    }
    
    public function pengajuan() {
        return $this->hasOne(PengajuanDonasi::class);
    }

    public function kebutuhan() {
        return $this->belongsTo(KebutuhanPakaian::class, 'kebutuhan_id');
    }
}