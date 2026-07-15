@extends('layouts.admin')

@section('title', $estudiante->apellidos . ', ' . $estudiante->nombres . ' - FIS Admin')
@section('page-title', 'Historial Académico')

@section('content')

{{-- Breadcrumb --}}
<div class="mb-4 flex items-center justify-between">
    <a href="{{ url('admin/estudiantes') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Volver al listado
    </a>
    <a href="{{ url('admin/estudiantes/' . $estudiante->cod_estudiante . '/editar') }}"
       class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-500 text-white text-sm font-medium rounded-xl shadow-[0_5px_10px_-5px_rgba(133,189,215,0.88)] hover:shadow-[0_10px_20px_-8px_rgba(133,189,215,0.88)] transition-all duration-300">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Editar Estudiante
    </a>
</div>

{{-- Perfil del estudiante --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-6 sm:p-8 mb-6 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 text-white flex items-center justify-center text-2xl font-bold shadow-[0_8px_15px_-8px_rgba(133,189,215,0.88)] flex-shrink-0">
            {{ substr($estudiante->nombres, 0, 1) }}{{ substr($estudiante->apellidos, 0, 1) }}
        </div>
        <div class="flex-1 min-w-0">
            <h2 class="text-xl font-semibold text-slate-900">{{ $estudiante->apellidos }}, {{ $estudiante->nombres }}</h2>
            <div class="flex flex-wrap gap-x-6 gap-y-1 mt-1.5 text-sm text-slate-500">
                <span class="flex items-center gap-1.5">
                    <span class="font-mono text-blue-600 font-medium">{{ $estudiante->cod_estudiante }}</span>
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0"/>
                    </svg>
                    DNI {{ $estudiante->dni }}
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Ciclo <strong>{{ $estudiante->ciclo_actual ?? '—' }}</strong>
                </span>
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    {{ $estudiante->malla_nombre ?? 'Sin malla asignada' }}
                </span>
            </div>
            <div class="flex flex-wrap gap-x-6 gap-y-1 mt-1 text-xs text-slate-400">
                @if ($estudiante->correo)
                <span>{{ $estudiante->correo }}</span>
                @endif
                @if ($estudiante->telefono)
                <span>📞 {{ $estudiante->telefono }}</span>
                @endif
                @if ($estudiante->sexo)
                <span>Sexo: {{ $estudiante->sexo }}</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Situación Académica --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] overflow-hidden mb-6 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Situación Académica</h3>
            <p class="text-xs text-slate-400 mt-0.5">Estado actual por curso (encuesta)</p>
        </div>
        <span class="px-3 py-1 rounded-xl text-xs font-medium {{ $situacion->count() > 0 ? 'bg-blue-50 text-blue-600' : 'bg-slate-100 text-slate-400' }}">
            {{ $situacion->count() }} cursos
        </span>
    </div>

    @if ($situacion->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-blue-50/50">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Código</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Curso</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Ciclo</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Créd.</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Estado</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Desea Llevar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($situacion as $s)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $s->cod_curso }}</td>
                    <td class="px-4 py-3 text-slate-700 max-w-[250px] truncate">{{ $s->nombre }}</td>
                    <td class="px-4 py-3 text-center text-slate-500">{{ $s->ciclo }}°</td>
                    <td class="px-4 py-3 text-center text-slate-500">{{ $s->creditos }}</td>
                    <td class="px-4 py-3 text-center">
                        @php
                            $badge = match($s->estado) {
                                'Aprobado'   => 'bg-green-100 text-green-700',
                                'Desaprobado'=> 'bg-red-100 text-red-700',
                                'En Peligro' => 'bg-yellow-100 text-yellow-700',
                                'Pendiente'  => 'bg-orange-100 text-orange-700',
                                'No Llevado' => 'bg-slate-100 text-slate-600',
                                default      => 'bg-slate-100 text-slate-600',
                            };
                        @endphp
                        <span class="inline-block px-2.5 py-1 text-xs font-medium rounded-lg {{ $badge }}">
                            {{ $s->estado }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center text-sm">
                        @if ($s->desea_llevar === 'Si')
                            <span class="text-green-600 font-medium">Sí</span>
                        @elseif ($s->desea_llevar === 'No')
                            <span class="text-red-500">No</span>
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="px-6 py-10 text-center text-slate-400">
        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p>No hay datos de situación académica para este estudiante.</p>
        <p class="text-xs mt-1">Importa los datos desde <a href="{{ url('admin/importar') }}" class="text-blue-600 hover:underline">Importar Datos</a>.</p>
    </div>
    @endif
</div>

{{-- Historial de Matrículas --}}
<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] overflow-hidden transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Historial de Matrículas</h3>
            <p class="text-xs text-slate-400 mt-0.5">Notas y matrículas por periodo</p>
        </div>
        <span class="px-3 py-1 rounded-xl text-xs font-medium {{ $matriculas->count() > 0 ? 'bg-blue-50 text-blue-600' : 'bg-slate-100 text-slate-400' }}">
            {{ $matriculas->count() }} registros
        </span>
    </div>

    @if ($matriculas->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-blue-50/50">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Código</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Curso</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Ciclo</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Periodo</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">N° Mat.</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Nota</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Aprobado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matriculas as $m)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $m->cod_curso }}</td>
                    <td class="px-4 py-3 text-slate-700 max-w-[250px] truncate">{{ $m->nombre }}</td>
                    <td class="px-4 py-3 text-center text-slate-500">{{ $m->ciclo }}°</td>
                    <td class="px-4 py-3 text-center font-medium text-slate-600">{{ $m->periodo }}</td>
                    <td class="px-4 py-3 text-center text-slate-500">{{ $m->numero_matricula }}°</td>
                    <td class="px-4 py-3 text-center font-semibold {{ $m->nota_final !== null && $m->nota_final >= 10.5 ? 'text-green-600' : ($m->nota_final !== null ? 'text-red-600' : 'text-slate-300') }}">
                        {{ $m->nota_final !== null ? number_format($m->nota_final, 2) : '—' }}
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if ($m->aprobado === 1)
                            <span class="inline-flex items-center gap-1 text-green-600 text-xs font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Sí
                            </span>
                        @elseif ($m->aprobado === 0)
                            <span class="inline-flex items-center gap-1 text-red-500 text-xs font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                No
                            </span>
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="px-6 py-10 text-center text-slate-400">
        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p>No hay registros de matrícula para este estudiante.</p>
    </div>
    @endif
</div>

@endsection
