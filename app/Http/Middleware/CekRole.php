<?php

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
        // 1. Cek User Login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Cek apakah role user kosong (safety check)
        if (!$user->role) {
            abort(403, 'Akun Anda tidak memiliki data Role yang valid.');
        }

        // 3. Cek Role menggunakan fungsi di Model User
        // Variabel $roles di sini otomatis berbentuk Array (contoh: ['admin', 'kurir'])
        // Kita oper langsung ke model User->hasRole()
        if ($user->hasRole($roles)) {
            return $next($request);
        }

        // 4. Jika gagal, tampilkan pesan error yang jelas
        // Ini akan memberitahu Anda role apa yang Anda miliki vs role apa yang dibutuhkan
        abort(403, 'Akses Ditolak. Anda login sebagai: "' . $user->role . '". Halaman ini hanya untuk: "' . implode(', ', $roles) . '".');
    }
}