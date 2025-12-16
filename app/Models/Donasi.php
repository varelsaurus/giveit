<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $guarded = ['id'];

    public function user() { // Donatur
        return $this->belongsTo(User::class);
    }
    
    public function pengajuan() {
        return $this->hasOne(PengajuanDonasi::class);
    }

    public function kebutuhan()
    {
        // Donasi ini menjawab kebutuhan yang mana?
        return $this->belongsTo(KebutuhanPakaian::class, 'kebutuhan_id');
    }
}