<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // CREATE: Tambah User baru (Khususnya assign role Kurir)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,penerima,donatur,kurir',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'], // Pastikan kolom role ada di tabel users
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    // UPDATE: Reset password atau edit data
    public function update(Request $request, User $user)
    {
        // Logika update user standard
        $user->update($request->only(['name', 'email']));
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        return back()->with('success', 'Data user diperbarui.');
    }
}