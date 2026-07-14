<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — FIS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    </style>
</head>
<body class="font-sans antialiased min-h-screen mesh-gradient">

    <div class="relative min-h-screen flex flex-col">
        <div class="fixed inset-0 grid-pattern pointer-events-none"></div>
        <div class="fixed inset-0 diagonal-pattern pointer-events-none"></div>

        {{-- Header con logo --}}
        <header class="relative z-10 flex justify-center pt-8 sm:pt-12">
            <img src="{{ asset('images/logo-fis.png') }}" alt="FIS - UNCP"
                 class="h-16 sm:h-20 w-auto"
                 onerror="this.style.display='none'">
        </header>

        {{-- Card de login --}}
        <main class="relative z-10 flex-1 flex items-center justify-center px-4 pb-12">
            <div class="w-full max-w-[400px] bg-white rounded-3xl border border-slate-200 shadow-[0_30px_30px_-20px_rgba(133,189,215,0.88)] p-8 sm:p-10 mx-auto">
                <h1 class="text-center font-bold text-3xl text-blue-600 mb-8">
                    Iniciar Sesión
                </h1>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl text-sm text-red-700">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-2xl text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form class="form" action="{{ route('login') }}" method="POST">
                    @csrf

                    <input
                        placeholder="Correo electrónico"
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 text-sm text-slate-800 placeholder-slate-400 shadow-[0_8px_10px_-5px_#cff0ff] focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 {{ $errors->has('email') ? 'border-red-400' : '' }}"
                        required
                        autofocus
                    />

                    <input
                        placeholder="Contraseña"
                        id="password"
                        name="password"
                        type="password"
                        class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-3.5 text-sm text-slate-800 placeholder-slate-400 shadow-[0_8px_10px_-5px_#cff0ff] focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 mt-4"
                        required
                    />

                    <div class="mt-3 ml-2">
                        <a href="#" class="text-xs text-blue-600 hover:text-blue-700 transition-colors">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <button type="submit"
                            class="w-full font-bold bg-gradient-to-r from-blue-600 to-cyan-500 text-white py-3.5 mt-6 rounded-2xl shadow-[0_15px_15px_-10px_rgba(133,189,215,0.88)] border-none transition-all duration-200 ease-in-out hover:scale-[1.02] hover:shadow-[0_18px_15px_-12px_rgba(133,189,215,0.88)] active:scale-[0.98] active:shadow-[0_10px_10px_-8px_rgba(133,189,215,0.88)]">
                        INICIAR SESIÓN
                    </button>
                </form>
            </div>
        </main>
    </div>

</body>
</html>
