<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ProfileDesaController extends Controller
{
    public function index()
    {
        $profil = [
            'nama' => 'Desa Gunung Maddah',
            'alamat' => 'Jl. Raya Desa No. 1, Kecamatan Sampang, Kabupaten Sampang',
            'sejarah' => 'Desa Gunung Maddah berdiri sejak tahun 1950 dan terus berkembang...',
            'visi' => 'Menjadi desa mandiri dan sejahtera berlandaskan gotong royong.',
            'misi' => [
                'Meningkatkan kualitas sumber daya manusia.',
                'Mengembangkan potensi ekonomi lokal.',
                'Menjaga kelestarian lingkungan.',
            ],
            'struktur' => [
                'Kepala Desa' => 'Bapak H.Sulton Mairi',
                'Sekretaris Desa' => 'Ibu HJ.Arwati',
                'Bendahara' => 'Bapak Almas udi',
            ],
            'potensi' => 'Pertanian, peternakan, dan wisata alam menjadi potensi utama desa ini.'
        ];

        return Inertia::render('ProfilDesa', ['profil' => $profil]);
    }
}
