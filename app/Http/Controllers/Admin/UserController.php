<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 2. Read user (semua role) - Index
     */
    public function index()
    {
        // Ambil semua user dengan role-nya
        $users = User::with('role')->latest()->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * 1. Create user (assign kurir) - Tampilkan Form
     */
    public function create()
    {
        // Ambil role yang bisa di-assign oleh Admin (Kurir dan Admin)
        $roles = Role::whereIn('name', ['kurir', 'admin'])->get();
        return view('admin.user.create', compact('roles'));
    }

    /**
     * 1. Create user (assign kurir) - Proses Store
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User baru berhasil didaftarkan.');
    }

    /**
     * 3. Update user (semua role) - Tampilkan Form
     */
    public function edit(User $user)
    {
        $roles = Role::all(); // Admin bisa mengubah role siapapun
        return view('admin.user.edit', compact('user', 'roles'));
    }

    /**
     * 3. Update user (semua role) - Proses Update
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8',
        ]);

        $data = $request->only('name', 'email', 'role_id');

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * 4. Delete user (semua role)
     */
    public function destroy(User $user)
    {
        // Optional: Tambahkan pengecekan agar Admin tidak bisa menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Admin yang sedang login.');
        }
        
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}