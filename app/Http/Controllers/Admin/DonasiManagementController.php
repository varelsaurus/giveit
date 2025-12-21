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
        // Mengambil semua donasi urut dari yang terbaru
        $donasis = Donasi::with('user')->latest()->get();
        return view('admin.donasi.index', compact('donasis'));
    }

    /**
     * 2. MENU PERSETUJUAN PENGAJUAN
     * Menampilkan request barang dari Penerima yang statusnya 'pending' / 'Menunggu'.
     */
    public function listPengajuan()
    {
        // Pastikan nama variabel 'pengajuans' agar cocok dengan view
        $pengajuans = PengajuanDonasi::with(['user', 'donasi.user'])
                        ->where('status', 'pending') // Sesuaikan value ini dengan database pengajuan
                        ->latest()
                        ->get();

        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    /**
     * 3. HALAMAN EDIT STATUS (Form Update)
     * Menampilkan form untuk admin mengubah status donasi manual.
     */
    public function updateStatus($id)
    {
        $donasi = Donasi::findOrFail($id);

        // Pastikan nama view sesuai dengan file yang Anda buat sebelumnya
        // (admin/donasi/update_status.blade.php)
        return view('admin.donasi.update_status', compact('donasi'));
    }

    /**
     * 4. PROSES SIMPAN STATUS BARU
     * Menangani perubahan status donasi ke database.
     */
    public function updateStatusProcess(Request $request, $id)
    {
        $donasi = Donasi::findOrFail($id);
    
        // VALIDASI: Value harus sama persis dengan ENUM di Database
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,proses_kurir,selesai', 
        ]);
    
        // Update Manual (Paling Aman untuk menghindari bug fillable)
        $donasi->status = $request->status;
        $donasi->save();
    
        return redirect()->route('admin.donasi.index')->with('success', 'Status donasi berhasil diperbarui!');
    }

    /**
     * 5. APPROVE PENGAJUAN
     * Saat Admin menyetujui pengajuan penerima.
     */
    public function approvePengajuan(Request $request, $id)
    {
        // Cari data pengajuan
        $pengajuan = PengajuanDonasi::findOrFail($id);

        // 1. Ubah status pengajuan jadi 'approved' (atau 'disetujui')
        // Pastikan value ini sesuai dengan ENUM/Varchar di tabel 'pengajuan_donasis'
        $pengajuan->update(['status' => 'approved']);

        // 2. Ubah status Barang Donasi
        // PERBAIKAN: Jangan gunakan 'Butuh Kurir' karena tidak ada di ENUM donasis.
        // Gunakan 'approved' (artinya sudah diverifikasi admin & siap diambil kurir)
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
     * 7. LAPORAN DONASI (Opsional, jika masih dipakai)
     */
    public function generateReport()
    {
        $donasis = Donasi::with('user')->latest()->get();
        return view('admin.report.index', compact('donasis'));
    }
}