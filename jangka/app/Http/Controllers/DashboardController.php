<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\Berita;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        // ✅ gunakan Auth::user() (lebih eksplisit & dikenali IDE)
        $user = Auth::user();

        // jika user belum login, cegah error
        if (!$user) {
            return redirect()->route('login');
        }

        $desaName = $user->desa?->nama_desa ?? 'Belum memilih desa';

        return Inertia::render('Dashboard', [
            'jumlahPenduduk' => Penduduk::count(),
            'jumlahBerita'   => Berita::count(),
            'jumlahLayanan'  => Layanan::count(),
            'desa'           => $desaName,
            'user'           => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'created_at' => $user->created_at->format('d M Y'),
                'updated_at' => $user->updated_at->format('d M Y'),
                'foto_profil' => $user->foto_profil
                    ? asset('storage/' . $user->foto_profil)
                    : asset('images/default.png'),
            ],
        ]);
    }
}
