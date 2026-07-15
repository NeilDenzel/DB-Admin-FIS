@extends('layouts.admin')

@section('title', 'Estudiantes - FIS Admin')
@section('page-title', 'Listado de Estudiantes')

@section('content')

@if (session('success'))
<div class="bg-white rounded-2xl border border-green-200 shadow-[0_5px_15px_-8px_rgba(34,197,94,0.5)] p-4 mb-6 text-sm text-green-700 flex items-center gap-3">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] overflow-hidden transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">

    {{-- Header con botones --}}
    <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
        <a href="{{ url('admin/estudiantes/crear') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_10px_20px_-8px_rgba(133,189,215,0.88)] transition-all duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Estudiante
        </a>
        <a href="{{ url('admin/estudiantes/importar') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-medium rounded-xl hover:bg-slate-50 hover:border-slate-300 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Importar Excel
        </a>
    </div>

    {{-- Filtros --}}
    <div class="px-6 py-5 border-b border-slate-100">
        <form method="GET" action="{{ url('admin/estudiantes') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-medium text-slate-500 mb-1">Buscar</label>
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ $search }}"
                           placeholder="Código, nombres o apellidos..."
                           class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                </div>
            </div>

            <div class="w-28">
                <label class="block text-xs font-medium text-slate-500 mb-1">Ciclo</label>
                <select name="ciclo"
                        class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                    <option value="">Todos</option>
                    @foreach ($ciclos as $c)
                        <option value="{{ $c }}" {{ $ciclo == $c ? 'selected' : '' }}>{{ $c }}°</option>
                    @endforeach
                </select>
            </div>

            <div class="w-40">
                <label class="block text-xs font-medium text-slate-500 mb-1">Malla</label>
                <select name="id_malla"
                        class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                    <option value="">Todas</option>
                    @foreach ($mallas as $m)
                        <option value="{{ $m->id_malla }}" {{ $id_malla == $m->id_malla ? 'selected' : '' }}>{{ $m->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit"
                    class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-2xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_8px_15px_-8px_rgba(133,189,215,0.88)] transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                Filtrar
            </button>

            @if ($search || $ciclo || $id_malla)
                <a href="{{ url('admin/estudiantes') }}"
                   class="px-4 py-2.5 text-sm text-slate-500 hover:text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-2xl transition-all duration-200">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-blue-50/50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-blue-700 uppercase">Código</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-blue-700 uppercase">DNI</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-blue-700 uppercase">Apellidos</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-blue-700 uppercase">Nombres</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-blue-700 uppercase">Correo</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold tracking-wider text-blue-700 uppercase">Ciclo</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-blue-700 uppercase">Malla</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold tracking-wider text-blue-700 uppercase">Acción</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse ($estudiantes as $e)
                <tr class="hover:bg-blue-50/30 transition-all duration-300 border-b border-slate-100 last:border-b-0">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-slate-600">{{ $e->cod_estudiante }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-slate-500">{{ $e->dni }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">{{ $e->apellidos }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700">{{ $e->nombres }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400 max-w-[180px] truncate">{{ $e->correo ?? '—' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-semibold text-slate-600">{{ $e->ciclo_actual ? $e->ciclo_actual . '°' : '—' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">{{ $e->malla_nombre ?? 'Sin asignar' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ url('admin/estudiantes/' . $e->cod_estudiante) }}"
                               class="inline-flex items-center gap-1 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 px-3 py-1.5 text-xs font-medium text-white shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Ver
                            </a>
                            <a href="{{ url('admin/estudiantes/' . $e->cod_estudiante . '/editar') }}"
                               class="inline-flex items-center gap-1 rounded-2xl bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-200 transition-all duration-300">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        No se encontraron estudiantes.
                        @if ($search || $ciclo || $id_malla)
                            <p class="mt-1">Intenta con otros filtros.</p>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if ($estudiantes->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
        {{ $estudiantes->links() }}
    </div>
    @endif

    <div class="px-6 py-3 bg-blue-50/30 border-t border-slate-100 text-xs text-slate-500">
        Total: <strong>{{ $estudiantes->total() }}</strong> estudiantes
    </div>
</div>

<style>
    nav [aria-label="Pagination Navigation"] {
        display: flex;
        gap: 4px;
    }
    nav [aria-label="Pagination Navigation"] a,
    nav [aria-label="Pagination Navigation"] span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 8px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    nav [aria-label="Pagination Navigation"] a {
        color: #475569;
        border: 1px solid #e2e8f0;
        background: white;
    }
    nav [aria-label="Pagination Navigation"] a:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
    }
    nav [aria-label="Pagination Navigation"] span[aria-current="page"] span {
        background: linear-gradient(135deg, #2563eb, #06b6d4);
        color: white;
        border: none;
        box-shadow: 0 5px 10px -5px rgba(133,189,215,0.88);
    }
</style>

@endsection
