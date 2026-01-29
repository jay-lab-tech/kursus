<?php

use Illuminate\Support\Facades\Route;
use Modules\Academic\Http\Controllers\MahasiswaController;
use Modules\Academic\Http\Controllers\InstrukturController;
use Modules\Academic\Http\Controllers\KelasController;
use Modules\Academic\Http\Controllers\JadwalController;

// Public routes (no auth required for GET)
Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/instruktur', [InstrukturController::class, 'index']);
Route::get('/kelas', [KelasController::class, 'index']);
Route::get('/jadwal', [JadwalController::class, 'index']);

// Enrollment - available kelas harus public (no auth)
Route::get('/kelas/available', [KelasController::class, 'getAvailableKelas']);

Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
Route::get('/instruktur/{id}', [InstrukturController::class, 'show']);
Route::get('/kelas/{id}', [KelasController::class, 'show']);
Route::get('/jadwal/{id}', [JadwalController::class, 'show']);

// Protected routes (require authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    // Mahasiswa CRUD - all authenticated users can do basic CRUD
    Route::post('/mahasiswa', [MahasiswaController::class, 'store']);
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update']);
    Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy']);

    Route::post('/instruktur', [InstrukturController::class, 'store']);
    Route::put('/instruktur/{id}', [InstrukturController::class, 'update']);
    Route::delete('/instruktur/{id}', [InstrukturController::class, 'destroy']);

    Route::post('/kelas', [KelasController::class, 'store']);
    Route::put('/kelas/{id}', [KelasController::class, 'update']);
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy']);

    Route::post('/jadwal', [JadwalController::class, 'store']);
    Route::put('/jadwal/{id}', [JadwalController::class, 'update']);
    Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy']);
});
