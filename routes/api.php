<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use Modules\Academic\Http\Controllers\MahasiswaController;
use Modules\Academic\Http\Controllers\InstrukturController;
use Modules\Academic\Http\Controllers\KelasController;
use Modules\Academic\Http\Controllers\JadwalController;
use Modules\Academic\Http\Controllers\RisalahController;
use Modules\Academic\Http\Controllers\Api\AcademicApiController;
use Modules\Disposition\Http\Controllers\DisposisiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication routes (public)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected auth routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::post('/auth/refresh-token', [AuthController::class, 'refreshToken']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User Management Routes (CRUD operations with role-based access)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // All users can view
    Route::get('/users/{id}', [UserController::class, 'show']); // All users can view
    Route::post('/users', [UserController::class, 'store'])->middleware('role.authorize:admin,instruktur'); // Admin and Instruktur can create
    Route::put('/users/{id}', [UserController::class, 'update'])->middleware('role.authorize:admin,instruktur'); // Admin and Instruktur can update
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('role.authorize:admin,instruktur'); // Admin and Instruktur can delete
});

// ACADEMIC MODULE ROUTES
// Mahasiswa routes
Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
Route::post('/mahasiswa', [MahasiswaController::class, 'store'])->middleware(['auth:sanctum', 'role.authorize:admin,instruktur']);
Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update'])->middleware(['auth:sanctum', 'role.authorize:admin,instruktur']);
Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy'])->middleware(['auth:sanctum', 'role.authorize:admin']);

// Instruktur routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/instruktur', [InstrukturController::class, 'index']);
    Route::get('/instruktur/{id}', [InstrukturController::class, 'show']);
    Route::post('/instruktur', [InstrukturController::class, 'store'])->middleware('role.authorize:admin');
    Route::put('/instruktur/{id}', [InstrukturController::class, 'update'])->middleware('role.authorize:admin');
    Route::delete('/instruktur/{id}', [InstrukturController::class, 'destroy'])->middleware('role.authorize:admin');
});

// Kelas routes - IMPORTANT: /kelas/available MUST come before /kelas/{id} to avoid route conflict
Route::get('/kelas/available', [KelasController::class, 'getAvailableKelas']);
Route::get('/kelas', [KelasController::class, 'index']);
Route::get('/kelas/{id}', [KelasController::class, 'show']);
Route::post('/kelas', [KelasController::class, 'store'])->middleware(['auth:sanctum', 'role.authorize:admin,instruktur']);
Route::put('/kelas/{id}', [KelasController::class, 'update'])->middleware(['auth:sanctum', 'role.authorize:admin,instruktur']);
Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->middleware(['auth:sanctum', 'role.authorize:admin']);

// Jadwal routes
Route::get('/jadwal', [JadwalController::class, 'index']);
Route::get('/jadwal/{id}', [JadwalController::class, 'show']);
Route::post('/jadwal', [JadwalController::class, 'store'])->middleware(['auth:sanctum', 'role.authorize:admin,instruktur']);
Route::put('/jadwal/{id}', [JadwalController::class, 'update'])->middleware(['auth:sanctum', 'role.authorize:admin,instruktur']);
Route::delete('/jadwal/{id}', [JadwalController::class, 'destroy'])->middleware(['auth:sanctum', 'role.authorize:admin']);

// Disposisi routes
Route::get('/disposisi', [DisposisiController::class, 'index']);
Route::get('/disposisi/{id}', [DisposisiController::class, 'show']);
Route::post('/disposisi', [DisposisiController::class, 'store'])->middleware(['auth:sanctum', 'role.authorize:admin']);
Route::put('/disposisi/{id}', [DisposisiController::class, 'update'])->middleware(['auth:sanctum', 'role.authorize:admin']);
Route::delete('/disposisi/{id}', [DisposisiController::class, 'destroy'])->middleware(['auth:sanctum', 'role.authorize:admin']);

// ============ ACADEMIC API (Per-User) ============
Route::middleware('auth:sanctum')->group(function () {
    // Mahasiswa APIs - GET kelas & jadwal untuk user tertentu
    Route::get('/academic/mahasiswa/{userId}/kelas', [AcademicApiController::class, 'getMahasiswaKelas']);
    Route::get('/academic/mahasiswa/{userId}/jadwal', [AcademicApiController::class, 'getMahasiswaJadwal']);
    
    // Instruktur APIs - GET kelas & jadwal yang diajar
    Route::get('/academic/instruktur/{userId}/kelas', [AcademicApiController::class, 'getInstrukturKelas']);
    Route::get('/academic/instruktur/{userId}/jadwal', [AcademicApiController::class, 'getInstrukturJadwal']);
    
    // Admin APIs - GET semua data
    Route::get('/academic/kelas', [AcademicApiController::class, 'getAllKelas'])->middleware('role.authorize:admin');
    Route::get('/academic/jadwal', [AcademicApiController::class, 'getAllJadwal'])->middleware('role.authorize:admin');
    Route::get('/academic/instruktur', [AcademicApiController::class, 'getAllInstruktur'])->middleware('role.authorize:admin');
    Route::get('/academic/mahasiswa', [AcademicApiController::class, 'getAllMahasiswa'])->middleware('role.authorize:admin');
    
    // Detail endpoints
    Route::get('/academic/kelas/{kelasId}/detail', [AcademicApiController::class, 'getKelasDetail']);
    
    // ========== MAHASISWA ENROLLMENT ROUTES (Auth Required) ==========
    // GET - Kelas yang sudah diikuti mahasiswa
    Route::get('/mahasiswa/{userId}/kelas', [KelasController::class, 'getEnrolledKelas']);
    
    // POST - Enroll mahasiswa ke kelas
    Route::post('/mahasiswa/{userId}/kelas/{kelasId}/enroll', [KelasController::class, 'enrollKelas']);
    
    // DELETE - Unenroll (batalkan daftar) dari kelas
    Route::delete('/mahasiswa/{userId}/kelas/{kelasId}/unenroll', [KelasController::class, 'unenrollKelas']);
    
    // ========== RISALAH ROUTES (Instruktur & Admin Management) ==========
    Route::middleware('role.authorize:instruktur,admin')->group(function () {
        // Risalah CRUD - instruktur and admin can manage
        Route::get('/risalah', [RisalahController::class, 'index']);
        Route::post('/risalah', [RisalahController::class, 'store']);
        Route::get('/risalah/{id}', [RisalahController::class, 'show']);
        Route::put('/risalah/{id}', [RisalahController::class, 'update']);
        Route::delete('/risalah/{id}', [RisalahController::class, 'destroy']);
        
        // Helper endpoints
        Route::get('/risalah/kelas/list', [RisalahController::class, 'getKelasForInstruktur']);
    });
    
    // Public endpoints - anyone can view published risalah
    Route::get('/risalah/kelas/{kelasId}', [RisalahController::class, 'getByKelas']);
});