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
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Cek User Login & Ketersediaan Role
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Cek jika role user kosong (kasus data lama/rusak)
        if (!$user->role) {
            abort(403, 'Akun Anda tidak memiliki Role yang valid.');
        }

        // 2. Loop cek role
        foreach ($roles as $role) {
            // Panggil fungsi hasRole yang sudah diperbaiki di Model User
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // 3. Jika tidak ada yang cocok
        abort(403, 'Akses Ditolak: Anda bukan ' . implode(' atau ', $roles));
    }
}