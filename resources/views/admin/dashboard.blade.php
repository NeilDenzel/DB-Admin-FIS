@extends('layouts.admin')

@section('title', 'Dashboard - FIS Admin')
@section('page-title', 'Panel de Administración')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 flex items-center justify-center text-white shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-400">Estudiantes</p>
                <p class="text-2xl font-bold text-slate-900">{{ $totalEstudiantes }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 flex items-center justify-center text-white shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-400">Cursos</p>
                <p class="text-2xl font-bold text-slate-900">{{ $totalCursos }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 flex items-center justify-center text-white shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-400">Mallas</p>
                <p class="text-2xl font-bold text-slate-900">{{ $totalMallas }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-red-500 to-orange-400 flex items-center justify-center text-white shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-400">En Rezago</p>
                <p class="text-2xl font-bold text-red-600">{{ $totalRezago }}</p>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-8 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
    <h2 class="text-xl font-semibold text-slate-900 mb-2">Sistema de Seguimiento Académico</h2>
    <p class="text-slate-500 leading-relaxed">
        Bienvenido al sistema de administración y generación de reportes del seguimiento académico
        de la Facultad de Ingeniería de Sistemas de la Universidad Nacional del Centro del Perú.
        Utilice el menú lateral para gestionar estudiantes, mallas curriculares, cursos,
        prerrequisitos e historial académico.
    </p>
    <div class="mt-6 flex flex-wrap gap-4">
        <a href="{{ url('admin/estudiantes') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_10px_20px_-8px_rgba(133,189,215,0.88)] transition-all duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Ver Estudiantes
        </a>
        <a href="{{ url('admin/reportes') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-red-500 to-orange-400 text-white text-sm font-medium rounded-xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_10px_20px_-8px_rgba(133,189,215,0.88)] transition-all duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Ver Reportes
        </a>
    </div>
</div>

@endsection
