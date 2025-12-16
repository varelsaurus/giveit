<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi;
use App\Models\PengajuanDonasi;
use App\Models\JadwalKurir;
use App\Models\User;

class DonasiManagementController extends Controller
{
    /**
     * 2. Read donor (Melihat semua donasi) - Index
     */
    public function index()
    {
        // Menggunakan 'latest()' agar yang baru tampil diatas
        $donasis = Donasi::with('user')->latest()->get();
        return view('admin.donasi.index', compact('donasis'));
    }

    /**
     * Tampilkan form untuk mengubah status donasi (3. Update status donasi)
     */
    public function updateStatus(Donasi $donasi)
    {
        // Tampilkan form update_status
        return view('admin.donasi.update_status', compact('donasi'));
    }

    /**
     * Proses update status donasi (3. Update status donasi)
     */
    public function updateStatusProcess(Request $request, Donasi $donasi)
    {
        $request->validate([
            'status' => 'required|in:Tersedia,Diajukan,Dalam Pengiriman,Selesai,Dibatalkan',
        ]);

        $donasi->update(['status' => $request->status]);

        return redirect()->route('admin.donasi.index')->with('success', "Status donasi #{$donasi->id} berhasil diperbarui menjadi {$donasi->status}.");
    }

    /**
     * 4. Delete donasi
     */
    public function destroy(Donasi $donasi)
    {
        // Hapus file foto jika ada
        if ($donasi->foto && \Storage::disk('public')->exists($donasi->foto)) {
            \Storage::disk('public')->delete($donasi->foto);
        }

        $donasi->delete();

        return redirect()->route('admin.donasi.index')->with('success', 'Donasi berhasil dihapus.');
    }

    /**
     * 1. Create report (history donasi)
     */
    public function generateReport()
    {
        // Logic dummy untuk Report
        $total_donasi_selesai = Donasi::where('status', 'Selesai')->count();
        $total_donasi_proses = Donasi::whereIn('status', ['Diajukan', 'Dalam Pengiriman'])->count();
        $total_semua_donasi = Donasi::count();

        // Anda dapat mengambil data lebih detail di sini untuk ditampilkan di laporan

        return view('admin.donasi.report', compact(
            'total_donasi_selesai',
            'total_donasi_proses',
            'total_semua_donasi'
        ));
    }

    // ===============================================
    // LOGIKA PENGAJUAN (ADMIN)
    // ===============================================

    /**
     * Tampilkan daftar pengajuan yang perlu disetujui Admin.
     */
    public function listPengajuan()
    {
        // Mengambil semua pengajuan yang statusnya 'Menunggu'
        $pengajuans = PengajuanDonasi::with(['donasi.user', 'penerima']) // Eager load relasi
            ->where('status', 'Menunggu')
            ->latest()
            ->get();

        // Ambil Kurir yang tersedia untuk di-assign
        $kurirs = User::whereHas('role', function ($query) {
            $query->where('name', 'kurir');
        })->get();

        // Mengembalikan view 'admin.pengajuan.index' (bukan admin.donasi.list_pengajuan agar konsisten folder)
        return view('admin.pengajuan.index', compact('pengajuans', 'kurirs'));
    }

    /**
     * Proses Persetujuan Pengajuan dan Buat Jadwal Kurir.
     */
    public function approvePengajuan(Request $request, PengajuanDonasi $pengajuan)
    {
        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        // 1. Validasi Input Admin (memilih Kurir, menentukan jadwal)
        $request->validate([
            'kurir_id' => 'required|exists:users,id',
            'tanggal_ambil' => 'required|date',
            // 'tanggal_kirim' bisa opsional atau wajib, sesuaikan kebutuhan. 
            // Di sini saya buat wajib untuk kelengkapan jadwal.
            'tanggal_kirim' => 'nullable|date|after_or_equal:tanggal_ambil', 
        ]);

        // 2. Update Status Pengajuan & Donasi
        $pengajuan->update(['status' => 'Diproses']);
        
        // Status Donasi diubah jadi 'Diajukan' atau 'Dalam Pengiriman' tergantung alur bisnis Anda.
        // Jika 'Diajukan' berarti sudah dibooking. Jika 'Dalam Pengiriman' berarti kurir OTW.
        // Mari kita set ke 'Diajukan' dulu agar sinkron dengan logika bahwa Kurir baru dijadwalkan.
        $pengajuan->donasi->update(['status' => 'Diajukan']);

        // 3. Logika Membuat Jadwal Kurir (Tugas Pengiriman)
        
        // Pastikan Anda menangani kasus jika alamat user kosong
        // (Bisa gunakan accessor di Model User atau fallback string seperti di bawah)
        $alamat_donatur = $pengajuan->donasi->user->alamat ?? 'Alamat Donatur (User ID: '.$pengajuan->donasi->user_id.')';
        $alamat_penerima = $pengajuan->penerima->alamat ?? 'Alamat Penerima (User ID: '.$pengajuan->user_id.')';

        JadwalKurir::create([
            'kurir_id' => $request->kurir_id,
            'pengajuan_id' => $pengajuan->id,
            'tanggal_waktu_ambil' => $request->tanggal_ambil,
            'alamat_ambil' => $alamat_donatur,
            'alamat_kirim' => $alamat_penerima,
            'status' => 'Menunggu Ambil', // Status awal tugas kurir
        ]);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil disetujui dan tugas Kurir telah dibuat.');
    }
}