<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    // Tambahkan properti ini agar data bisa disimpan
    protected $fillable = [
        'user_id',
        'jenis_pakaian',
        'jumlah',
        'deskripsi',
        // 'foto',
        'status',
    ];

    // Tambahkan relasi ke User (agar kita tahu siapa pemilik donasi ini)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}