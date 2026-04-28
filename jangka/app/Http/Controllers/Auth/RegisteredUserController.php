<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Desa; // ✅ Tambahkan untuk ambil data desa
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * 🧭 Tampilkan halaman register
     */
    public function create(): Response
    {
        $villages = Desa::select('id', 'nama_desa')->get(); // ✅ ambil hanya kolom penting
        return Inertia::render('Auth/Register', [
            'villages' => $villages,
        ]);
    }

    /**
     * 💾 Simpan user baru
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'desa_id' => ['required', 'exists:desa,id'], // ✅ validasi desa
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'desa_id' => $request->desa_id, // ✅ simpan id desa
        ]);

        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }
}
