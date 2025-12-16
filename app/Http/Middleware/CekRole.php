<?php

// app/Http/Middleware/CekRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Cek apakah ada user yang login atau user tidak memiliki role (kasus data rusak)
        // Kita juga tambahkan cek agar user tidak null, meskipun middleware 'auth' seharusnya sudah menjamin ini
        if (!Auth::check() || !Auth::user()->role) {
            // Jika tidak login atau role tidak ada, arahkan ke login atau abort
            return redirect('/login'); 
            // Atau Anda bisa menggunakan: abort(403, 'Akses Ditolak: Peran tidak terdeteksi.');
        }

        // 2. Gunakan method hasRole() dari Model User
        // Loop melalui semua role yang diterima (misal: 'admin', 'kurir')
        foreach ($roles as $role) {
            // Kita panggil method hasRole() yang baru saja kita definisikan di Model User
            if (Auth::user()->hasRole($role)) {
                return $next($request);
            }
        }

        // 3. Jika loop selesai dan tidak ada role yang cocok
        abort(403, 'Akses Ditolak: Anda tidak memiliki hak akses untuk peran ini.');
    }
}