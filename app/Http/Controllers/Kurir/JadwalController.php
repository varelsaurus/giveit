<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\JadwalKurir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Menampilkan daftar tugas milik kurir yang sedang login.
     */
    public function index()
    {
        // Ambil jadwal DIMANA kurir_id = ID user yang login
        $jadwals = JadwalKurir::with(['pengajuan.donasi', 'pengajuan.penerima'])
                    ->where('kurir_id', Auth::id())
                    ->latest()
                    ->get();

        return view('kurir.jadwal.index', compact('jadwals'));
    }

    /**
     * Menampilkan detail tugas (alamat lengkap, no hp, dll).
     */
    public function show(JadwalKurir $jadwal)
    {
        // Pastikan kurir hanya melihat jadwal miliknya sendiri
        if ($jadwal->kurir_id !== Auth::id()) {
            abort(403);
        }

        return view('kurir.jadwal.show', compact('jadwal'));
    }

    /**
     * Tampilkan form edit status (Opsional, atau bisa langsung di index/show).
     */
    public function edit(JadwalKurir $jadwal)
    {
        if ($jadwal->kurir_id !== Auth::id()) {
            abort(403);
        }
        return view('kurir.jadwal.edit', compact('jadwal'));
    }

    /**
     * Proses update status pengiriman.
     */
    public function update(Request $request, JadwalKurir $jadwal)
    {
        if ($jadwal->kurir_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Menunggu Ambil,Dalam Perjalanan,Selesai,Gagal',
        ]);

        $jadwal->update(['status' => $request->status]);

        // OPSIONAL: Jika status Selesai, update juga status Pengajuan & Donasi jadi Selesai
        if ($request->status == 'Selesai') {
            $jadwal->pengajuan->update(['status' => 'Selesai']);
            $jadwal->pengajuan->donasi->update(['status' => 'Selesai']);
        }

        return redirect()->route('kurir.jadwal.index')->with('success', 'Status pengiriman berhasil diperbarui.');
    }
}