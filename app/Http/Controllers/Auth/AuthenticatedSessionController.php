<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; // Tambahkan ini untuk akses model User
use App\Providers\RouteServiceProvider; // Tambahkan ini untuk akses fallback route

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
            // Fallback default jika role tidak ada (seperti default Breeze)
            return RouteServiceProvider::HOME; 
        }

        switch ($user->role->name) {
            case 'admin':
                // Rute yang kita definisikan: /admin/user
                return route('admin.user.index');
                
            case 'donatur':
                // Rute yang kita definisikan: /donatur/donasi
                return route('donatur.donasi.index');
                
            case 'penerima_donor':
                // Rute yang kita definisikan: /penerima/kebutuhan
                return route('penerima.kebutuhan.index');
                
            case 'kurir':
                // Rute yang kita definisikan: /kurir/jadwal
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
        
        // Menggunakan redirect()->intended() jika ada URL yang dicoba diakses sebelum login.
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