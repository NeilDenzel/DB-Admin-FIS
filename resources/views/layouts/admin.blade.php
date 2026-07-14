<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin FIS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        <aside class="hidden md:flex md:flex-shrink-0">
            <x-admin.sidebar />
        </aside>

        <div class="flex flex-col flex-1 min-w-0">

            <x-admin.navbar />

            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

        </div>

    </div>

    {{-- Mobile sidebar overlay --}}
    <div id="mobile-sidebar" class="fixed inset-0 z-40 hidden">
        <div class="absolute inset-0 bg-gray-600 opacity-75" onclick="toggleSidebar()"></div>
        <div class="relative flex h-full max-w-xs">
            <x-admin.sidebar />
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('mobile-sidebar').classList.toggle('hidden');
        }
    </script>

</body>
</html>
