<?php

use Illuminate\Support\Facades\Route;
use Modules\Disposition\Http\Controllers\DisposisiController;

// Public routes (no auth required for GET)
Route::get('/disposisi', [DisposisiController::class, 'index']);
Route::get('/disposisi/{disposisi}', [DisposisiController::class, 'show']);

// Protected routes (require authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    // Admin only - full CRUD
    Route::middleware('check.role:admin')->group(function () {
        Route::post('/disposisi', [DisposisiController::class, 'store']);
        Route::put('/disposisi/{disposisi}', [DisposisiController::class, 'update']);
        Route::delete('/disposisi/{disposisi}', [DisposisiController::class, 'destroy']);
    });

    // Instruktur - can update disposition
    Route::middleware('check.role:instruktur')->group(function () {
        Route::put('/disposisi/{disposisi}', [DisposisiController::class, 'update']);
    });
});
