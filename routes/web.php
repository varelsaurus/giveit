<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DonasiManagementController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Donatur\DonasiController;
use App\Http\Controllers\PenerimaDonor\KebutuhanPakaianController;
use App\Http\Controllers\PenerimaDonor\PengajuanDonasiController;
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

// Rute untuk melihat donasi yang tersedia (bisa diakses oleh semua yang sudah login, termasuk Penerima)
Route::middleware('auth')->get('/donasi-tersedia', [PengajuanDonasiController::class, 'availableDonations'])->name('donasi.available');

/*
|--------------------------------------------------------------------------
| Authenticated (Role-Based) Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // === ROLE ADMIN ===
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        // 1-4. Manage User (CRUD)
        Route::resource('user', UserController::class);

        // Manage Donasi
        Route::get('donasi', [DonasiManagementController::class, 'index'])->name('donasi.index'); // Read semua donasi
        // Rute untuk menampilkan form update status
        Route::get('donasi/{donasi}/status', [DonasiManagementController::class, 'updateStatus'])->name('donasi.updateStatus'); 
        // Rute untuk memproses update status
        Route::patch('donasi/{donasi}/status', [DonasiManagementController::class, 'updateStatusProcess'])->name('donasi.updateStatusProcess'); 
        Route::delete('donasi/{donasi}', [DonasiManagementController::class, 'destroy'])->name('donasi.destroy'); // Delete donasi
        
        // Persetujuan Pengajuan (Integrasi Kurir)
        Route::get('pengajuan', [DonasiManagementController::class, 'listPengajuan'])->name('pengajuan.index'); // List Pengajuan Menunggu
        Route::post('pengajuan/{pengajuan}/approve', [DonasiManagementController::class, 'approvePengajuan'])->name('pengajuan.approve'); // Proses Persetujuan & Buat Jadwal Kurir
        
        // Report
        Route::get('report/donasi', [DonasiManagementController::class, 'generateReport'])->name('report.donasi'); // Generate Report

    });

    // === ROLE DONATUR ===
    Route::middleware('role:donatur')->prefix('donatur')->name('donatur.')->group(function () {
    
    // Halaman list kebutuhan (Dashboard Donatur)
    Route::get('/kebutuhan-mendesak', [DonasiController::class, 'index'])->name('donasi.index');
    
    // Form Donasi (Merespon Kebutuhan Tertentu)
    Route::get('/bantu/{kebutuhanId}', [DonasiController::class, 'create'])->name('donasi.create');
    
    // Simpan Donasi
    Route::post('/donasi', [DonasiController::class, 'store'])->name('donasi.store');

    });

    // === ROLE PENERIMA DONOR ===
    Route::middleware('role:penerima_donor')->prefix('penerima')->name('penerima.')->group(function () {
        
        // 1-4. Kebutuhan Pakaian (CRUD)
        Route::resource('kebutuhan', KebutuhanPakaianController::class);

        // Pengajuan Donasi
        Route::get('pengajuan', [PengajuanDonasiController::class, 'index'])->name('pengajuan.index'); // Riwayat Pengajuan
        Route::post('pengajuan/ajukan/{donasi}', [PengajuanDonasiController::class, 'store'])->name('pengajuan.store'); // Proses pengajuan baru
        Route::patch('pengajuan/{pengajuan}', [PengajuanDonasiController::class, 'update'])->name('pengajuan.update'); // Update (misal: Batalkan)
        Route::delete('pengajuan/{pengajuan}', [PengajuanDonasiController::class, 'destroy'])->name('pengajuan.destroy'); // Delete/Batalkan

    });

    // === ROLE KURIR ===
    Route::middleware('role:kurir')->prefix('kurir')->name('kurir.')->group(function () {
        // 1-4. CRUD Jadwal Pengantaran
        Route::resource('jadwal', JadwalController::class);
    });
    
    // === PROFIL DEFAULT BREEZE (Untuk Semua Role) ===
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';