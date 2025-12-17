<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     * Kita gunakan $fillable agar jelas kolom apa saja yang boleh diisi.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',     // PENTING: Kolom role string
        'alamat',   // Tambahan dari migration tadi
        'no_hp',    // Tambahan dari migration tadi
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ===================================
    // PERHATIAN: 
    // FUNGSI public function role() SUDAH DIHAPUS 
    // KARENA KITA TIDAK PAKAI TABEL ROLES LAGI
    // ===================================

    // ===================================
    // HELPER METHOD UNTUK CEK ROLE
    // ===================================
    
    /**
     * Cek apakah user memiliki salah satu peran yang diberikan.
     * @param string|array $roles
     * @return bool
     */
    public function hasRole(string|array $roles): bool
    {
        // Jika inputnya array (misal: ['admin', 'kurir'])
        if (is_array($roles)) {
            // Cek apakah 'role' (string) milik user ada di dalam array tersebut
            return in_array($this->role, $roles);
        }
        
        // Jika inputnya string tunggal (misal: 'admin')
        // Bandingkan langsung string ketemu string.
        // JANGAN PAKAI ->name LAGI
        return $this->role === $roles;
    }
}