<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        return Inertia::render('Admin/Dashboard');
    }

    public function users()
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $users = User::with('desa')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $desas = Desa::select('id', 'nama_desa')
            ->orderBy('nama_desa')
            ->get();

        return Inertia::render('Roledistri/Index', [
            'users' => $users,
            'desas' => $desas,
        ]);
    }

    public function createUser()
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $desas = Desa::select('id', 'nama_desa')
            ->orderBy('nama_desa')
            ->get();

        return Inertia::render('Admin/Users/Create', [
            'desas' => $desas,
        ]);
    }

    public function storeUser(Request $request)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'desa_id' => 'nullable|exists:desas,id',
            'role' => 'required|in:admin,penduduk',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $profilePhotoPath = null;

        if ($request->hasFile('profile_photo')) {
            $profilePhotoPath = $request
                ->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'desa_id' => $validated['desa_id'] ?? null,
            'role' => $validated['role'],
            'profile_photo' => $profilePhotoPath,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    public function editUser(User $user)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $desas = Desa::select('id', 'nama_desa')
            ->orderBy('nama_desa')
            ->get();

        return Inertia::render('Admin/Users/Edit', [
            'userData' => $user->load('desa'),
            'desas' => $desas,
        ]);
    }

    public function updateUser(Request $request, User $user)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'desa_id' => 'nullable|exists:desas,id',
            'role' => 'required|in:admin,penduduk',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($user->id === Auth::id() && $validated['role'] !== 'admin') {
            throw ValidationException::withMessages([
                'role' => 'Kamu tidak bisa mengubah role akunmu sendiri menjadi penduduk.',
            ]);
        }

        $payload = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'desa_id' => $validated['desa_id'] ?? null,
            'role' => $validated['role'],
        ];

        if ($request->filled('password')) {
            $payload['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $payload['profile_photo'] = $request
                ->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        $user->update($payload);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        abort_if(Auth::user()->role !== 'admin', 403);

        if ($user->id === Auth::id()) {
            throw ValidationException::withMessages([
                'user' => 'Kamu tidak bisa menghapus akunmu sendiri.',
            ]);
        }

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}