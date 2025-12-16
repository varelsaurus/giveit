<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\KebutuhanPakaian; // Model Kebutuhan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonasiController extends Controller
{
    // HALAMAN UTAMA DONATUR: Melihat Daftar Kebutuhan Yayasan
    public function index()
    {
        // Tampilkan kebutuhan yang statusnya 'Belum Terpenuhi'
        $daftarKebutuhan = KebutuhanPakaian::with('user')
                            ->where('status', 'Belum Terpenuhi')
                            ->latest()
                            ->get();

        return view('donatur.dashboard-donasi', compact('daftarKebutuhan'));
    }

    // FORM DONASI: Saat Donatur klik "Bantu" pada salah satu kebutuhan
    public function create($kebutuhanId)
    {
        $kebutuhan = KebutuhanPakaian::findOrFail($kebutuhanId);
        return view('donatur.donasi.create', compact('kebutuhan'));
    }

    // PROSES SIMPAN: Donatur mengirim barang untuk kebutuhan tsb
    public function store(Request $request)
    {
        $request->validate([
            'kebutuhan_id' => 'required|exists:kebutuhan_pakaians,id',
            'nama_barang' => 'required|string', // Bisa diisi otomatis sama dengan nama kebutuhan
            'deskripsi' => 'required|string',
            'jumlah' => 'required|integer', 
            // 'alamat_jemput' => 'required' // Jika ingin dijemput kurir
        ]);

        // 1. Simpan Donasi
        $donasi = Donasi::create([
            'user_id' => Auth::id(),
            'kebutuhan_id' => $request->kebutuhan_id, // Link ke kebutuhan
            'nama_barang' => $request->nama_barang,
            'deskripsi' => $request->deskripsi,
            'status' => 'Tersedia', // Tersedia untuk diproses Admin/Kurir
            // Tambahkan field lain seperti alamat_jemput jika ada
        ]);

        // 2. (Opsional) Update status kebutuhan jika jumlah terpenuhi
        // Logic ini bisa dikembangkan nanti, misal:
        // $kebutuhan = KebutuhanPakaian::find($request->kebutuhan_id);
        // if($request->jumlah >= $kebutuhan->jumlah) $kebutuhan->update(['status' => 'Terpenuhi']);

        return redirect()->route('donatur.donasi.index')
                         ->with('success', 'Terima kasih! Donasi Anda telah tercatat. Admin akan memproses kurir.');
    }
}