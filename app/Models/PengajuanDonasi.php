<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDonasi extends Model
{
    public function donasi() { return $this->belongsTo(Donasi::class); }
    public function penerima() { return $this->belongsTo(User::class, 'penerima_id'); }
    // Asumsi relasi ke kebutuhan pakaian juga ada
}
