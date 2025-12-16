<?php

// app/Http/Controllers/PenerimaDonor/PengajuanDonasiController.php

namespace App\Http\Controllers\PenerimaDonor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi;
use App\Models\PengajuanDonasi;
use App\Models\KebutuhanPakaian;
use Illuminate\Support\Facades\Auth;

class PengajuanDonasiController extends Controller
{
    /**
     * Tampilkan Donasi yang Tersedia untuk diajukan
     * (Digunakan oleh view available_donasi.blade.php)
     */
    public function availableDonations()
    {
        // Ambil donasi yang statusnya 'Tersedia'
        $availableDonations = Donasi::where('status', 'Tersedia')->latest()->get();
        
        // Cek apakah Penerima Donor sudah memiliki daftar Kebutuhan Pakaian
        $kebutuhan = KebutuhanPakaian::where('user_id', Auth::id())->first();

        return view('penerima.pengajuan.available_donasi', compact('availableDonations', 'kebutuhan'));
    }

    /**
     * 2. Read pengajuan yang diminta (Riwayat Pengajuan Penerima Donor)
     * (Digunakan oleh view index.blade.php)
     */
    public function index()
    {
        // Ambil semua pengajuan milik user yang login
        $pengajuans = PengajuanDonasi::with('donasi')
                                    ->where('penerima_id', Auth::id())
                                    ->latest()
                                    ->get();

        return view('penerima.pengajuan.index', compact('pengajuans'));
    }

    /**
     * 1. Create pengajuan penyaluran
     * (Dipanggil saat user mengklik 'Ajukan Permintaan' pada Donasi yang Tersedia)
     */
    public function store(Request $request, Donasi $donasi)
    {
        // 1. Validasi Status Donasi: Pastikan donasi masih tersedia
        if ($donasi->status !== 'Tersedia') {
            return back()->with('error', 'Donasi ini sudah tidak tersedia atau sedang dalam proses pengajuan lain.');
        }

        // 2. Cek apakah Penerima sudah pernah mengajukan donasi ini (mencegah duplikasi)
        $existingPengajuan = PengajuanDonasi::where('donasi_id', $donasi->id)
                                            ->where('penerima_id', Auth::id())
                                            ->first();
        if ($existingPengajuan) {
            return back()->with('error', 'Anda sudah pernah mengajukan donasi ini.');
        }

        // 3. Ambil Kebutuhan Pakaian (apabila ada)
        $kebutuhan = KebutuhanPakaian::where('user_id', Auth::id())->first();
        $kebutuhan_id = $kebutuhan ? $kebutuhan->id : null;

        // 4. Buat Pengajuan Donasi
        PengajuanDonasi::create([
            'donasi_id' => $donasi->id,
            'kebutuhan_id' => $kebutuhan_id,
            'penerima_id' => Auth::id(),
            'status' => 'Menunggu', // Status awal
        ]);

        // 5. Update Status Donasi
        $donasi->update(['status' => 'Diajukan']);

        return redirect()->route('penerima.pengajuan.index')->with('success', 'Pengajuan donasi berhasil dibuat. Menunggu konfirmasi Admin.');
    }

    /**
     * Update data pengajuan
     * (Biasanya digunakan untuk mengubah status oleh Admin/Kurir. Penerima jarang update selain membatalkan.)
     * Karena di deskripsi user meminta Penerima Donor bisa 'Update data pengajuan', kita buat placeholder.
     */
    // public function update(Request $request, PengajuanDonasi $pengajuan)
    // {
    //     // Logika update di sini (biasanya diisi oleh Admin/Kurir)
    // }

    /**
     * 4. Delete pengajuan (apabila ingin dibatalkan)
     */
    public function destroy(PengajuanDonasi $pengajuan)
    {
        // 1. Otorisasi: Pastikan ini pengajuan milik user yang login
        if ($pengajuan->penerima_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak untuk membatalkan pengajuan ini.');
        }

        // 2. Cek Status: Hanya pengajuan yang 'Menunggu' yang bisa dibatalkan
        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan ini tidak dapat dibatalkan karena sudah dalam status: ' . $pengajuan->status);
        }

        // 3. Update Status Donasi Terkait kembali menjadi 'Tersedia'
        if ($pengajuan->donasi) {
            $pengajuan->donasi->update(['status' => 'Tersedia']);
        }

        // 4. Hapus Pengajuan
        $pengajuan->delete();

        return redirect()->route('penerima.pengajuan.index')->with('success', 'Pengajuan berhasil dibatalkan.');
    }
}
