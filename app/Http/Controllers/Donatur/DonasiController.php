<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
// JANGAN LUPA IMPORT MODEL INI:
use App\Models\KebutuhanPakaian; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonasiController extends Controller
{
    public function index() {
        $donasis = Donasi::where('user_id', Auth::id())->latest()->get();
        return view('donatur.donasi.index', compact('donasis'));
    }

    /**
     * PERBAIKAN DI SINI:
     * Tambahkan parameter optional $kebutuhanId = null
     */
    public function create($kebutuhanId = null) {
        
        $kebutuhan = null;

        // Jika ada ID (artinya user klik tombol "Bantu" dari dashboard donatur)
        if ($kebutuhanId) {
            $kebutuhan = KebutuhanPakaian::find($kebutuhanId);
        }

        // Kita kirim variabel $kebutuhan (bisa isinya data, bisa null)
        return view('donatur.donasi.create', compact('kebutuhan'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required|integer',
            // Validasi optional jika donasi ini terikat kebutuhan
            'kebutuhan_id' => 'nullable|exists:kebutuhan_pakaians,id' 
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending'; 

        Donasi::create($validated);
        
        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil dibuat!');
    }

    public function edit(Donasi $donasi) {
        return view('donatur.donasi.edit', compact('donasi'));
    }

    public function update(Request $request, Donasi $donasi) {
        // Sebaiknya tambahkan validasi di sini juga
        $donasi->update($request->all());
        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil diperbarui');
    }

    public function destroy(Donasi $donasi) {
        $donasi->delete();
        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil dihapus');
    }
}