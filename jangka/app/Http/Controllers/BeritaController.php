<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BeritaController extends Controller
{
    public function index()
    {
        $berita = Berita::latest()->get();
        return Inertia::render('Berita/Index', [
            'berita' => $berita
        ]);
    }

    public function create()
    {
        return Inertia::render('Berita/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        Berita::create($request->all());
        return redirect()->route('berita.index');
    }

    public function destroy(Berita $beritum)
    {
        $beritum->delete();
        return redirect()->route('berita.index');
    }
}
