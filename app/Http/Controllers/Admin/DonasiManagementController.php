<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi;
use App\Models\PengajuanDonasi; // Diperlukan untuk list dan approve pengajuan
use App\Models\JadwalKurir;     // Diperlukan untuk membuat tugas Kurir
use App\Models\User;           // Diperlukan untuk mencari Kurir

class DonasiManagementController extends Controller
{
    /**
     * 2. Read donor (Melihat semua donasi) - Index
     */
    public function index()
    {
        // Ambil semua donasi dengan data Donatur (User)
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
        // Anda mungkin perlu memastikan tidak ada pengajuan terkait yang masih aktif sebelum menghapus
        // Jika Anda menggunakan onDelete('cascade') di migrasi, relasi terkait akan otomatis terhapus.

        $donasi->delete();
        return redirect()->route('admin.donasi.index')->with('success', 'Donasi berhasil dihapus secara permanen.');
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
        $pengajuans = PengajuanDonasi::with(['donasi.user', 'penerima.role'])
                                      ->where('status', 'Menunggu')
                                      ->latest()
                                      ->get();
        
        // Ambil Kurir yang tersedia untuk di-assign
        $kurirs = User::whereHas('role', function ($query) {
            $query->where('name', 'kurir');
        })->get();

        return view('admin.donasi.list_pengajuan', compact('pengajuans', 'kurirs'));
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
            'tanggal_kirim' => 'required|date|after_or_equal:tanggal_ambil',
        ]);

        // 2. Update Status Pengajuan & Donasi
        $pengajuan->update(['status' => 'Diproses']);
        $pengajuan->donasi->update(['status' => 'Dalam Pengiriman']);

        // 3. Logika Membuat Jadwal Kurir (Tugas Pengiriman)
        
        // Catatan: Anda HARUS memastikan kolom 'alamat' telah ditambahkan di tabel 'users' 
        // dan diisi saat pendaftaran/update profil.
        $alamat_donatur = $pengajuan->donasi->user->alamat ?? 'Alamat Donatur Belum Lengkap';
        $alamat_penerima = $pengajuan->penerima->alamat ?? 'Alamat Penerima Belum Lengkap';

        JadwalKurir::create([
            'kurir_id' => $request->kurir_id,
            'pengajuan_id' => $pengajuan->id,
            'tanggal_waktu_ambil' => $request->tanggal_ambil,
            'tanggal_waktu_kirim' => $request->tanggal_kirim,
            'alamat_ambil' => $alamat_donatur,
            'alamat_kirim' => $alamat_penerima,
            'status' => 'Menunggu Ambil',
        ]);

        return redirect()->route('admin.pengajuan.index')->with('success', 'Pengajuan berhasil disetujui dan tugas Kurir telah dibuat.');
    }
}