<?php

use Illuminate\Support\Facades\Route;
use Modules\Meeting\Http\Controllers\RisalahController;

// Public routes (no auth required for GET)
Route::get('/risalah', [RisalahController::class, 'index']);
Route::get('/risalah/{risalah}', [RisalahController::class, 'show']);

// Protected routes (require authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    // Admin only - full CRUD
    Route::middleware('check.role:admin')->group(function () {
        Route::post('/risalah', [RisalahController::class, 'store']);
        Route::put('/risalah/{risalah}', [RisalahController::class, 'update']);
        Route::delete('/risalah/{risalah}', [RisalahController::class, 'destroy']);
    });

    // Instruktur - can create and update risalah
    Route::middleware('check.role:instruktur')->group(function () {
        Route::post('/risalah', [RisalahController::class, 'store']);
        Route::put('/risalah/{risalah}', [RisalahController::class, 'update']);
    });
});
