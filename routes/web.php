<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;

use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\LaporanAssignController;
use App\Http\Controllers\AduanController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // AUTH ADMIN
    Route::get('/login', [AuthController::class, 'loginForm'])
        ->middleware('guest:admin')
        ->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('guest:admin');

    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('admin.logout');
        // PETUGAS - HANYA 1 DEFINISI INI
        Route::resource('petugas', PetugasController::class)
            ->parameters(['petugas' => 'petugas']);


        // LAPORAN
        Route::get('/perbaikan', [App\Http\Controllers\Admin\PerbaikanController::class, 'index'])
        ->name('perbaikan.index');

    Route::get('/perbaikan/{perbaikan}', [App\Http\Controllers\Admin\PerbaikanController::class, 'show'])
        ->name('perbaikan.show');

    Route::post('/perbaikan/{perbaikan}/acc', [App\Http\Controllers\Admin\PerbaikanController::class, 'acc'])
        ->name('perbaikan.acc');

        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])
            ->name('laporan.show');

        Route::post('/laporan/{laporan}/verifikasi', [LaporanController::class, 'verifikasi'])
            ->name('laporan.verifikasi');

        // ASSIGN PETUGAS (PAKAI petugas_id)
        Route::get('/laporan/{laporan}/assign', [LaporanAssignController::class, 'create'])
            ->name('laporan.assign');

        Route::post('/laporan/{laporan}/assign', [LaporanAssignController::class, 'store'])
            ->name('laporan.assign.store');
    });
});

/*
|--------------------------------------------------------------------------
| ADUAN MASYARAKAT (PUBLIC)
|--------------------------------------------------------------------------
*/

// Lebih singkat menggunakan Route::view
Route::get('/', function () {
    $laporans = \App\Models\Laporan::all();
    return view('landing', compact('laporans'));
})->name('home');

// Grouping Controller Aduan agar lebih rapi
Route::controller(AduanController::class)->group(function() {
    Route::get('/aduan', 'create')->name('aduan.create');
    Route::post('/aduan', 'store')->name('aduan.store');
});