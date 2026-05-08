<?php

namespace App\Http\Controllers;

use App\Models\FasilitasDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FasilitasDesaController extends Controller
{
    public function index()
    {
        $fasilitas = FasilitasDesa::latest()
            ->paginate(8)
            ->withQueryString();

        return Inertia::render('FasilitasDesa/Index', [
            'fasilitas' => $fasilitas,
        ]);
    }

    public function create()
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        return Inertia::render('FasilitasDesa/Create');
    }

    public function store(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $validated = $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deskripsi' => 'required|string',
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request
                ->file('thumbnail')
                ->store('fasilitas-desa', 'public');
        }

        FasilitasDesa::create([
            'thumbnail' => $thumbnailPath,
            'deskripsi' => $validated['deskripsi'],
        ]);

        return redirect()
            ->route('fasilitas-desa.index')
            ->with('success', 'Fasilitas desa berhasil ditambahkan.');
    }

    public function edit(FasilitasDesa $fasilitasDesa)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        return Inertia::render('FasilitasDesa/Edit', [
            'fasilitas' => $fasilitasDesa,
        ]);
    }

    public function update(Request $request, FasilitasDesa $fasilitasDesa)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $validated = $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'deskripsi' => 'required|string',
        ]);

        $thumbnailPath = $fasilitasDesa->thumbnail;

        if ($request->hasFile('thumbnail')) {
            if ($fasilitasDesa->thumbnail) {
                Storage::disk('public')->delete($fasilitasDesa->thumbnail);
            }

            $thumbnailPath = $request
                ->file('thumbnail')
                ->store('fasilitas-desa', 'public');
        }

        $fasilitasDesa->update([
            'thumbnail' => $thumbnailPath,
            'deskripsi' => $validated['deskripsi'],
        ]);

        return redirect()
            ->route('fasilitas-desa.index')
            ->with('success', 'Fasilitas desa berhasil diperbarui.');
    }

    public function destroy(FasilitasDesa $fasilitasDesa)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($fasilitasDesa->thumbnail) {
            Storage::disk('public')->delete($fasilitasDesa->thumbnail);
        }

        $fasilitasDesa->delete();

        return redirect()
            ->route('fasilitas-desa.index')
            ->with('success', 'Fasilitas desa berhasil dihapus.');
    }
}