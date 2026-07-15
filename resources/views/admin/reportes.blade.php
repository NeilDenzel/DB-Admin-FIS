@extends('layouts.admin')

@section('title', 'Reportes de Riesgo - FIS Admin')
@section('page-title', 'Reportes de Riesgo y Rezago')

@push('scripts')
<script>
function toggleCursos(id) {
    const row = document.getElementById('cursos-' + id);
    const icon = document.getElementById('icon-' + id);
    const expanded = row.style.display === '';
    row.style.display = expanded ? 'none' : '';
    icon.textContent = expanded ? '+' : '−';
}
</script>
@endpush

@section('content')

<div class="bg-white rounded-3xl border border-slate-200 shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] p-8 transition-all duration-300 hover:shadow-[0_25px_25px_-15px_rgba(133,189,215,0.88)]">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-semibold text-slate-900">Estudiantes en Rezago Académico</h2>
            <p class="text-sm text-slate-400 mt-1">Estudiantes con cursos en estado distinto de "Aprobado"</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ url('admin/reportes/pdf') }}" target="_blank"
               class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-xl transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Exportar PDF
            </a>
            <span class="px-3 py-1.5 bg-red-50 text-red-600 text-sm font-medium rounded-xl">
                {{ count($rezago) }} estudiantes
            </span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-blue-50/50">
                    <th class="text-left px-4 py-3 font-semibold text-slate-700 rounded-tl-2xl w-8"></th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Código</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Apellidos</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700">Nombres</th>
                    <th class="text-center px-4 py-3 font-semibold text-slate-700">Cursos en Riesgo</th>
                    <th class="text-left px-4 py-3 font-semibold text-slate-700 rounded-tr-2xl">Estados</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rezago as $i => $r)
                <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition-colors cursor-pointer" onclick="toggleCursos({{ $i }})">
                    <td class="px-4 py-3 text-slate-400 text-lg select-none" id="icon-{{ $i }}">+</td>
                    <td class="px-4 py-3 font-mono text-xs text-slate-600">{{ $r['cod_estudiante'] }}</td>
                    <td class="px-4 py-3 text-slate-700">{{ $r['apellidos'] }}</td>
                    <td class="px-4 py-3 text-slate-700">{{ $r['nombres'] }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold {{ count($r['cursos']) > 2 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ count($r['cursos']) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $estados = collect($r['cursos'])->pluck('estado')->unique();
                        @endphp
                        @foreach($estados as $e)
                            @php
                                $badge = match($e) {
                                    'Desaprobado' => 'bg-red-100 text-red-700',
                                    'En Peligro'  => 'bg-yellow-100 text-yellow-700',
                                    'Pendiente'   => 'bg-orange-100 text-orange-700',
                                    'No Llevado'  => 'bg-slate-100 text-slate-600',
                                    default       => 'bg-slate-100 text-slate-600',
                                };
                            @endphp
                            <span class="inline-block px-2.5 py-1 text-xs font-medium rounded-lg {{ $badge }} mr-1">{{ $e }}</span>
                        @endforeach
                    </td>
                </tr>
                <tr id="cursos-{{ $i }}" style="display:none">
                    <td colspan="6" class="px-4 py-0">
                        <table class="w-full text-xs">
                            @foreach($r['cursos'] as $c)
                            <tr class="border-b border-slate-50 last:border-b-0">
                                <td class="py-2 pl-10 font-mono text-slate-500 w-28">{{ $c['cod_curso'] }}</td>
                                <td class="py-2 text-slate-600">{{ $c['curso'] }}</td>
                                <td class="py-2 w-28">
                                    @php
                                        $badge = match($c['estado']) {
                                            'Desaprobado' => 'bg-red-100 text-red-700',
                                            'En Peligro'  => 'bg-yellow-100 text-yellow-700',
                                            'Pendiente'   => 'bg-orange-100 text-orange-700',
                                            'No Llevado'  => 'bg-slate-100 text-slate-600',
                                            default       => 'bg-slate-100 text-slate-600',
                                        };
                                    @endphp
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-lg {{ $badge }}">
                                        {{ $c['estado'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-slate-400">
                        No hay estudiantes en rezago académico.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
