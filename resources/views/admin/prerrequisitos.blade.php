@extends('layouts.admin')

@section('title', 'Prerrequisitos - FIS Admin')
@section('page-title', 'Prerrequisitos')

@section('content')

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

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Formulario --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Asignar Prerrequisito</h3>
            <form method="POST" action="{{ url('admin/prerrequisitos') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Curso *</label>
                    <select name="cod_curso" required
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                        <option value="">Seleccionar curso</option>
                        @foreach ($cursos as $c)
                            <option value="{{ $c->cod_curso }}">[{{ $c->cod_curso }}] {{ $c->nombre }} ({{ $c->ciclo }}°)</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Prerrequisito *</label>
                    <select name="cod_prerrequisito" required
                            class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-[0_4px_6px_-4px_#cff0ff] transition-all duration-200">
                        <option value="">Seleccionar prerrequisito</option>
                        @foreach ($cursos as $c)
                            <option value="{{ $c->cod_curso }}">[{{ $c->cod_curso }}] {{ $c->nombre }} ({{ $c->ciclo }}°)</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                        class="w-full px-5 py-2.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-2xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_8px_15px_-8px_rgba(133,189,215,0.88)] transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                    Asignar
                </button>
            </form>
        </div>
    </div>

    {{-- Listado --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] overflow-hidden transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="text-lg font-semibold text-slate-900">Prerrequisitos Registrados</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-blue-50/50">
                        <tr>
                            <th class="text-left px-4 py-3 font-semibold text-slate-700">Curso</th>
                            <th class="text-left px-4 py-3 font-semibold text-slate-700">Nombre Curso</th>
                            <th class="text-left px-4 py-3 font-semibold text-slate-700">Prerrequisito</th>
                            <th class="text-left px-4 py-3 font-semibold text-slate-700">Nombre Prerreq.</th>
                            <th class="text-center px-4 py-3 font-semibold text-slate-700">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($prerrequisitos as $p)
                        <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3 font-mono text-xs text-slate-600">{{ $p->cod_curso }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $p->curso_nombre }}</td>
                            <td class="px-4 py-3 font-mono text-xs text-slate-600">{{ $p->cod_prerrequisito }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $p->prerreq_nombre }}</td>
                            <td class="px-4 py-3 text-center">
                                <form method="POST" action="{{ url('admin/prerrequisitos/' . $p->id_prerrequisito) }}" onsubmit="return confirm('¿Eliminar este prerrequisito?')">
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-slate-400">No hay prerrequisitos registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($prerrequisitos->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
                {{ $prerrequisitos->links() }}
            </div>
            @endif

            <div class="px-6 py-3 bg-blue-50/30 border-t border-slate-100 text-xs text-slate-500">
                Total: <strong>{{ $prerrequisitos->total() }}</strong> prerrequisitos
            </div>
        </div>
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
