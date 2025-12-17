<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // 1. INDEX: Menampilkan daftar user
    public function index()
    {
        // Ambil semua user, urutkan terbaru
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // 2. CREATE: Menampilkan form tambah user
    public function create()
    {
        return view('admin.users.create');
    }

    // 3. STORE: Menyimpan user baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,donatur,penerima,penerima_donor,kurir'], 
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    // 4. EDIT: Menampilkan form edit
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // 5. UPDATE: Menyimpan perubahan
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        // Cek jika password diisi (opsional update)
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.user.index')->with('success', 'Data user diperbarui.');
    }

    // 6. DESTROY: Menghapus user
    public function destroy(User $user)
    {   
        if (auth()->id() == $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}