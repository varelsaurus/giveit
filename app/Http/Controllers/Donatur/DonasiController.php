<?php
// app/Http/Controllers/Donatur/DonasiController.php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonasiController extends Controller
{
    /**
     * 2. Read donasi (Menampilkan daftar donasi milik donatur yang login)
     */
    public function index()
    {
        // Ambil hanya donasi yang dibuat oleh user yang sedang login
        $donasis = Donasi::where('user_id', Auth::id())->latest()->get();
        
        // Asumsi Anda akan membuat view di resources/views/donatur/donasi/index.blade.php
        return view('donatur.donasi.index', compact('donasis'));
    }

    /**
     * Tampilkan form untuk membuat donasi baru
     */
    public function create()
    {
        return view('donatur.donasi.create');
    }

    /**
     * 1. Create donasi (Menyimpan donasi baru ke database)
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'jenis_pakaian' => 'required|string|max:255',
            'jumlah_pakaian' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            // Tambahkan validasi lain sesuai kebutuhan (misalnya, gambar)
        ]);

        // 2. Simpan Data
        Donasi::create([
            'user_id' => Auth::id(), // Pastikan donasi terikat pada user yang login
            'jenis_pakaian' => $request->jenis_pakaian,
            'jumlah' => $request->jumlah_pakaian, // Asumsi field di DB bernama 'jumlah'
            'deskripsi' => $request->deskripsi,
            'status' => 'Tersedia', // Default status
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('donatur.donasi.index')->with('success', 'Donasi berhasil diunggah dan siap disalurkan!');
    }

    /**
     * Menampilkan detail satu donasi (2. Read Donasi - Detail)
     */
    public function show(Donasi $donasi)
    {
        // Pastikan donasi ini milik user yang sedang login
        if ($donasi->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke donasi ini.');
        }

        return view('donatur.donasi.show', compact('donasi'));
    }
    
    /**
     * 3. Update donasi (Mengupdate data donasi)
     */
    public function update(Request $request, Donasi $donasi)
    {
        if ($donasi->user_id !== Auth::id()) {
            abort(403);
        }

        // Jangan izinkan update jika donasi sudah diproses
        if ($donasi->status !== 'Tersedia') {
            return back()->with('error', 'Donasi yang sudah diajukan tidak dapat diubah.');
        }

        $request->validate([
            'jenis_pakaian' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $donasi->update($request->all());

        return redirect()->route('donatur.donasi.index')->with('success', 'Donasi berhasil diperbarui.');
    }

    /**
     * 4. Delete donasi (Menghapus donasi)
     */
    public function destroy(Donasi $donasi)
    {
        if ($donasi->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Jangan izinkan hapus jika donasi sudah diproses
        if ($donasi->status !== 'Tersedia') {
            return back()->with('error', 'Donasi yang sudah diproses tidak dapat dihapus.');
        }

        $donasi->delete();
        
        return redirect()->route('donatur.donasi.index')->with('success', 'Donasi berhasil dihapus.');
    }
}