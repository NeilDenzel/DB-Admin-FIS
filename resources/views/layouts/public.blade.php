<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FIS - UNCP')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-gray-100 font-sans antialiased min-h-screen">

    <div class="max-w-4xl mx-auto px-4 py-8">

        <div class="text-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                @yield('title')
            </h1>
            <p class="text-gray-500 mt-1 text-sm">
                Facultad de Ingeniería de Sistemas - UNCP
            </p>
        </div>

        <main>
            @yield('content')
        </main>

        <footer class="mt-10 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} FIS - UNCP. Sistema de Seguimiento Académico.
        </footer>

    </div>

</body>
</html>
