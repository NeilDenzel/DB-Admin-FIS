@extends('layouts.admin')

@section('title', 'Mallas - FIS Admin')
@section('page-title', 'Mallas Curriculares')

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
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-end">
        <a href="{{ url('admin/mallas/crear') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_10px_20px_-8px_rgba(133,189,215,0.88)] transition-all duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Malla
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-blue-50/50">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Nombre</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Año Inicio</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Año Fin</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Vigente</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Créditos</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mallas as $m)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $m->nombre }}</td>
                    <td class="px-4 py-3 text-center text-slate-600">{{ $m->anio_inicio }}</td>
                    <td class="px-4 py-3 text-center text-slate-500">{{ $m->anio_fin ?? '—' }}</td>
                    <td class="px-4 py-3 text-center">
                        @if ($m->vigente)
                            <span class="inline-block px-2.5 py-1 text-xs font-medium rounded-lg bg-green-100 text-green-700">Sí</span>
                        @else
                            <span class="inline-block px-2.5 py-1 text-xs font-medium rounded-lg bg-slate-100 text-slate-500">No</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center text-slate-600">{{ $m->total_creditos ?? '—' }}</td>
                    <td class="px-4 py-3 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ url('admin/mallas/' . $m->id_malla . '/editar') }}"
                               class="inline-flex items-center gap-1 rounded-2xl bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-600 hover:bg-slate-200 transition-all duration-300">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Editar
                            </a>
                            <form method="POST" action="{{ url('admin/mallas/' . $m->id_malla) }}" onsubmit="return confirm('¿Eliminar esta malla?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 rounded-2xl bg-red-50 px-3 py-1.5 text-xs font-medium text-red-600 hover:bg-red-100 transition-all duration-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-slate-400">No hay mallas registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($mallas->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
        {{ $mallas->links() }}
    </div>
    @endif

    <div class="px-6 py-3 bg-blue-50/30 border-t border-slate-100 text-xs text-slate-500">
        Total: <strong>{{ $mallas->total() }}</strong> mallas
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
