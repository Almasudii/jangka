<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class BeritaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Berita::with('penulis:id,name');

        if ($user->role !== 'admin') {
            $query->where('status', 'published');
        }

        $berita = $query
            ->latest('published_at')
            ->latest('created_at')
            ->paginate(6)
            ->withQueryString();

        return Inertia::render('Berita/Index', [
            'berita' => $berita,
        ]);
    }

    public function create()
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        return Inertia::render('Berita/Create');
    }

    public function store(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $this->simpanThumbnailSebagaiWebp($request->file('thumbnail'));
        }

        Berita::create([
            'judul' => $validated['judul'],
            'ringkasan' => $this->ambilDuaKalimatAwal($validated['isi']),
            'isi' => $validated['isi'],
            'thumbnail' => $thumbnailPath,
            'status' => $validated['status'],
            'penulis_id' => Auth::id(),
            'published_at' => $validated['status'] === 'published' ? now() : null,
        ]);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function update(Request $request, Berita $berita)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $thumbnailPath = $berita->thumbnail;

        if ($request->hasFile('thumbnail')) {
            if ($berita->thumbnail) {
                Storage::disk('public')->delete($berita->thumbnail);
            }

            $thumbnailPath = $this->simpanThumbnailSebagaiWebp($request->file('thumbnail'));
        }

        $publishedAt = $berita->published_at;

        if ($validated['status'] === 'published' && !$publishedAt) {
            $publishedAt = now();
        }

        if ($validated['status'] === 'draft') {
            $publishedAt = null;
        }

        $berita->update([
            'judul' => $validated['judul'],
            'ringkasan' => $this->ambilDuaKalimatAwal($validated['isi']),
            'isi' => $validated['isi'],
            'thumbnail' => $thumbnailPath,
            'status' => $validated['status'],
            'published_at' => $publishedAt,
        ]);

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(Berita $berita)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($berita->thumbnail) {
            Storage::disk('public')->delete($berita->thumbnail);
        }

        $berita->delete();

        return redirect()
            ->route('berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    private function ambilDuaKalimatAwal(string $isi): string
    {
        $text = strip_tags($isi);
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        $kalimat = preg_split('/(?<=[.!?])\s+/', $text, -1, PREG_SPLIT_NO_EMPTY);

        return implode(' ', array_slice($kalimat, 0, 2));
    }

    private function simpanThumbnailSebagaiWebp(UploadedFile $file): string
    {
        if (!function_exists('imagewebp')) {
            throw ValidationException::withMessages([
                'thumbnail' => 'Server belum mendukung konversi gambar ke WebP.',
            ]);
        }

        $source = imagecreatefromstring(file_get_contents($file->getRealPath()));

        if (!$source) {
            throw ValidationException::withMessages([
                'thumbnail' => 'File gambar tidak valid.',
            ]);
        }

        if (!imageistruecolor($source)) {
            imagepalettetotruecolor($source);
        }

        imagealphablending($source, false);
        imagesavealpha($source, true);

        Storage::disk('public')->makeDirectory('berita-thumbnails');

        $path = 'berita-thumbnails/' . Str::uuid() . '.webp';
        $fullPath = Storage::disk('public')->path($path);

        $saved = imagewebp($source, $fullPath, 80);

        imagedestroy($source);

        if (!$saved) {
            throw ValidationException::withMessages([
                'thumbnail' => 'Gagal menyimpan gambar WebP.',
            ]);
        }

        return $path;
    }
}