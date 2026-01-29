<?php

use Illuminate\Support\Facades\Route;
use Modules\Letters\Http\Controllers\SuratMasukController;
use Modules\Letters\Http\Controllers\SuratKeluarController;

// Public routes (no auth required for GET)
Route::get('/surat-masuk', [SuratMasukController::class, 'index']);
Route::get('/surat-keluar', [SuratKeluarController::class, 'index']);

Route::get('/surat-masuk/{surat_masuk}', [SuratMasukController::class, 'show']);
Route::get('/surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'show']);

// Protected routes (require authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    // Admin only - full CRUD
    Route::middleware('check.role:admin')->group(function () {
        Route::post('/surat-masuk', [SuratMasukController::class, 'store']);
        Route::put('/surat-masuk/{surat_masuk}', [SuratMasukController::class, 'update']);
        Route::delete('/surat-masuk/{surat_masuk}', [SuratMasukController::class, 'destroy']);

        Route::post('/surat-keluar', [SuratKeluarController::class, 'store']);
        Route::put('/surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'update']);
        Route::delete('/surat-keluar/{surat_keluar}', [SuratKeluarController::class, 'destroy']);
    });
});
