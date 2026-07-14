<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminElectivosController;
use App\Http\Controllers\AdminReportesController;
use App\Http\Controllers\AdminImportController;

Route::get('/verano-quorum', [PublicController::class, 'quorum']);

Route::prefix('admin')->group(function () {
    // Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
    Route::get('/electivos', [AdminElectivosController::class, 'index']);
    Route::get('/reportes', [AdminReportesController::class, 'index']);
    Route::get('/importar', [AdminImportController::class, 'index']);

    // });
});
