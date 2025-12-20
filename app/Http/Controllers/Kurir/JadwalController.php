<?php
namespace App\Http\Controllers\Kurir;

use App\Http\Controllers\Controller;
use App\Models\JadwalKurir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index() {
        // Tampilkan jadwal milik kurir yang login
        $jadwals = JadwalKurir::where('user_id', Auth::id())
                    ->with(['donasi', 'pengajuan.user']) // Eager load relasi
                    ->get();
        return view('kurir.jadwal.index', compact('jadwals'));
    }

    public function create() {
        // Kurir buat jadwal manual (contoh sederhana)
        return view('kurir.jadwal.create');
    }

    public function store(Request $request) {
        // Logic simpan jadwal (biasanya di-assign admin, tapi ini fitur create kurir)
        JadwalKurir::create([
            'user_id' => Auth::id(),
            'donasi_id' => $request->donasi_id,
            'tanggal_pengiriman' => $request->tanggal,
            'status' => 'waiting'
        ]);
        return redirect()->route('jadwal.index');
    }

    public function updateStatus(Request $request, $id) {
        $jadwal = JadwalKurir::findOrFail($id);
        $jadwal->update(['status' => $request->status]); // misal: 'delivered'
        return back()->with('success', 'Status diperbarui');
    }
}