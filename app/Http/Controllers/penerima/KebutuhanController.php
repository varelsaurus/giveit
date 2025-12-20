<?php
namespace App\Http\Controllers\Penerima;

use App\Http\Controllers\Controller;
use App\Models\KebutuhanPakaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KebutuhanController extends Controller
{
    public function index() {
        // Nama variabelnya pakai 's' (kebutuhans) karena datanya banyak
        $kebutuhans = KebutuhanPakaian::where('user_id', Auth::id())->get();
        
        // Kirim ke view
        return view('penerima.kebutuhan.index', compact('kebutuhans'));
    }

    public function create() { return view('penerima.kebutuhan.create'); }

    public function store(Request $request) {
        $validated = $request->validate([
            'jenis_pakaian' => 'required',
            'jumlah' => 'required|integer',
            'deskripsi' => 'nullable'
        ]);
        $validated['user_id'] = Auth::id();
        
        KebutuhanPakaian::create($validated);
        return redirect()->route('kebutuhan.index');
    }

    public function edit(KebutuhanPakaian $kebutuhan) {
        return view('penerima.kebutuhan.edit', compact('kebutuhan'));
    }

    public function update(Request $request, KebutuhanPakaian $kebutuhan) {
        $kebutuhan->update($request->all());
        return redirect()->route('kebutuhan.index');
    }

    public function destroy(KebutuhanPakaian $kebutuhan) {
        $kebutuhan->delete();
        return redirect()->route('kebutuhan.index');
    }
}