<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\PengajuanDonasi;
use App\Models\KebutuhanPakaian; // Import Model Kebutuhan
use Illuminate\Http\Request;

class DonasiManagementController extends Controller
{
    /**
     * 1. MENU KELOLA DATA DONASI
     * Menampilkan semua donasi yang masuk dari Donatur.
     */
    public function index()
    {
        $donasis = Donasi::with('user')->latest()->get();
        return view('admin.donasi.index', compact('donasis'));
    }

    /**
     * 2. MENU PERSETUJUAN PENGAJUAN (GABUNGAN)
     * Menampilkan:
     * A. Request barang dari Penerima (PengajuanDonasi)
     * B. Wishlist/Kebutuhan Penerima (KebutuhanPakaian)
     */
    public function listPengajuan()
    {
        // A. Ambil Data Pengajuan (Klaim Barang yang sudah ada)
        $pengajuans = PengajuanDonasi::with(['user', 'donasi.user'])
                        ->whereIn('status', ['pending', 'Pending', 'Menunggu']) 
                        ->latest()
                        ->get();

        // B. Ambil Data Kebutuhan (Wishlist Penerima)
        $kebutuhans = KebutuhanPakaian::with('user')->latest()->get();

        // Kirim KEDUA variabel ke view yang sama
        return view('admin.pengajuan.index', compact('pengajuans', 'kebutuhans'));
    }

    /**
     * 3. HALAMAN EDIT STATUS
     */
    public function updateStatus($id)
    {
        $donasi = Donasi::findOrFail($id);
        return view('admin.donasi.update_status', compact('donasi'));
    }

    /**
     * 4. PROSES SIMPAN STATUS BARU
     */
    public function updateStatusProcess(Request $request, $id)
    {
        $donasi = Donasi::findOrFail($id);
    
        // Validasi sesuai ENUM database
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,proses_kurir,selesai', 
        ]);
    
        $donasi->status = $request->status;
        $donasi->save();
    
        return redirect()->route('admin.donasi.index')->with('success', 'Status donasi berhasil diperbarui!');
    }

    /**
     * 5. APPROVE PENGAJUAN (Setujui Klaim Barang)
     */
    public function approvePengajuan(Request $request, $id)
    {
        $pengajuan = PengajuanDonasi::findOrFail($id);

        // Ubah status pengajuan jadi approved
        $pengajuan->update(['status' => 'approved']);

        // Ubah status barang donasi jadi approved juga (agar tidak bisa diklaim orang lain)
        if($pengajuan->donasi) {
            $pengajuan->donasi->update(['status' => 'approved']);
        }

        return back()->with('success', 'Pengajuan disetujui. Barang kini berstatus "Approved".');
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