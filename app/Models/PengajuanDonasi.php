<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanDonasi extends Model
{
    protected $guarded = ['id'];

    public function user() { // Penerima
        return $this->belongsTo(User::class);
    }

    public function donasi() {
        return $this->belongsTo(Donasi::class);
    }
}