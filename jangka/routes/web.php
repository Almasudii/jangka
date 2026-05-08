<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileDesaController;
use App\Http\Controllers\SettingsController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->middleware('auth')->name('logout');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
    Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
    Route::post('/berita', [BeritaController::class, 'store'])->name('berita.store');
    Route::put('/berita/{berita}', [BeritaController::class, 'update'])->name('berita.update');
    Route::delete('/berita/{berita}', [BeritaController::class, 'destroy'])->name('berita.destroy');

    Route::get('/layanan', fn () => Inertia::render('Layanan'))->name('layanan');

    Route::get('/peta-desa', function () {
        $user = Auth::user();

        return Inertia::render('PetaDesa', [
            'desa' => $user->desa?->nama_desa ?? 'Tidak Diketahui',
        ]);
    })->name('peta-desa');

    Route::get('/profil-desa', [ProfileDesaController::class, 'index'])->name('profil.desa');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/fasilitas-desa', function () {
        $fasilitas = [
            [
                'nama' => 'Balai Desa',
                'deskripsi' => 'Tempat utama kegiatan administrasi dan musyawarah desa.',
                'icon' => 'building',
            ],
            [
                'nama' => 'Puskesmas',
                'deskripsi' => 'Pusat pelayanan kesehatan masyarakat desa.',
                'icon' => 'health',
            ],
            [
                'nama' => 'Sekolah Dasar Negeri 1',
                'deskripsi' => 'Fasilitas pendidikan dasar bagi anak-anak desa.',
                'icon' => 'school',
            ],
            [
                'nama' => 'Masjid Al-Hidayah',
                'deskripsi' => 'Tempat ibadah utama masyarakat desa.',
                'icon' => 'mosque',
            ],
            [
                'nama' => 'Lapangan Merdeka',
                'deskripsi' => 'Tempat olahraga dan kegiatan masyarakat.',
                'icon' => 'field',
            ],
        ];

        return Inertia::render('FasilitasDesa', [
            'fasilitas' => $fasilitas,
        ]);
    })->name('fasilitas-desa');
});