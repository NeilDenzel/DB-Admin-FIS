@extends('layouts.admin')

@section('title', 'Dashboard - FIS Admin')
@section('page-title', 'Semáforo de Quórum - Verano')

@section('content')

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

    <div class="px-6 py-4 border-b border-gray-100">
        <p class="text-sm text-gray-500">
            Demanda estimada de cursos para el ciclo de verano, basada en la encuesta de situación académica.
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Código
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Curso
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Ciclo
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Interesados
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        Estado
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse ($cursos as $curso)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-600">
                        {{ $curso->cod_curso }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                        {{ $curso->nombre }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $curso->ciclo }}° ciclo
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-semibold text-gray-700">
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
                        <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold {{ $badge[0] }} {{ $badge[1] }}">
                            {{ $badge[2] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        No hay datos de quórum disponibles.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex gap-6 text-xs text-gray-500">
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
