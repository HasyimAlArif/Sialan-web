<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Petugas\AuthController;
use App\Http\Controllers\Api\Petugas\DashboardController;
use App\Http\Controllers\Api\Petugas\TugasController;
use App\Http\Controllers\Api\Petugas\PerbaikanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| API PETUGAS
|--------------------------------------------------------------------------
*/
Route::prefix('petugas')->group(function () {

    // Auth (tanpa middleware)
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Tugas
        Route::get('/tugas', [TugasController::class, 'index']);
        Route::get('/tugas/{id}', [TugasController::class, 'show']);
        Route::post('/tugas/{id}/proses', [TugasController::class, 'updateStatus']);

        // Perbaikan
        Route::post('/perbaikan', [PerbaikanController::class, 'store']);
    });
});
