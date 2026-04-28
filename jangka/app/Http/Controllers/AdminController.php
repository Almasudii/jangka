<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function showRegisterForm()
    {
        return inertia('Admin/Register'); // Vue + Inertia
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // pastikan kolom ini ada di tabel users
        ]);

        return redirect()
            ->route('admin.login')
            ->with('success', '✅ Berhasil mendaftar! Silakan login.');
    }

    public function index()
    {
        return inertia('Admin/Dashboard'); // halaman dashboard admin
    }
}
