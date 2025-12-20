<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; 

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
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // --- MODIFIKASI DIMULAI DARI SINI ---
        
        // Ambil role user yang sedang login
        $role = $request->user()->role;

        // Cek role dan arahkan ke route yang sesuai
        switch ($role) {
            case 'admin':
                // Arahkan admin ke Manage User
                return redirect()->route('admin.user.index');
            
            case 'penerima':
                // Arahkan penerima ke List Kebutuhan
                return redirect()->route('penerima.kebutuhan.index');
            
            case 'kurir':
                // Arahkan kurir ke Jadwal Pengantaran
                return redirect()->route('kurir.jadwal.index');
            
            case 'donatur':
                // Arahkan donatur ke List Donasi
                return redirect()->route('donasi.index'); // Sesuaikan dengan nama route resource donasi Anda
            
            default:
                // Fallback jika role tidak dikenali, ke dashboard umum
                return redirect()->route('dashboard');
        }
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
                // Opsi Paling Aman:
                return redirect()->intended(route('dashboard', absolute: false));
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