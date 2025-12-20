<?php
namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonasiController extends Controller
{
    public function index() {
        $donasis = Donasi::where('user_id', Auth::id())->latest()->get();
        return view('donatur.donasi.index', compact('donasis'));
    }

    public function create() {
        return view('donatur.donasi.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama_barang' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required|integer',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending'; // Default status

        Donasi::create($validated);
        return redirect()->route('donasi.index')->with('success', 'Donasi berhasil dibuat!');
    }

    public function edit(Donasi $donasi) {
        return view('donatur.donasi.edit', compact('donasi'));
    }

    public function update(Request $request, Donasi $donasi) {
        $donasi->update($request->all());
        return redirect()->route('donasi.index');
    }

    public function destroy(Donasi $donasi) {
        $donasi->delete();
        return redirect()->route('donasi.index');
    }
}