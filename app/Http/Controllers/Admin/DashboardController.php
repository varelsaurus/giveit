<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // --- MANAGE USER ---
    public function index() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function create() { return view('admin.users.create'); }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);
        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user) {
        $user->delete();
        return back();
    }

    // --- MANAGE DONASI ---
    public function manageDonasi() {
        $donasis = Donasi::with('user')->get();
        return view('admin.donasi.index', compact('donasis'));
    }

    public function approveDonasi(Request $request, $id) {
        $donasi = Donasi::findOrFail($id);
        $donasi->update(['status' => $request->status]); // approve / reject
        return back();
    }
}