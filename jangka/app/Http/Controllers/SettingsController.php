<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // ✅ Tambahkan ini

class SettingsController extends Controller
{
    // Menampilkan halaman pengaturan
    public function index()
    {
        return inertia('Settings/Index', [
            'auth' => [
                'user' => Auth::user(),
            ],
        ]);
    }

    // Menyimpan perubahan pengaturan
    public function update(Request $request)
    {
        $validated = $request->validate([
            'dark_mode' => 'boolean',
            'notifications' => 'boolean',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Simpan ke kolom JSON 'settings'
        $user->settings = $validated;
        $user->save(); // ✅ Sekarang Intelephense tidak akan error

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
