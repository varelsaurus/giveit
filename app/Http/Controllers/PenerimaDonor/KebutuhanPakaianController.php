<?php

namespace App\Http\Controllers\PenerimaDonor;

use App\Http\Controllers\Controller;
use App\Models\KebutuhanPakaian; // Pastikan model ini ada
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KebutuhanPakaianController extends Controller
{
    public function index()
    {
        // Lihat request saya yang belum terpenuhi
        $kebutuhan = KebutuhanPakaian::where('user_id', Auth::id())->latest()->get();
        return view('penerima.kebutuhan.index', compact('kebutuhan'));
    }
    
    public function create()
    {
        return view('penerima.kebutuhan.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'jenis_pakaian' => 'required|string', // Misal: Selimut, Jaket
            'jumlah' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
        ]);
    
        KebutuhanPakaian::create([
            'user_id' => Auth::id(),
            'jenis_pakaian' => $request->jenis_pakaian,
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
            'status' => 'Belum Terpenuhi'
        ]);
    
        return redirect()->route('penerima.kebutuhan.index')->with('success', 'Kebutuhan berhasil diposting! Menunggu donatur.');
    }

    public function edit(KebutuhanPakaian $kebutuhan)
    {
        if($kebutuhan->user_id != Auth::id()) abort(403);
        return view('penerima.kebutuhan.edit', compact('kebutuhan'));
    }

    public function update(Request $request, KebutuhanPakaian $kebutuhan)
    {
        if($kebutuhan->user_id != Auth::id()) abort(403);
        
        $kebutuhan->update($request->only(['jenis_pakaian', 'jumlah', 'deskripsi']));
        return redirect()->route('penerima.kebutuhan.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(KebutuhanPakaian $kebutuhan)
    {
        if($kebutuhan->user_id != Auth::id()) abort(403);
        $kebutuhan->delete();
        return back()->with('success', 'Data dihapus.');
    }
}