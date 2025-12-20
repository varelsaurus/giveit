<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        // Ini mengirim variabel $reports yang dicari oleh View Anda
        $reports = Report::with('user')->latest()->get();
        return view('admin.report.index', compact('reports'));
    }

    public function create()
    {
        return view('admin.report.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
            'catatan' => 'nullable|string',
        ]);

        $jumlahDonasi = Donasi::whereBetween('created_at', [
                            $request->tanggal_awal . ' 00:00:00', 
                            $request->tanggal_akhir . ' 23:59:59'
                        ])->count();

        Report::create([
            'user_id' => Auth::id(),
            'judul' => $request->judul,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
            'total_donasi_tercatat' => $jumlahDonasi,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('admin.report.index')->with('success', 'Laporan berhasil dibuat.');
    }

    public function destroy($id)
    {
        Report::findOrFail($id)->delete();
        return back()->with('success', 'Arsip laporan dihapus.');
    }
}