<?php
namespace App\Http\Controllers\Penerima;

use App\Http\Controllers\Controller;
use App\Models\KebutuhanPakaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KebutuhanController extends Controller
{
    public function index() {
        $kebutuhans = KebutuhanPakaian::where('user_id', Auth::id())->get();
        return view('penerima.kebutuhan.index', compact('kebutuhans'));
    }

    public function create() { 
        return view('penerima.kebutuhan.create'); 
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'jenis_pakaian' => 'required',
            'jumlah' => 'required|integer',
            'deskripsi' => 'nullable'
        ]);
        $validated['user_id'] = Auth::id();
        
        KebutuhanPakaian::create($validated);
        
        // PERBAIKAN DI SINI:
        return redirect()->route('penerima.kebutuhan.index')->with('success', 'Kebutuhan berhasil ditambahkan');
    }

    public function edit(KebutuhanPakaian $kebutuhan) {
        return view('penerima.kebutuhan.edit', compact('kebutuhan'));
    }

    public function update(Request $request, KebutuhanPakaian $kebutuhan) {
    // 1. Validasi input dari form
    $validated = $request->validate([
        'jenis_pakaian' => 'required',
        'jumlah' => 'required|integer', // Pastikan divalidasi
        'deskripsi' => 'nullable'
    ]);

    // 2. Lakukan Update
    // Karena 'jumlah' sudah ada di $fillable Model, baris ini akan mengupdate jumlah di DB
    $kebutuhan->update($validated);
    
    return redirect()->route('penerima.kebutuhan.index')->with('success', 'Berhasil update!');
}

    public function destroy(KebutuhanPakaian $kebutuhan) {
        $kebutuhan->delete();
        
        // PERBAIKAN DI SINI:
        return redirect()->route('penerima.kebutuhan.index')->with('success', 'Kebutuhan berhasil dihapus');
    }
}