@extends('layouts.admin')

@section('title', $malla ? 'Editar Malla - FIS Admin' : 'Nueva Malla - FIS Admin')
@section('page-title', $malla ? 'Editar Malla Curricular' : 'Nueva Malla Curricular')

@section('content')

<div class="mb-4">
    <a href="{{ url('admin/mallas') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a mallas
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 sm:p-8 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
    <form method="POST" action="{{ $malla ? url('admin/mallas/' . $malla->id_malla) : url('admin/mallas') }}"
          class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        @csrf
        @if ($malla)
            @method('PUT')
        @endif

        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $malla->nombre ?? '') }}" required maxlength="30"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('nombre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Año Inicio *</label>
            <input type="number" name="anio_inicio" value="{{ old('anio_inicio', $malla->anio_inicio ?? '') }}" required min="2000" max="2099"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('anio_inicio') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Año Fin</label>
            <input type="number" name="anio_fin" value="{{ old('anio_fin', $malla->anio_fin ?? '') }}" min="2000" max="2099"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('anio_fin') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="flex items-center gap-2 mt-6">
                <input type="checkbox" name="vigente" value="1" {{ old('vigente', $malla->vigente ?? false) ? 'checked' : '' }}
                       class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                <span class="text-sm text-slate-600">Vigente</span>
            </label>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Total Créditos</label>
            <input type="number" step="0.01" name="total_creditos" value="{{ old('total_creditos', $malla->total_creditos ?? '') }}" min="0"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('total_creditos') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Resolución</label>
            <input type="text" name="resolucion" value="{{ old('resolucion', $malla->resolucion ?? '') }}" maxlength="80"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('resolucion') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2">
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Descripción</label>
            <textarea name="descripcion" rows="2" maxlength="150"
                      class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">{{ old('descripcion', $malla->descripcion ?? '') }}</textarea>
            @error('descripcion') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2 flex items-center gap-3 pt-2">
            <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-2xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_8px_15px_-8px_rgba(133,189,215,0.88)] transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                {{ $malla ? 'Guardar Cambios' : 'Crear Malla' }}
            </button>
            <a href="{{ url('admin/mallas') }}"
               class="px-4 py-2.5 text-sm text-slate-500 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-2xl transition-all duration-200">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
