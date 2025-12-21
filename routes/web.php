<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- IMPORT CONTROLLER ---
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DonasiManagementController;
use App\Http\Controllers\Admin\ReportController; 
use App\Http\Controllers\Donatur\DonasiController;
use App\Http\Controllers\Penerima\KebutuhanController;
use App\Http\Controllers\Penerima\PengajuanController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Kurir\JadwalController;

/*
|--------------------------------------------------------------------------
| Public & Default Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated (Role-Based) Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // ====================================================
    // 1. ROLE ADMIN
    // ====================================================
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        // CRUD User
        Route::resource('user', AdminUserController::class);

        // --- MANAGE DONASI ---
        Route::get('donasi', [DonasiManagementController::class, 'index'])->name('donasi.index'); 
        
        // Update Status Donasi
        Route::get('donasi/{id}/status', [DonasiManagementController::class, 'updateStatus'])->name('donasi.updateStatus');
        Route::patch('donasi/{id}/status', [DonasiManagementController::class, 'updateStatusProcess'])->name('donasi.updateStatusProcess');
        Route::delete('donasi/{id}', [DonasiManagementController::class, 'destroy'])->name('donasi.destroy');
        
        // --- MANAGE PENGAJUAN (APPROVAL BARANG KELUAR) ---
        Route::get('pengajuan', [DonasiManagementController::class, 'listPengajuan'])->name('pengajuan.index');
        Route::post('pengajuan/{id}/approve', [DonasiManagementController::class, 'approvePengajuan'])->name('pengajuan.approve');

        // --- MANAGE KEBUTUHAN (WISHLIST PENERIMA) ---
        // Ini route baru agar admin bisa melihat postingan kebutuhan penerima
        Route::get('kebutuhan-penerima', [DonasiManagementController::class, 'listKebutuhan'])->name('kebutuhan.index');

        // --- MANAGE BERITA ---
        Route::resource('berita', BeritaController::class)->parameters([
            'berita' => 'berita'
        ]);

        // --- MANAGE REPORT ---
        Route::resource('report', ReportController::class);
    });

    // ====================================================
    // 2. ROLE DONATUR
    // ====================================================
    Route::middleware('role:donatur')->group(function () {
        Route::resource('donasi', DonasiController::class);
        Route::get('donasi/bantu/{kebutuhan_id}', [DonasiController::class, 'create'])->name('donasi.bantu');
    });

    // ====================================================
    // 3. ROLE PENERIMA
    // ====================================================
    Route::middleware('role:penerima')->prefix('penerima')->name('penerima.')->group(function () {
        // CRUD Kebutuhan Pakaian
        Route::resource('kebutuhan', KebutuhanController::class);

        // --- FITUR PENGAJUAN DONASI ---
        Route::get('donasi-tersedia', [PengajuanController::class, 'availableDonations'])->name('donasi.available');
        Route::get('pengajuan', [PengajuanController::class, 'index'])->name('pengajuan.index');
        Route::post('donasi/{id}/ajukan', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::patch('pengajuan/{id}', [PengajuanController::class, 'update'])->name('pengajuan.update');
        Route::delete('pengajuan/{id}', [PengajuanController::class, 'destroy'])->name('pengajuan.destroy');
    });

    // ====================================================
    // 4. ROLE KURIR
    // ====================================================
    Route::middleware('role:kurir')->prefix('kurir')->name('kurir.')->group(function () {
        Route::resource('jadwal', JadwalController::class);
        Route::patch('jadwal/{id}/status', [JadwalController::class, 'updateStatus'])->name('jadwal.status');
    });

    // ====================================================
    // PROFILE
    // ====================================================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';