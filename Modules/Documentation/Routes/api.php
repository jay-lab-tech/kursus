<?php

use Illuminate\Support\Facades\Route;
use Modules\Documentation\Http\Controllers\DokumentasiController;

// Public routes (no auth required for GET)
Route::get('/dokumentasi', [DokumentasiController::class, 'index']);
Route::get('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'show']);

// Protected routes (require authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    // Admin only - full CRUD
    Route::middleware('check.role:admin')->group(function () {
        Route::post('/dokumentasi', [DokumentasiController::class, 'store']);
        Route::put('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'update']);
        Route::delete('/dokumentasi/{dokumentasi}', [DokumentasiController::class, 'destroy']);
    });

    // Mahasiswa - can create dokumentasi
    Route::middleware('check.role:mahasiswa')->group(function () {
        Route::post('/dokumentasi', [DokumentasiController::class, 'store']);
    });
});
