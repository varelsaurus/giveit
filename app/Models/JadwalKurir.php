<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKurir extends Model
{
    protected $guarded = ['id'];

    public function kurir() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function donasi() {
        return $this->belongsTo(Donasi::class);
    }
    
    public function pengajuan() {
        return $this->belongsTo(PengajuanDonasi::class);
    }
}