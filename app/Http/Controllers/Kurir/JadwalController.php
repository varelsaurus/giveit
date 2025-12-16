<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\JadwalKurir;
use App\Models\PengajuanDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // Tampilkan Tugas Tersedia & Jadwal Saya
    public function index()
    {
        // 1. Tugas Tersedia: Pengajuan disetujui admin DAN Donasi butuh kurir
        $tugasTersedia = PengajuanDonasi::where('status', 'Disetujui Admin')
                            ->whereHas('donasi', function($q) {
                                $q->where('status', 'Butuh Kurir');
                            })
                            ->with(['donasi.user', 'user']) // Load data donatur & penerima
                            ->get();

        // 2. Jadwal Saya: History tugas kurir yang sedang login
        $jadwalSaya = JadwalKurir::where('user_id', Auth::id())
                        ->with('donasi')
                        ->latest()
                        ->get();

        return view('kurir.jadwal.index', compact('tugasTersedia', 'jadwalSaya'));
    }

    // Form Ambil Tugas
    public function create(Request $request)
    {
        // Kita butuh ID pengajuan yang mau diambil
        $pengajuanId = $request->query('pengajuan_id');
        $pengajuan = PengajuanDonasi::findOrFail($pengajuanId);

        return view('kurir.jadwal.create', compact('pengajuan'));
    }

    // Proses Simpan Jadwal (Saat Kurir klik "Ambil Tugas")
    public function store(Request $request)
    {
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuan_donasis,id',
            'tanggal_pengiriman' => 'required|date|after_or_equal:today',
            'estimasi_waktu' => 'required|string',
        ]);

        $pengajuan = PengajuanDonasi::findOrFail($request->pengajuan_id);

        // 1. Buat Jadwal Kurir
        JadwalKurir::create([
            'user_id' => Auth::id(), // ID Kurir
            'donasi_id' => $pengajuan->donasi_id,
            'pengajuan_id' => $pengajuan->id,
            'tanggal_pengiriman' => $request->tanggal_pengiriman,
            'estimasi_waktu' => $request->estimasi_waktu,
            'status' => 'Menjemput Barang',
        ]);

        // 2. Update Status Pengajuan & Donasi
        $pengajuan->update(['status' => 'Kurir Menuju Lokasi']);
        $pengajuan->donasi->update(['status' => 'Proses Pengiriman']);

        return redirect()->route('kurir.jadwal.index')
                         ->with('success', 'Tugas berhasil diambil!');
    }

    // Update Status Pengiriman (Misal: Selesai)
    public function update(Request $request, JadwalKurir $jadwal)
    {
        // Validasi: Pastikan ini jadwal milik kurir yang login
        if($jadwal->user_id != Auth::id()) abort(403);

        $jadwal->update(['status' => $request->status]);

        if($request->status == 'Selesai') {
            $jadwal->donasi->update(['status' => 'Selesai']);
            $jadwal->pengajuan->update(['status' => 'Diterima']);
        }

        return back()->with('success', 'Status pengiriman diperbarui.');
    }

    public function destroy(JadwalKurir $jadwal)
    {
        // Opsi jika kurir membatalkan tugas (opsional logic)
        return back()->with('error', 'Pembatalan harus hubungi admin.');
    }
}