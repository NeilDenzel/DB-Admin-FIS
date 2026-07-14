<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminElectivosController;
use App\Http\Controllers\AdminReportesController;
use App\Http\Controllers\AdminImportController;

// Públicas
Route::get('/verano-quorum', [PublicController::class, 'quorum']);

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Admin (protegidas)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::get('/electivos', [AdminElectivosController::class, 'index']);
    Route::get('/reportes', [AdminReportesController::class, 'index']);
    Route::get('/importar', [AdminImportController::class, 'index']);
});
