<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::latest()->get();
        return Inertia::render('Layanan/Index', [
            'layanans' => $layanans
        ]);
    }

    public function create()
    {
        return Inertia::render('Layanan/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        Layanan::create($request->all());
        return redirect()->route('layanan.index');
    }

    public function destroy(Layanan $layanan)
    {
        $layanan->delete();
        return redirect()->route('layanan.index');
    }
}
