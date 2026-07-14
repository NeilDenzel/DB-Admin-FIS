@extends('layouts.admin')

@section('title', 'Dashboard - FIS Admin')
@section('page-title', 'Semáforo de Quórum - Verano')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden transition-all duration-300 hover:shadow-md">

    <div class="px-6 py-4 border-b border-slate-100">
        <p class="text-sm text-slate-500">
            Demanda estimada de cursos para el ciclo de verano, basada en la encuesta de situación académica.
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-slate-500 uppercase">Código</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-slate-500 uppercase">Curso</th>
                    <th scope="col" class="px-6 py-4 text-left text-xs font-semibold tracking-wider text-slate-500 uppercase">Ciclo</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold tracking-wider text-slate-500 uppercase">Interesados</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold tracking-wider text-slate-500 uppercase">Estado</th>
                    <th scope="col" class="px-6 py-4 text-center text-xs font-semibold tracking-wider text-slate-500 uppercase">Acción</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse ($cursos as $curso)
                <tr class="hover:bg-slate-50 transition-all duration-300 border-b border-slate-100 last:border-b-0">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-slate-500">
                        {{ $curso->cod_curso }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800 max-w-[240px] truncate">
                        {{ $curso->nombre }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                        {{ $curso->ciclo }}° ciclo
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-semibold text-slate-700">
                        {{ $curso->total_interesados }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @php
                            $badge = match(true) {
                                $curso->total_interesados >= 8 => ['bg-green-100', 'text-green-800', 'Cumple Quórum'],
                                $curso->total_interesados >= 5 => ['bg-yellow-100', 'text-yellow-800', 'Por alcanzar'],
                                default => ['bg-red-100', 'text-red-800', 'Demanda baja'],
                            };
                        @endphp
                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge[0] }} {{ $badge[1] }}">
                            {{ $badge[2] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        {{-- Interactive Hover Button --}}
                        <a href="#" class="group relative inline-flex items-center gap-2 overflow-hidden rounded-full border border-slate-200 bg-white px-4 py-1.5 text-xs font-medium text-slate-600 transition-all duration-300 hover:border-blue-200 hover:text-blue-700 hover:bg-blue-50/50">
                            <span class="inline-block transition-all duration-300 group-hover:translate-x-8 group-hover:opacity-0">Detalle</span>
                            <span class="absolute inset-0 flex items-center justify-center gap-1 translate-x-8 opacity-0 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100 text-blue-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                                <span>Ver</span>
                            </span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        No hay datos de quórum disponibles.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-3 bg-slate-50/50 border-t border-slate-100 flex flex-wrap gap-4 sm:gap-6 text-xs text-slate-500">
        <span class="flex items-center gap-1.5">
            <span class="inline-block w-3 h-3 rounded-full bg-green-100 border border-green-300"></span> Cumple Quórum (&ge;8)
        </span>
        <span class="flex items-center gap-1.5">
            <span class="inline-block w-3 h-3 rounded-full bg-yellow-100 border border-yellow-300"></span> Por alcanzar (5-7)
        </span>
        <span class="flex items-center gap-1.5">
            <span class="inline-block w-3 h-3 rounded-full bg-red-100 border border-red-300"></span> Demanda baja (&lt;5)
        </span>
    </div>
</div>

@endsection
