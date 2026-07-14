@extends('layouts.public')

@section('title', 'Quórum Verano - FIS')
@section('title', 'Estado de Quórum - Cursos de Verano FIS')

@section('content')

@if ($cursos->isEmpty())

<div class="text-center py-16">
    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    <p class="text-gray-400 text-lg">No hay datos de quórum disponibles.</p>
    <p class="text-gray-400 text-sm mt-1">Los resultados aparecerán cuando se registren encuestas de situación académica.</p>
</div>

@else

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

    @foreach ($cursos as $curso)

    @php
        $max = 8;
        $total = min($curso->total_interesados, $max);
        $porcentaje = $max > 0 ? round(($total / $max) * 100) : 0;

        $barraColor = match(true) {
            $curso->total_interesados >= 8 => 'bg-green-500',
            $curso->total_interesados >= 5 => 'bg-yellow-500',
            default => 'bg-red-400',
        };

        $textoEstado = match(true) {
            $curso->total_interesados >= 8 => '¡Quórum completo!',
            $curso->total_interesados >= 5 => 'Por alcanzar el quórum',
            default => 'Demanda baja',
        };
    @endphp

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition-shadow">

        <div class="flex items-start justify-between mb-3">
            <div>
                <h3 class="text-sm font-semibold text-gray-800 leading-tight">{{ $curso->nombre }}</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $curso->cod_curso }} · {{ $curso->ciclo }}° ciclo</p>
            </div>
            <span class="text-2xl font-bold {{ match(true) { $curso->total_interesados >= 8 => 'text-green-600', $curso->total_interesados >= 5 => 'text-yellow-600', default => 'text-red-500' } }}">
                {{ $curso->total_interesados }}
            </span>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
            <div class="h-3 rounded-full transition-all duration-500 {{ $barraColor }}" style="width: {{ $porcentaje }}%"></div>
        </div>

        <div class="flex justify-between text-xs mt-1.5">
            <span class="text-gray-400">Meta: {{ $max }} estudiantes</span>
            <span class="font-medium {{ match(true) { $curso->total_interesados >= 8 => 'text-green-600', $curso->total_interesados >= 5 => 'text-yellow-600', default => 'text-red-500' } }}">
                {{ $textoEstado }}
            </span>
        </div>

    </div>

    @endforeach

</div>

@endif

<div class="mt-6 text-xs text-gray-400 text-center space-y-1">
    <p>El quórum mínimo para abrir un curso de verano es de <strong class="text-gray-500">8 estudiantes</strong>.</p>
    <p>Datos actualizados automáticamente desde la encuesta de situación académica.</p>
</div>

@endsection
