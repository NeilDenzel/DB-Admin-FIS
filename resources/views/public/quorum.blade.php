<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quórum Verano - FIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .mesh-gradient {
            background:
                radial-gradient(ellipse 70% 55% at 10% 15%, rgba(219,234,254,0.6) 0%, transparent 60%),
                radial-gradient(ellipse 60% 45% at 90% 85%, rgba(191,219,254,0.35) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 50% 50%, rgba(240,249,255,0.5) 0%, transparent 50%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 40%, #f1f5f9 100%);
        }
        .grid-pattern {
            background-image:
                linear-gradient(rgba(15,23,42,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15,23,42,0.035) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .diagonal-pattern {
            background-image:
                linear-gradient(45deg, rgba(15,23,42,0.02) 1px, transparent 1px),
                linear-gradient(-45deg, rgba(15,23,42,0.02) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .text-reveal-word {
            opacity: 0;
            transform: translateY(16px);
            animation: fadeSlideUp 0.6s ease-out forwards;
        }
        @keyframes fadeSlideUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .progress-bar-fill {
            transition: width 1s ease-out;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen mesh-gradient" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">

    <div class="relative min-h-screen">
        <div class="fixed inset-0 grid-pattern pointer-events-none"></div>
        <div class="fixed inset-0 diagonal-pattern pointer-events-none"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Header --}}
            <div class="text-center mb-12">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-slate-900 leading-tight">
                    @php
                        $titleWords = explode(' ', 'Quórum de Verano FIS');
                    @endphp
                    @foreach ($titleWords as $index => $word)
                        <span class="text-reveal-word inline-block mr-3" style="animation-delay: {{ $index * 0.12 }}s">{{ $word }}</span>
                    @endforeach
                </h1>
                <p class="text-slate-500 mt-3 text-sm sm:text-base" x-show="loaded" x-transition:enter="transition duration-700 ease-out" x-transition:enter-start="opacity-0 translate-y-3" x-transition:enter-end="opacity-100 translate-y-0">
                    Facultad de Ingeniería de Sistemas — UNCP
                </p>
            </div>

            {{-- Content --}}
            @if ($cursos->isEmpty())

            <div class="text-center py-20 bg-white/60 backdrop-blur-sm rounded-2xl border border-slate-200 shadow-sm">
                <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-slate-400 text-lg">No hay datos de quórum disponibles.</p>
                <p class="text-slate-400 text-sm mt-1">Los resultados aparecerán cuando se registren encuestas de situación académica.</p>
            </div>

            @else

            {{-- Bento Grid: gap-6 para que respiren --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-show="loaded" x-transition:enter="transition duration-500 ease-out">
                @foreach ($cursos as $curso)
                    @php
                        $max = 8;
                        $total = min($curso->total_interesados, $max);
                        $porcentaje = $max > 0 ? round(($total / $max) * 100) : 0;

                        $bgBadge = match(true) {
                            $curso->total_interesados >= 8 => 'bg-green-100 text-green-800',
                            $curso->total_interesados >= 5 => 'bg-yellow-100 text-yellow-800',
                            default => 'bg-red-100 text-red-800',
                        };
                        $textoEstado = match(true) {
                            $curso->total_interesados >= 8 => '¡Quórum completo!',
                            $curso->total_interesados >= 5 => 'Por alcanzar',
                            default => 'Demanda baja',
                        };
                        $barraCompleta = $curso->total_interesados >= 8;
                        $barraColor = $barraCompleta ? 'bg-blue-500' : (match(true) {
                            $curso->total_interesados >= 5 => 'bg-yellow-500',
                            default => 'bg-red-400',
                        });
                    @endphp

                    <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-all duration-300">
                        {{-- Header de la tarjeta --}}
                        <div class="flex justify-between items-start gap-3 mb-4">
                            <div class="min-w-0 flex-1">
                                <h3 class="text-lg font-semibold text-slate-900 truncate">{{ $curso->nombre }}</h3>
                                <p class="text-sm text-slate-400 mt-0.5">{{ $curso->cod_curso }} · {{ $curso->ciclo }}° ciclo</p>
                            </div>
                            <div class="flex flex-col items-end gap-1 flex-shrink-0">
                                <span class="text-3xl font-bold leading-none {{ match(true) { $curso->total_interesados >= 8 => 'text-blue-600', $curso->total_interesados >= 5 => 'text-yellow-600', default => 'text-red-500' } }}">
                                    {{ $curso->total_interesados }}
                                </span>
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bgBadge }}">
                                    {{ $textoEstado }}
                                </span>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden mt-4">
                            <div class="h-2.5 rounded-full progress-bar-fill {{ $barraColor }}" style="width: 0%" x-init="$el.style.width = '{{ $porcentaje }}%'"></div>
                        </div>

                        <div class="flex justify-between text-xs mt-2">
                            <span class="text-slate-400">Meta: <strong class="text-slate-500">{{ $max }}</strong> estudiantes</span>
                            <span class="font-medium {{ match(true) { $curso->total_interesados >= 8 => 'text-blue-600', $curso->total_interesados >= 5 => 'text-yellow-600', default => 'text-red-500' } }}">
                                {{ $porcentaje }}%
                            </span>
                        </div>
                    </div>

                @endforeach
            </div>

            @endif

            {{-- Footer info --}}
            <div class="mt-10 text-xs text-slate-400 text-center space-y-1">
                <p>El quórum mínimo para abrir un curso de verano es de <strong class="text-slate-500">8 estudiantes</strong>.</p>
                <p>Datos actualizados automáticamente desde la encuesta de situación académica.</p>
            </div>

            <footer class="mt-10 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} FIS — UNCP. Sistema de Seguimiento Académico.
            </footer>

        </div>
    </div>

</body>
</html>
