@extends('layouts.admin')

@section('title', $estudiante ? 'Editar Estudiante - FIS Admin' : 'Nuevo Estudiante - FIS Admin')
@section('page-title', $estudiante ? 'Editar Estudiante' : 'Nuevo Estudiante')

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

<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 sm:p-8 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
    <form method="POST" action="{{ $estudiante ? url('admin/estudiantes/' . $estudiante->cod_estudiante) : url('admin/estudiantes') }}"
          class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        @csrf
        @if ($estudiante)
            @method('PUT')
        @endif

        <div class="sm:col-span-2">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">
                {{ $estudiante ? 'Editar datos del estudiante' : 'Registrar nuevo estudiante' }}
            </h3>
        </div>

        @if (!$estudiante)
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Código *</label>
            <input type="text" name="cod_estudiante" value="{{ old('cod_estudiante') }}" required maxlength="11"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('cod_estudiante') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">DNI *</label>
            <input type="text" name="dni" value="{{ old('dni', $estudiante->dni ?? '') }}" required maxlength="8"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('dni') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Nombres *</label>
            <input type="text" name="nombres" value="{{ old('nombres', $estudiante->nombres ?? '') }}" required maxlength="80"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('nombres') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Apellidos *</label>
            <input type="text" name="apellidos" value="{{ old('apellidos', $estudiante->apellidos ?? '') }}" required maxlength="80"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('apellidos') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Correo</label>
            <input type="email" name="correo" value="{{ old('correo', $estudiante->correo ?? '') }}" maxlength="120"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('correo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Teléfono</label>
            <input type="text" name="telefono" value="{{ old('telefono', $estudiante->telefono ?? '') }}" maxlength="20"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('telefono') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Sexo</label>
            <select name="sexo"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                <option value="">Sin especificar</option>
                <option value="M" {{ old('sexo', $estudiante->sexo ?? '') == 'M' ? 'selected' : '' }}>Masculino</option>
                <option value="F" {{ old('sexo', $estudiante->sexo ?? '') == 'F' ? 'selected' : '' }}>Femenino</option>
                <option value="O" {{ old('sexo', $estudiante->sexo ?? '') == 'O' ? 'selected' : '' }}>Otro</option>
            </select>
            @error('sexo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Ciclo Actual</label>
            <select name="ciclo_actual"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                <option value="">Sin asignar</option>
                @foreach (range(1, 10) as $c)
                    <option value="{{ $c }}" {{ old('ciclo_actual', $estudiante->ciclo_actual ?? '') == $c ? 'selected' : '' }}>{{ $c }}°</option>
                @endforeach
            </select>
            @error('ciclo_actual') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Malla</label>
            <select name="id_malla"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                <option value="">Sin asignar</option>
                @foreach ($mallas as $m)
                    <option value="{{ $m->id_malla }}" {{ old('id_malla', $estudiante->id_malla ?? '') == $m->id_malla ? 'selected' : '' }}>{{ $m->nombre }}</option>
                @endforeach
            </select>
            @error('id_malla') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2 flex items-center gap-3 pt-2">
            <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-2xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_8px_15px_-8px_rgba(133,189,215,0.88)] transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                {{ $estudiante ? 'Guardar Cambios' : 'Registrar Estudiante' }}
            </button>
            <a href="{{ url('admin/estudiantes') }}"
               class="px-4 py-2.5 text-sm text-slate-500 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-2xl transition-all duration-200">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
