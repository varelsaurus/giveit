<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\PengajuanDonasi;
use Illuminate\Http\Request;

class DonasiManagementController extends Controller
{
    // List semua donasi (Menu Donasi)
    public function index()
    {
        $donasi = Donasi::with('user')->latest()->get();
        return view('admin.donasi.index', compact('donasi'));
    }

    // List pengajuan masuk (Menu Persetujuan)
    public function listPengajuan()
    {
        // Ambil pengajuan yang statusnya masih 'Menunggu'
        $pengajuan = PengajuanDonasi::with(['donasi', 'user'])
                        ->where('status', 'Menunggu')
                        ->get();
                        
        return view('admin.pengajuan.index', compact('pengajuan'));
    }

    // UPDATE STATUS DONASI (Manual)
    public function updateStatus(Donasi $donasi)
    {
        return view('admin.donasi.edit-status', compact('donasi'));
    }

    public function updateStatusProcess(Request $request, Donasi $donasi)
    {
        $donasi->update(['status' => $request->status]);
        return redirect()->route('admin.donasi.index')->with('success', 'Status donasi diperbarui');
    }

    // APPROVE PENGAJUAN (PENTING: Hanya ubah status, Kurir yang ambil nanti)
    public function approvePengajuan(Request $request, PengajuanDonasi $pengajuan)
    {
        // 1. Ubah status pengajuan
        $pengajuan->update(['status' => 'Disetujui Admin']);

        // 2. Ubah status donasi jadi 'Butuh Kurir' agar muncul di dashboard Kurir
        $pengajuan->donasi->update(['status' => 'Butuh Kurir']);

        return back()->with('success', 'Pengajuan disetujui. Menunggu Kurir mengambil tugas.');
    }

    public function destroy(Donasi $donasi)
    {
        $donasi->delete();
        return back()->with('success', 'Donasi dihapus');
    }
    
    public function generateReport()
    {
        return view('admin.report.index');
    }
}