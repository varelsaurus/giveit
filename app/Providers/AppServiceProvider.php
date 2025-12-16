<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Daftarkan semua layout kustom sebagai komponen Blade View
        Blade::component('components.admin-layout', 'admin-layout');
        Blade::component('components.donatur-layout', 'donatur-layout');
        Blade::component('components.penerima-layout', 'penerima-layout');
        Blade::component('components.kurir-layout', 'kurir-layout');
    }
}
