<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Desa;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Route ini untuk permintaan dari frontend (misal axios.get('/api/desa')).
| Semua route di sini otomatis diawali dengan "/api"
|
*/

Route::get('/desa', function () {
    return Desa::select('id', 'nama_desa')
        ->orderBy('nama_desa')
        ->get();
});
