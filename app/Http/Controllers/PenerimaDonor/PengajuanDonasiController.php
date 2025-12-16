<?php

namespace App\Http\Controllers\PenerimaDonor;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use App\Models\PengajuanDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanDonasiController extends Controller
{
    // LIST Donasi Tersedia (Katalog)
    public function availableDonations()
    {
        $donasi = Donasi::where('status', 'Tersedia')->latest()->get();
        return view('penerima.donasi-tersedia', compact('donasi'));
    }

    // Riwayat Pengajuan Saya
    public function index()
    {
        $pengajuan = PengajuanDonasi::where('user_id', Auth::id())
                        ->with('donasi')
                        ->latest()
                        ->get();
        return view('penerima.pengajuan.index', compact('pengajuan'));
    }

    // PROSES Ajukan (Store)
    public function store(Request $request, Donasi $donasi)
    {
        // Validasi
        if($donasi->status != 'Tersedia') {
            return back()->with('error', 'Maaf, donasi ini sudah tidak tersedia.');
        }
        
        // Cek double request
        $exists = PengajuanDonasi::where('user_id', Auth::id())
                    ->where('donasi_id', $donasi->id)
                    ->exists();
        if($exists) return back()->with('error', 'Anda sudah mengajukan donasi ini.');

        // Buat Pengajuan
        PengajuanDonasi::create([
            'user_id' => Auth::id(),
            'donasi_id' => $donasi->id,
            'status' => 'Menunggu',
            'alasan' => $request->input('alasan', 'Saya membutuhkan bantuan ini.'),
        ]);

        return redirect()->route('penerima.pengajuan.index')
                         ->with('success', 'Pengajuan berhasil dikirim. Tunggu konfirmasi Admin.');
    }

    // Batalkan Pengajuan
    public function destroy(PengajuanDonasi $pengajuan)
    {
        if($pengajuan->user_id != Auth::id()) abort(403);
        
        if($pengajuan->status == 'Menunggu') {
            $pengajuan->delete();
            return back()->with('success', 'Pengajuan dibatalkan.');
        }
        
        return back()->with('error', 'Tidak bisa membatalkan pengajuan yang sedang diproses.');
    }
    
    // Placeholder method karena ada di resource route tapi mungkin tidak dipakai
    public function update(Request $request, PengajuanDonasi $pengajuan) { return back(); }
}