<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi;      // PENTING: Kita ambil data dari sini
use App\Models\JadwalKurir;
use Illuminate\Support\Facades\Auth;

class JadwalKurirController extends Controller
{
    public function index()
    {
        // 1. TUGAS TERSEDIA (POOL)
        // Ambil semua Donasi yang statusnya 'Butuh Kurir'
        // Kita load juga relasi 'pengajuan' untuk cek apakah ada penerimanya atau tidak
        $tugasTersedia = Donasi::with(['user', 'pengajuan.user'])
                            ->where('status', 'Butuh Kurir')
                            ->latest()
                            ->get();

        // 2. TUGAS SAYA (YANG SUDAH DIAMBIL)
        $tugasSaya = JadwalKurir::with(['donasi.user', 'donasi.pengajuan.user'])
                            ->where('user_id', Auth::id())
                            ->where('status', '!=', 'Selesai') // Tampilkan yang belum selesai
                            ->get();

        return view('kurir.jadwal.index', compact('tugasTersedia', 'tugasSaya'));
    }

    // Fungsi saat Kurir klik "Ambil Tugas"
    public function store(Request $request, $donasi_id)
    {
        $donasi = Donasi::findOrFail($donasi_id);

        // Cek dulu apakah masih butuh kurir (takutnya keduluan orang lain)
        if($donasi->status != 'Butuh Kurir') {
            return back()->with('error', 'Maaf, tugas ini sudah tidak tersedia.');
        }

        // 1. Buat Jadwal Kurir
        JadwalKurir::create([
            'user_id' => Auth::id(),
            'donasi_id' => $donasi->id,
            'status' => 'Sedang Dijemput',
            'tanggal_pengantaran' => now(), // Atau bisa input manual
        ]);

        // 2. Update Status Donasi jadi 'Proses Pengiriman'
        $donasi->update(['status' => 'Proses Pengiriman']);

        return back()->with('success', 'Tugas berhasil diambil! Segera lakukan penjemputan.');
    }

    // Fungsi update status pengantaran (misal: Selesai)
    public function update(Request $request, $id)
    {
        $jadwal = JadwalKurir::findOrFail($id);
        
        // Update jadwal jadi Selesai
        $jadwal->update(['status' => 'Selesai']);

        // Update donasi jadi Selesai
        $jadwal->donasi->update(['status' => 'Selesai']);
        
        // Jika ada pengajuan terkait, update juga jadi Selesai/Diterima
        if($jadwal->donasi->pengajuan) {
            $jadwal->donasi->pengajuan->update(['status' => 'Diterima']);
        }

        return back()->with('success', 'Pengantaran selesai! Terima kasih.');
    }
}