<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileDesaController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| USER AUTH (LOGIN / REGISTER)
|--------------------------------------------------------------------------
*/
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
})->name('logout');
/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

/*
|--------------------------------------------------------------------------
| FITUR DASHBOARD USER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard utama
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Halaman tambahan di dashboard
    Route::get('/berita', fn() => Inertia::render('Berita'))->name('berita');
    Route::get('/layanan', fn() => Inertia::render('Layanan'))->name('layanan');
    Route::get('/peta-desa', fn() => Inertia::render('PetaDesa'))->name('peta-desa');
    Route::get('/profil-desa', [ProfileDesaController::class, 'index'])->name('profil.desa');

    /*
    |--------------------------------------------------------------------------
    | PROFIL PENGGUNA
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    /*
    |--------------------------------------------------------------------------
    | FASILITAS DESA
    |--------------------------------------------------------------------------
    */
    Route::get('/fasilitas-desa', function () {
        $fasilitas = [
            [
                'nama' => 'Balai Desa',
                'deskripsi' => 'Tempat utama kegiatan administrasi dan musyawarah desa.',
                'icon' => '🏛️',
            ],
            [
                'nama' => 'Puskesmas',
                'deskripsi' => 'Pusat pelayanan kesehatan masyarakat desa.',
                'icon' => '🏥',
            ],
            [
                'nama' => 'Sekolah Dasar Negeri 1',
                'deskripsi' => 'Fasilitas pendidikan dasar bagi anak-anak desa.',
                'icon' => '🏫',
            ],
            [
                'nama' => 'Masjid Al-Hidayah',
                'deskripsi' => 'Tempat ibadah utama masyarakat desa.',
                'icon' => '🕌',
            ],
            [
                'nama' => 'Lapangan Merdeka',
                'deskripsi' => 'Tempat olahraga dan kegiatan masyarakat.',
                'icon' => '⚽',
            ],
        ];

        return Inertia::render('FasilitasDesa', [
            'fasilitas' => $fasilitas,
        ]);
    })->name('fasilitas-desa');
});
