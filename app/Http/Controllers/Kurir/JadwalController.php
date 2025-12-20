<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\JadwalKurir;
use App\Models\Donasi; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = JadwalKurir::where('user_id', Auth::id())->get();
        // Ambil donasi yang belum ada kurirnya (status 'pending')
        $tugasTersedia = Donasi::where('status', 'pending')->get();

        return view('kurir.jadwal.index', [
        'tugasSaya' => $jadwals,        // <--- Kita ubah namanya di sini
        'tugasTersedia' => $tugasTersedia
    ]);
    }

    // --- TAMBAHKAN DUA METHOD INI ---

    // 1. Method CREATE (Menampilkan Form)
    public function create()
    {
        // Kita butuh data donasi yang statusnya 'pending' untuk dipilih kurir
        $donasis = Donasi::where('status', 'pending')->get();
        
        return view('kurir.jadwal.create', compact('donasis'));
    }

    // 2. Method STORE (Menyimpan Jadwal Baru)
    public function store(Request $request)
    {
        $request->validate([
            'donasi_id' => 'required|exists:donasis,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string'
        ]);

        // Simpan ke tabel jadwal_kurirs
        JadwalKurir::create([
            'user_id' => Auth::id(), // ID Kurir yang login
            'donasi_id' => $request->donasi_id,
            'tanggal_pengambilan' => $request->tanggal, // Sesuaikan dengan nama kolom DB Anda
            'status' => 'dijemput', // Status awal pengantaran
            'catatan' => $request->catatan,
        ]);

        // Opsional: Update status di tabel Donasi agar tidak muncul lagi di list 'Tugas Tersedia'
        $donasi = Donasi::find($request->donasi_id);
        $donasi->update(['status' => 'proses_kurir']); // Ubah status donasi

        return redirect()->route('kurir.jadwal.index')->with('success', 'Berhasil mengambil tugas!');
    }

    // Tambahkan/Update method ini
    public function updateStatus(Request $request, $id)
    {
        // 1. Cari jadwal berdasarkan ID
        $jadwal = JadwalKurir::findOrFail($id);

        // 2. Validasi status yang dikirim dari form
        $request->validate([
            'status' => 'required|in:on_the_way,delivered,failed' // Sesuaikan dengan Enum Migration
        ]);

        // 3. Update Status Jadwal Kurir
        $jadwal->update([
            'status' => $request->status
        ]);

        // 4. Update juga Status Donasi (Sinkronisasi)
        // Jika kurir bilang 'delivered', maka donasi jadi 'selesai' atau 'diterima'
        if ($request->status == 'delivered') {
            $jadwal->donasi->update(['status' => 'selesai']); 
        }

        return back()->with('success', 'Status pengantaran diperbarui!');
    }

    // --- TAMBAHKAN DI BAWAH METHOD STORE ---

    // 1. Method EDIT (Menampilkan Form)
    public function edit($id)
    {
        // Cari jadwal berdasarkan ID
        $jadwal = JadwalKurir::findOrFail($id);
        
        // Keamanan: Pastikan kurir hanya bisa edit jadwal miliknya sendiri
        if ($jadwal->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('kurir.jadwal.edit', compact('jadwal'));
    }

    // 2. Method UPDATE (Menyimpan Perubahan)
    public function update(Request $request, $id)
    {
        $jadwal = JadwalKurir::findOrFail($id);

        // Keamanan
        if ($jadwal->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'estimasi_waktu' => 'nullable|string',
            // Sesuaikan validasi status dengan Enum di database
            'status' => 'required|in:waiting,dijemput,on_the_way,delivered,failed',
            'catatan' => 'nullable|string'
        ]);

        // Update Data
        $jadwal->update([
            'tanggal_pengambilan' => $request->tanggal,
            'estimasi_waktu' => $request->estimasi_waktu,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);
        
        // Opsional: Jika status 'delivered', update donasi jadi selesai
        if ($request->status == 'delivered') {
            $jadwal->donasi->update(['status' => 'selesai']);
        }

        return redirect()->route('kurir.jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }
}