@extends('layouts.admin')

@section('title', 'Importar Estudiantes - FIS Admin')
@section('page-title', 'Importar Estudiantes desde Excel')

@section('content')

<div class="mb-4">
    <a href="{{ url('admin/estudiantes') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver al listado
    </a>
</div>

@if (session('success'))
<div class="bg-white rounded-2xl border border-green-200 shadow-[0_5px_15px_-8px_rgba(34,197,94,0.5)] p-4 mb-6 text-sm text-green-700 flex items-center gap-3">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

@if ($errors->any())
<div class="bg-white rounded-2xl border border-red-200 shadow-[0_5px_15px_-8px_rgba(239,68,68,0.5)] p-4 mb-6 text-sm text-red-700">
    @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 sm:p-8 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-r from-blue-600 to-cyan-500 flex items-center justify-center text-white shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
        </div>
        <div>
            <h2 class="text-lg font-semibold text-blue-600">Importar Nuevos Ingresantes</h2>
            <p class="text-xs text-slate-400 mt-0.5">Suba el archivo Excel con los datos de los estudiantes de la nueva promoción</p>
        </div>
    </div>

    <form action="{{ route('estudiantes.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Archivo Excel (.xlsx)</label>
            <input type="file" name="archivo" accept=".xlsx,.xls" required
                   class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3 text-sm text-slate-800 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff]">
        </div>

        <div class="bg-slate-50/50 rounded-2xl p-4 text-xs text-slate-500 space-y-1">
            <p class="font-semibold text-slate-600 mb-1">Columnas esperadas:</p>
            <code class="block text-blue-600">cod_estudiante, dni, nombres, apellidos, correo, telefono, sexo, ciclo_actual</code>
            <p class="mt-2">💡 La malla se asigna automáticamente según los primeros 4 dígitos del código de estudiante.</p>
            <p>💡 Los estudiantes duplicados (mismo código o DNI) se omiten automáticamente.</p>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-2xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_8px_15px_-8px_rgba(133,189,215,0.88)] transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                Importar Estudiantes
            </button>
            <a href="{{ url('admin/estudiantes') }}"
               class="px-4 py-2.5 text-sm text-slate-500 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-2xl transition-all duration-200">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
