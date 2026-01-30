<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| Web Routes - ACADEMIC SYSTEM
|--------------------------------------------------------------------------
|
| Pure Laravel Kursus (Academic Management System)
| All routes redirect to the single-page application
|
*/

// Language Switch
Route::get('language/{language}', [LanguageController::class, 'switch'])->name('language.switch');

// Authentication Routes (from auth.php)
require __DIR__.'/auth.php';

/**
 * MAIN ROUTES
 * 
 * The system is a Single Page Application (SPA)
 * All routes redirect to the appropriate SPA page:
 * - Unauthenticated: login.html
 * - Authenticated: dashboard.html / admin.html / data-management.html
 * 
 * API endpoints are in routes/api.php
 */

// Public Pages (Unauthenticated)
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
})->name('home');

Route::middleware('guest')->get('login', function () {
    return view('spa.login');
})->name('login');

// Protected Routes - Frontend handles auth check via JWT token
// No middleware needed here because client-side JavaScript validates token
Route::group([], function () {
    // Dashboard
    Route::get('dashboard', function () {
        return view('spa.dashboard-new');
    })->name('dashboard');
    
    // Admin Dashboard
    Route::get('admin', function () {
        return view('spa.admin-new');
    })->name('admin');
    
    // Mahasiswa Dashboard
    Route::get('mahasiswa-dashboard', function () {
        return view('spa.mahasiswa-dashboard');
    })->name('mahasiswa-dashboard');
    
    // Risalah Dashboard
    Route::get('risalah-dashboard', function () {
        return view('spa.risalah-dashboard');
    })->name('risalah-dashboard');
    
    // Risalah Dashboard New (Data Management Style)
    Route::get('risalah-dashboard-new', function () {
        return view('spa.risalah-dashboard-new');
    })->name('risalah-dashboard-new');
    
    // Instruktur Dashboard
    Route::get('instruktur-dashboard', function () {
        return view('spa.instruktur-dashboard');
    })->name('instruktur-dashboard');
    
    // Data Management
    Route::get('data-management', function () {
        return view('spa.data-management');
    })->name('data-management');
    
    // Enrollment Pages
    Route::get('kelas-browse', function () {
        return view('academic.browse-kelas');
    })->name('kelas-browse');
    
    Route::get('kelas-saya', function () {
        return view('spa.kelas-saya');
    })->name('kelas-saya');
    
    // Detail Kelas
    Route::get('kelas/{id}', function () {
        return view('academic.detail-kelas');
    })->name('kelas-detail');
    
    // Risalah Management (Instruktur)
    Route::get('risalah', function () {
        return view('academic.risalah-list');
    })->name('risalah-list');
    
    Route::get('risalah/create', function () {
        return view('academic.risalah-form');
    })->name('risalah-create');
    
    Route::get('risalah/{id}/edit', function () {
        return view('academic.risalah-form');
    })->name('risalah-edit');
    
    Route::get('risalah/{id}', function () {
        return view('academic.risalah-detail');
    })->name('risalah-detail');
});

/**
 * CATCH-ALL FALLBACK
 */
Route::fallback(function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});
