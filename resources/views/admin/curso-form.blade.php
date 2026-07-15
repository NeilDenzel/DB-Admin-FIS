@extends('layouts.admin')

@section('title', $curso ? 'Editar Curso - FIS Admin' : 'Nuevo Curso - FIS Admin')
@section('page-title', $curso ? 'Editar Curso' : 'Nuevo Curso')

@section('content')

<div class="mb-4">
    <a href="{{ url('admin/cursos') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver a cursos
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 sm:p-8 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
    <form method="POST" action="{{ $curso ? url('admin/cursos/' . $curso->cod_curso) : url('admin/cursos') }}"
          class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        @csrf
        @if ($curso)
            @method('PUT')
        @endif

        @if (!$curso)
        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Código *</label>
            <input type="text" name="cod_curso" value="{{ old('cod_curso') }}" required maxlength="15"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('cod_curso') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>
        @endif

        <div class="{{ $curso ? 'sm:col-span-2' : '' }}">
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Nombre *</label>
            <input type="text" name="nombre" value="{{ old('nombre', $curso->nombre ?? '') }}" required maxlength="120"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('nombre') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Ciclo *</label>
            <select name="ciclo"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                @foreach (range(1, 10) as $c)
                    <option value="{{ $c }}" {{ old('ciclo', $curso->ciclo ?? '') == $c ? 'selected' : '' }}>{{ $c }}°</option>
                @endforeach
            </select>
            @error('ciclo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Créditos *</label>
            <input type="number" step="0.1" name="creditos" value="{{ old('creditos', $curso->creditos ?? '') }}" required min="0" max="30"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('creditos') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Horas Teoría</label>
            <input type="number" name="horas_teoria" value="{{ old('horas_teoria', $curso->horas_teoria ?? 0) }}" min="0"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('horas_teoria') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Horas Práctica</label>
            <input type="number" name="horas_practica" value="{{ old('horas_practica', $curso->horas_practica ?? 0) }}" min="0"
                   class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
            @error('horas_practica') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Tipo *</label>
            <select name="tipo"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                <option value="Obligatorio" {{ old('tipo', $curso->tipo ?? '') == 'Obligatorio' ? 'selected' : '' }}>Obligatorio</option>
                <option value="Electivo" {{ old('tipo', $curso->tipo ?? '') == 'Electivo' ? 'selected' : '' }}>Electivo</option>
            </select>
            @error('tipo') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-600 mb-1.5">Malla *</label>
            <select name="id_malla"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                @foreach ($mallas as $m)
                    <option value="{{ $m->id_malla }}" {{ old('id_malla', $curso->id_malla ?? '') == $m->id_malla ? 'selected' : '' }}>{{ $m->nombre }}</option>
                @endforeach
            </select>
            @error('id_malla') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="sm:col-span-2 flex items-center gap-3 pt-2">
            <button type="submit"
                    class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-2xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_8px_15px_-8px_rgba(133,189,215,0.88)] transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                {{ $curso ? 'Guardar Cambios' : 'Crear Curso' }}
            </button>
            <a href="{{ url('admin/cursos') }}"
               class="px-4 py-2.5 text-sm text-slate-500 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-2xl transition-all duration-200">
                Cancelar
            </a>
        </div>
    </form>
</div>

@endsection
