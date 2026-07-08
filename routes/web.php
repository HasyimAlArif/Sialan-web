<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LaporanController;

use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\LaporanAssignController;
use App\Http\Controllers\AduanController;
use App\Http\Controllers\PesanController;

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

    // RESET PASSWORD (via email)
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showRequestForm'])
        ->middleware('guest:admin')
        ->name('admin.password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
        ->middleware('guest:admin')
        ->name('admin.password.send');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
        ->middleware('guest:admin')
        ->name('admin.password.reset.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
        ->middleware('guest:admin')
        ->name('admin.password.update');

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

        Route::get('/laporan/create', [LaporanController::class, 'create'])
            ->name('laporan.create');

        Route::post('/laporan', [LaporanController::class, 'store'])
            ->name('laporan.store');

        Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])
            ->name('laporan.show');

        Route::get('/laporan/{laporan}/edit', [LaporanController::class, 'edit'])
            ->name('laporan.edit');

        Route::put('/laporan/{laporan}', [LaporanController::class, 'update'])
            ->name('laporan.update');

        Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])
            ->name('laporan.destroy');

        Route::post('/laporan/bulk-destroy', [LaporanController::class, 'bulkDestroy'])
            ->name('laporan.bulk-destroy');

        Route::post('/laporan/{laporan}/verifikasi', [LaporanController::class, 'verifikasi'])
            ->name('laporan.verifikasi');

        Route::post('/laporan/{laporan}/toggle-galeri', [LaporanController::class, 'toggleGaleri'])
            ->name('laporan.toggle-galeri');

        // ASSIGN PETUGAS (PAKAI petugas_id)
        Route::get('/laporan/{laporan}/assign', [LaporanAssignController::class, 'create'])
            ->name('laporan.assign');

        Route::post('/laporan/{laporan}/assign', [LaporanAssignController::class, 'store'])
            ->name('laporan.assign.store');
            
        // PESAN (Kritik & Saran)
        Route::get('/pesan', [PesanController::class, 'index'])->name('pesan.index');
        Route::get('/pesan/{pesan}', [PesanController::class, 'show'])->name('pesan.show');
        Route::delete('/pesan/{pesan}', [PesanController::class, 'destroy'])->name('pesan.destroy');

        // PROFILE
        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile');
        Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
        Route::put('/profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('admin.profile.password');
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

// Route Submit Pesan
Route::post('/pesan', [PesanController::class, 'store'])->name('pesan.store');