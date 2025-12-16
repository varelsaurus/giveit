<?php

namespace App\Http\Controllers\Penerima;

use App\Http\Controllers\Controller;
use App\Models\Kebutuhan; // Pastikan Model Kebutuhan ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KebutuhanController extends Controller
{
    // READ: List kebutuhan sendiri
    public function index()
    {
        $kebutuhan = Kebutuhan::where('user_id', Auth::id())->latest()->get();
        return view('penerima.kebutuhan.index', compact('kebutuhan'));
    }

    public function create()
    {
        return view('penerima.kebutuhan.create');
    }

    // CREATE: Form input kebutuhan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|integer|min:1',
            // tambahkan validasi gambar jika ada
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'Belum Terpenuhi';

        Kebutuhan::create($validated);

        return redirect()->route('penerima.kebutuhan.index')->with('success', 'Kebutuhan berhasil diposting.');
    }

    // UPDATE: Edit kebutuhan
    public function update(Request $request, $id)
    {
        $kebutuhan = Kebutuhan::where('user_id', Auth::id())->findOrFail($id);

        if ($kebutuhan->status !== 'Belum Terpenuhi') {
            return back()->with('error', 'Hanya kebutuhan yang belum terpenuhi yang bisa diedit.');
        }

        $kebutuhan->update($request->only(['nama_barang', 'deskripsi', 'jumlah']));

        return back()->with('success', 'Kebutuhan diperbarui.');
    }

    // DELETE: Hapus kebutuhan
    public function destroy($id)
    {
        $kebutuhan = Kebutuhan::where('user_id', Auth::id())->findOrFail($id);
        
        if ($kebutuhan->status !== 'Belum Terpenuhi') {
            return back()->with('error', 'Tidak bisa menghapus kebutuhan yang sedang diproses.');
        }

        $kebutuhan->delete();
        return back()->with('success', 'Kebutuhan dihapus.');
    }
}