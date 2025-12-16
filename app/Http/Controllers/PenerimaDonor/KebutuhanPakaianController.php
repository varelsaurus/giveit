<?php

// app/Http/Controllers/PenerimaDonor/KebutuhanPakaianController.php

namespace App\Http\Controllers\PenerimaDonor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KebutuhanPakaian;
use Illuminate\Support\Facades\Auth;

class KebutuhanPakaianController extends Controller
{
    /**
     * 2. Read kebutuhan pakaian - Index
     */
    public function index()
    {
        // Ambil daftar kebutuhan milik user yang sedang login
        // Karena relasinya 1:1, kita gunakan first()
        $kebutuhan = KebutuhanPakaian::where('user_id', Auth::id())->first();

        // Kita akan menggunakan view index untuk menampilkan detail kebutuhan (jika ada) 
        // atau menampilkan tombol Create (jika tidak ada)
        return view('penerima.kebutuhan.index', compact('kebutuhan'));
    }

    /**
     * Tampilkan form untuk membuat kebutuhan pakaian baru (1. Create)
     */
    public function create()
    {
        // Cek jika user sudah punya kebutuhan, redirect ke index dengan error
        if (KebutuhanPakaian::where('user_id', Auth::id())->exists()) {
            return redirect()->route('penerima.kebutuhan.index')
                             ->with('error', 'Anda hanya dapat memiliki satu daftar kebutuhan aktif. Silakan edit daftar yang sudah ada.');
        }

        return view('penerima.kebutuhan.create');
    }

    /**
     * 1. Create kebutuhan pakaian - Proses Store
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pakaian' => 'required|string|max:255',
            'jumlah_total' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        KebutuhanPakaian::create([
            'user_id' => Auth::id(),
            'jenis_pakaian' => $request->jenis_pakaian,
            'jumlah_total' => $request->jumlah_total,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('penerima.kebutuhan.index')->with('success', 'Daftar kebutuhan berhasil dibuat.');
    }

    /**
     * 3. Update kebutuhan pakaian - Tampilkan Form Edit
     */
    public function edit(KebutuhanPakaian $kebutuhan)
    {
        // Otorisasi: Pastikan kebutuhan ini milik user yang login
        if ($kebutuhan->user_id !== Auth::id()) {
            abort(403);
        }

        return view('penerima.kebutuhan.edit', compact('kebutuhan'));
    }

    /**
     * 3. Update kebutuhan pakaian - Proses Update
     */
    public function update(Request $request, KebutuhanPakaian $kebutuhan)
    {
        // Otorisasi: Pastikan kebutuhan ini milik user yang login
        if ($kebutuhan->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'jenis_pakaian' => 'required|string|max:255',
            'jumlah_total' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
        ]);

        $kebutuhan->update($request->all());

        return redirect()->route('penerima.kebutuhan.index')->with('success', 'Daftar kebutuhan berhasil diperbarui.');
    }

    /**
     * 4. Delete kebutuhan pakaian
     */
    public function destroy(KebutuhanPakaian $kebutuhan)
    {
        // Otorisasi: Pastikan kebutuhan ini milik user yang login
        if ($kebutuhan->user_id !== Auth::id()) {
            abort(403);
        }

        // Optional: Anda bisa menambahkan cek apakah ada Pengajuan Donasi aktif yang merujuk ke kebutuhan ini sebelum menghapus.

        $kebutuhan->delete();
        return redirect()->route('penerima.kebutuhan.index')->with('success', 'Daftar kebutuhan berhasil dihapus.');
    }
}