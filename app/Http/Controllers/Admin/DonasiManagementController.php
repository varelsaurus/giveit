<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\PengajuanDonasi;
use Illuminate\Http\Request;

class DonasiManagementController extends Controller
{
    /**
     * 1. MENU KELOLA DATA DONASI
     * Menampilkan semua donasi yang masuk dari Donatur.
     */
    public function index()
    {
        // Menggunakan variabel $donasis (JAMAK) karena datanya banyak
        $donasis = Donasi::with('user')->latest()->get();
        return view('admin.donasi.index', compact('donasis'));
    }

    /**
     * 2. MENU PERSETUJUAN PENGAJUAN
     * Menampilkan request barang dari Penerima yang statusnya 'Menunggu'.
     */
    public function listPengajuan()
    {
        // Ambil data pengajuan yang statusnya 'pending' atau 'Menunggu'
        // Pastikan nama variabelnya $pengajuans
        $pengajuans = PengajuanDonasi::with(['user', 'donasi.user'])
                        ->where('status', 'pending') // Sesuaikan dengan enum Anda (pending/Menunggu)
                        ->latest()
                        ->get();

        // Kirim ke view dengan nama 'pengajuans'
        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    /**
     * 3. HALAMAN EDIT STATUS (Form Update)
     * Mengatasi error 'Undefined variable $donasi'
     */
    public function updateStatus($id)
    {
        // Kita cari data berdasarkan ID
        $donasi = Donasi::findOrFail($id);

        // PENTING: Variabel '$donasi' (TUNGGAL) dikirim ke view
        // Ini biar cocok dengan compact('donasi')
        return view('admin.donasi.edit-status', compact('donasi'));
    }

    /**
     * 4. PROSES SIMPAN STATUS BARU
     * Admin mengubah status manual (misal: Tersedia -> Butuh Kurir)
     */
    public function updateStatusProcess(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Tersedia,Butuh Kurir,Proses Pengiriman,Selesai'
        ]);

        $donasi = Donasi::findOrFail($id);
        
        $donasi->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.donasi.index')->with('success', 'Status donasi berhasil diperbarui.');
    }

    /**
     * 5. APPROVE PENGAJUAN
     * Saat Admin menyetujui pengajuan penerima.
     * Logika: Status Pengajuan -> Disetujui, Status Donasi -> Butuh Kurir.
     */
    public function approvePengajuan(Request $request, $id)
    {
        // Cari pengajuan
        $pengajuan = PengajuanDonasi::findOrFail($id);

        // 1. Ubah status pengajuan jadi Disetujui
        $pengajuan->update(['status' => 'Disetujui Admin']);

        // 2. Ubah status Barang Donasi jadi 'Butuh Kurir'
        // Supaya otomatis muncul di Dashboard Kurir
        if($pengajuan->donasi) {
            $pengajuan->donasi->update(['status' => 'Butuh Kurir']);
        }

        return back()->with('success', 'Pengajuan disetujui. Barang kini berstatus "Butuh Kurir".');
    }

    /**
     * 6. HAPUS DONASI
     */
    public function destroy($id)
    {
        $donasi = Donasi::findOrFail($id);
        $donasi->delete();
        
        return back()->with('success', 'Data donasi berhasil dihapus.');
    }
    
    /**
     * 7. LAPORAN DONASI
     */
    public function generateReport()
    {
        $donasis = Donasi::with('user')->latest()->get();
        return view('admin.report.index', compact('donasis'));
    }
}