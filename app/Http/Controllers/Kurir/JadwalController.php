<?php

namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donasi;      
use App\Models\JadwalKurir;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // 1. READ
    public function index()
    {
        $tugasTersedia = Donasi::with(['user', 'pengajuan.user'])
                            ->where('status', 'Butuh Kurir')
                            ->latest()->get();

        $tugasSaya = JadwalKurir::with(['donasi.user', 'donasi.pengajuan.user'])
                            ->where('user_id', Auth::id())
                            ->where('status', '!=', 'Selesai') 
                            ->get();

        return view('kurir.jadwal.index', compact('tugasTersedia', 'tugasSaya'));
    }

    // 2. CREATE (Tampilkan Form)
    public function create($donasi_id)
    {
        $donasi = Donasi::findOrFail($donasi_id);
        
        // Cek dulu, jangan sampe ambil tugas yang udah diambil orang
        if($donasi->status != 'Butuh Kurir') {
            return redirect()->route('kurir.jadwal.index')->with('error', 'Tugas tidak tersedia.');
        }

        return view('kurir.jadwal.create', compact('donasi'));
    }

    // 2. STORE (Simpan Data ke DB)
    public function store(Request $request, $donasi_id)
    {
        $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'estimasi_waktu' => 'required|string|max:255',
        ]);

        $donasi = Donasi::findOrFail($donasi_id);

        JadwalKurir::create([
            'user_id' => Auth::id(),
            'donasi_id' => $donasi->id,
            'pengajuan_id' => $donasi->pengajuan ? $donasi->pengajuan->id : null,
            'status' => 'Sedang Dijemput',
            'tanggal_pengiriman' => $request->tanggal_pengiriman, // Input dari Form
            'estimasi_waktu' => $request->estimasi_waktu,       // Input dari Form
        ]);

        $donasi->update(['status' => 'Proses Pengiriman']);

        return redirect()->route('kurir.jadwal.index')->with('success', 'Jadwal berhasil dibuat!');
    }

    // 3. EDIT (Tampilkan Form Edit)
    public function edit($id)
    {
        $jadwal = JadwalKurir::findOrFail($id);
        
        // Pastikan kurir cuma bisa edit punya sendiri
        if($jadwal->user_id != Auth::id()) {
            return abort(403);
        }

        return view('kurir.jadwal.edit', compact('jadwal'));
    }

    // 3. UPDATE (Simpan Perubahan)
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'estimasi_waktu' => 'required|string|max:255',
        ]);

        $jadwal = JadwalKurir::findOrFail($id);
        
        $jadwal->update([
            'tanggal_pengiriman' => $request->tanggal_pengiriman,
            'estimasi_waktu' => $request->estimasi_waktu,
        ]);

        return redirect()->route('kurir.jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    // 4. DELETE (Batalkan Tugas)
    public function destroy($id)
    {
        $jadwal = JadwalKurir::findOrFail($id);
        $jadwal->donasi->update(['status' => 'Butuh Kurir']);
        $jadwal->delete();

        return back()->with('success', 'Tugas dibatalkan.');
    }

    // FITUR EXTRA: Selesaikan Tugas
    public function selesaikan($id)
    {
        $jadwal = JadwalKurir::findOrFail($id);
        $jadwal->update(['status' => 'Selesai']);
        $jadwal->donasi->update(['status' => 'Selesai']);
        if($jadwal->donasi->pengajuan) {
            $jadwal->donasi->pengajuan->update(['status' => 'Diterima']);
        }

        return back()->with('success', 'Pengantaran selesai!');
    }
}