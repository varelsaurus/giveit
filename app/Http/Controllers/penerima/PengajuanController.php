<?php

namespace App\Http\Controllers\Penerima;

use App\Http\Controllers\Controller;
use App\Models\PengajuanDonasi;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    // CREATE: Saat klik "Ajukan" di katalog donasi
    public function store(Request $request, $donasiId)
    {
        $donasi = Donasi::findOrFail($donasiId);

        // Cek apakah donasi masih tersedia
        if ($donasi->status != 'Tersedia') {
            return back()->with('error', 'Donasi ini sudah tidak tersedia.');
        }

        // Cek apakah user sudah pernah mengajukan
        $cek = PengajuanDonasi::where('user_id', Auth::id())
                              ->where('donasi_id', $donasiId)->first();
        
        if($cek) {
            return back()->with('error', 'Anda sudah mengajukan donasi ini.');
        }

        PengajuanDonasi::create([
            'user_id' => Auth::id(),
            'donasi_id' => $donasiId,
            'status' => 'Menunggu', // Default status
            'alasan' => $request->input('alasan', 'Saya membutuhkan barang ini.')
        ]);

        return back()->with('success', 'Pengajuan berhasil dikirim. Tunggu konfirmasi Admin.');
    }

    // DELETE: Batalkan Pengajuan
    public function destroy($id)
    {
        $pengajuan = PengajuanDonasi::where('user_id', Auth::id())->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu') {
            return back()->with('error', 'Pengajuan yang sudah diproses tidak bisa dibatalkan.');
        }

        $pengajuan->delete();
        return back()->with('success', 'Pengajuan dibatalkan.');
    }
}