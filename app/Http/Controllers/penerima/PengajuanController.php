<?php

namespace App\Http\Controllers\Penerima;

use App\Http\Controllers\Controller;
use App\Models\PengajuanDonasi;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * ---------------------------------------------------------------------
     * TAMBAHAN: READ AVAILABLE DONATIONS (Langkah Awal Create)
     * Menampilkan daftar donasi yang statusnya 'Tersedia' agar bisa diajukan.
     * ---------------------------------------------------------------------
     */
    public function availableDonations()
    {
        // Ambil donasi yang statusnya 'Tersedia' atau 'pending' (sesuaikan dengan enum di database Anda)
        // Asumsi: Status awal donasi yang bisa diklaim adalah 'Tersedia'
        $donasis = Donasi::where('status', 'Tersedia') 
                         ->latest()
                         ->get();

        return view('penerima.donasi.available', compact('donasis'));
    }

    /**
     * ---------------------------------------------------------------------
     * 2. READ: Read pengajuan yang diminta
     * Menampilkan riwayat pengajuan milik user yang sedang login.
     * ---------------------------------------------------------------------
     */
    public function index()
    {
        $pengajuans = PengajuanDonasi::where('user_id', Auth::id())
                        ->with('donasi') // Pastikan Model PengajuanDonasi punya relasi public function donasi()
                        ->latest()
                        ->get();

        return view('penerima.pengajuan.index', compact('pengajuans'));
    }

    /**
     * ---------------------------------------------------------------------
     * 1. CREATE: Create pengajuan penyaluran
     * Saat klik "Ajukan" dari list donasi yang tersedia.
     * ---------------------------------------------------------------------
     */
    public function store(Request $request, $donasiId)
    {
        $donasi = Donasi::findOrFail($donasiId);

        // Validasi: Cek ketersediaan
        if ($donasi->status != 'Tersedia') { // Sesuaikan string status dengan database Anda
            return back()->with('error', 'Maaf, donasi ini sudah tidak tersedia atau sedang diproses orang lain.');
        }

        // Validasi: Cek duplikasi pengajuan
        $cek = PengajuanDonasi::where('user_id', Auth::id())
                              ->where('donasi_id', $donasiId)
                              ->first();
        
        if($cek) {
            return back()->with('error', 'Anda sudah mengajukan permintaan untuk donasi ini.');
        }

        // Simpan Pengajuan
        PengajuanDonasi::create([
            'user_id' => Auth::id(),
            'donasi_id' => $donasiId,
            'status' => 'Menunggu', // Default status: Menunggu Konfirmasi Admin
            'alasan' => $request->input('alasan', 'Saya membutuhkan barang ini untuk keperluan mendesak.')
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim. Silakan pantau statusnya di menu Riwayat Pengajuan.');
    }

    /**
     * ---------------------------------------------------------------------
     * 3. UPDATE: Update data pengajuan
     * Mengubah alasan atau data pengajuan (Hanya bisa jika status masih 'Menunggu')
     * ---------------------------------------------------------------------
     */
    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanDonasi::where('user_id', Auth::id())->findOrFail($id);

        // Validasi Status
        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan yang sudah diproses atau disetujui tidak dapat diedit.');
        }

        $request->validate([
            'alasan' => 'required|string|max:255',
        ]);

        $pengajuan->update([
            'alasan' => $request->alasan
        ]);

        return back()->with('success', 'Data pengajuan berhasil diperbarui.');
    }

    /**
     * ---------------------------------------------------------------------
     * 4. DELETE: Delete pengajuan
     * Membatalkan pengajuan (Hanya bisa jika status masih 'Menunggu')
     * ---------------------------------------------------------------------
     */
    public function destroy($id)
    {
        $pengajuan = PengajuanDonasi::where('user_id', Auth::id())->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan yang sudah diproses tidak bisa dibatalkan.');
        }

        $pengajuan->delete();
        
        return back()->with('success', 'Pengajuan berhasil dibatalkan/dihapus.');
    }
}