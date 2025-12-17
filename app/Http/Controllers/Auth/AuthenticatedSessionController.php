<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; 
use App\Providers\RouteServiceProvider; 

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // PANGGIL FUNGSI REDIRECT BERDASARKAN PERAN DI SINI
        return $this->redirectBasedOnRole(Auth::user());
    }
    
    /**
     * FUNGSI BARU: Menentukan rute redirect berdasarkan peran pengguna.
     */
    protected function getRedirectRoute(User $user): string
    {
        // Pastikan user memiliki role
        if (!$user->role) {
            return RouteServiceProvider::HOME; 
        }

        // PERBAIKAN DI SINI:
        // Kita langsung cek ($user->role) karena isinya string "admin", "kurir", dll.
        // Tidak perlu pakai ->name lagi.
        switch ($user->role) { 
            case 'admin':
                return route('admin.user.index');
                
            case 'donatur':
                return route('donatur.donasi.index');
                
            case 'penerima_donor':
                return route('penerima.kebutuhan.index');
                
            case 'kurir':
                return route('kurir.jadwal.index');
                
            default:
                return RouteServiceProvider::HOME;
        }
    }

    /**
     * Mengarahkan user ke rute yang ditentukan.
     */
    protected function redirectBasedOnRole(User $user): RedirectResponse
    {
        $redirectUrl = $this->getRedirectRoute($user);
        
        return redirect()->intended($redirectUrl);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}