<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FIS - UNCP')</title>
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

    <div class="relative min-h-screen">
        <div class="fixed inset-0 grid-pattern pointer-events-none"></div>
        <div class="fixed inset-0 diagonal-pattern pointer-events-none"></div>

        <div class="relative max-w-4xl mx-auto px-4 py-8">

            <div class="text-center mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-blue-600">
                    @yield('title')
                </h1>
                <p class="text-slate-500 mt-1 text-sm">
                    Facultad de Ingeniería de Sistemas - UNCP
                </p>
            </div>

            <main>
                @yield('content')
            </main>

            <footer class="mt-10 text-center text-xs text-slate-400">
                &copy; {{ date('Y') }} FIS - UNCP. Sistema de Seguimiento Académico.
            </footer>

        </div>
    </div>

</body>
</html>
