<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\PengajuanDonasi;
use App\Models\KebutuhanPakaian; // <--- Pastikan Import Ini
use Illuminate\Http\Request;

class DonasiManagementController extends Controller
{
    public function index()
    {
        $donasis = Donasi::with('user')->latest()->get();
        return view('admin.donasi.index', compact('donasis'));
    }

    /**
     * MENU GABUNGAN: Persetujuan Pengajuan & Daftar Kebutuhan
     */
    public function listPengajuan()
    {
        // 1. Ambil data Pengajuan (Klaim Barang)
        $pengajuans = PengajuanDonasi::with(['user', 'donasi.user'])
                        ->whereIn('status', ['pending', 'Pending', 'Menunggu']) 
                        ->latest()
                        ->get();

        // 2. Ambil data Kebutuhan (Wishlist Penerima)
        $kebutuhans = KebutuhanPakaian::with('user')->latest()->get();

        // Kirim keduanya ke view
        return view('admin.pengajuan.index', compact('pengajuans', 'kebutuhans'));
    }

    public function updateStatus($id)
    {
        $donasi = Donasi::findOrFail($id);
        return view('admin.donasi.update_status', compact('donasi'));
    }

    public function updateStatusProcess(Request $request, $id)
    {
        $donasi = Donasi::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,proses_kurir,selesai', 
        ]);
        $donasi->status = $request->status;
        $donasi->save();
        return redirect()->route('admin.donasi.index')->with('success', 'Status donasi berhasil diperbarui!');
    }

    public function approvePengajuan(Request $request, $id)
    {
        $pengajuan = PengajuanDonasi::findOrFail($id);
        $pengajuan->update(['status' => 'approved']);
        if($pengajuan->donasi) {
            $pengajuan->donasi->update(['status' => 'approved']);
        }
        return back()->with('success', 'Pengajuan disetujui. Barang kini berstatus "Approved".');
    }

    public function destroy($id)
    {
        $donasi = Donasi::findOrFail($id);
        $donasi->delete();
        return back()->with('success', 'Data donasi berhasil dihapus.');
    }
    
    public function generateReport()
    {
        $donasis = Donasi::with('user')->latest()->get();
        return view('admin.report.index', compact('donasis'));
    }

    // Method listKebutuhan() bisa dihapus atau dibiarkan saja
}