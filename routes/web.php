<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminEstudiantesController;
use App\Http\Controllers\AdminReportesController;
use App\Http\Controllers\AdminMallasController;
use App\Http\Controllers\AdminCursosController;
use App\Http\Controllers\AdminPrerrequisitosController;

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Admin (protegidas)
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);

    Route::get('/estudiantes', [AdminEstudiantesController::class, 'index']);
    Route::get('/estudiantes/importar', [AdminEstudiantesController::class, 'showImportForm']);
    Route::post('/estudiantes/import', [AdminEstudiantesController::class, 'importExcel'])->name('estudiantes.import');
    Route::get('/estudiantes/crear', [AdminEstudiantesController::class, 'create']);
    Route::post('/estudiantes', [AdminEstudiantesController::class, 'store']);
    Route::get('/estudiantes/{cod_estudiante}', [AdminEstudiantesController::class, 'show']);
    Route::get('/estudiantes/{cod_estudiante}/editar', [AdminEstudiantesController::class, 'edit']);
    Route::put('/estudiantes/{cod_estudiante}', [AdminEstudiantesController::class, 'update']);

    Route::get('/mallas', [AdminMallasController::class, 'index']);
    Route::get('/mallas/crear', [AdminMallasController::class, 'create']);
    Route::post('/mallas', [AdminMallasController::class, 'store']);
    Route::get('/mallas/{id}/editar', [AdminMallasController::class, 'edit']);
    Route::put('/mallas/{id}', [AdminMallasController::class, 'update']);
    Route::delete('/mallas/{id}', [AdminMallasController::class, 'destroy']);

    Route::get('/cursos', [AdminCursosController::class, 'index']);
    Route::get('/cursos/crear', [AdminCursosController::class, 'create']);
    Route::post('/cursos', [AdminCursosController::class, 'store']);
    Route::get('/cursos/{cod_curso}/editar', [AdminCursosController::class, 'edit']);
    Route::put('/cursos/{cod_curso}', [AdminCursosController::class, 'update']);
    Route::delete('/cursos/{cod_curso}', [AdminCursosController::class, 'destroy']);

    Route::get('/prerrequisitos', [AdminPrerrequisitosController::class, 'index']);
    Route::post('/prerrequisitos', [AdminPrerrequisitosController::class, 'store']);
    Route::delete('/prerrequisitos/{id}', [AdminPrerrequisitosController::class, 'destroy']);

    Route::get('/reportes', [AdminReportesController::class, 'index']);
    Route::get('/reportes/pdf', [AdminReportesController::class, 'exportPdf']);
});
