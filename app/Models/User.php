<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = ['id']; // Gunakan guarded agar lebih mudah

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
    // RELASI
    // ===================================

    /**
     * User selalu memiliki satu role.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

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
        if (is_array($roles)) {
            // Cek apakah role user ada di dalam array $roles
            return in_array($this->role->name, $roles);
        }
        
        // Cek jika hanya string tunggal
        return $this->role->name === $roles;
    }
}