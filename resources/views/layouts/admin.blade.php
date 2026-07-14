<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin FIS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .mesh-gradient {
            background:
                radial-gradient(ellipse 80% 60% at 0% 20%, rgba(219,234,254,0.5) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 100% 80%, rgba(191,219,254,0.3) 0%, transparent 60%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 50%, #f1f5f9 100%);
        }
        .grid-pattern {
            background-image:
                linear-gradient(rgba(15,23,42,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15,23,42,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }
        .diagonal-pattern {
            background-image:
                linear-gradient(45deg, rgba(15,23,42,0.025) 1px, transparent 1px),
                linear-gradient(-45deg, rgba(15,23,42,0.025) 1px, transparent 1px);
            background-size: 40px 40px;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen mesh-gradient" x-data="{ sidebarOpen: false }">

    <div class="relative min-h-screen">
        <div class="fixed inset-0 grid-pattern pointer-events-none"></div>
        <div class="fixed inset-0 diagonal-pattern pointer-events-none"></div>

        <div class="relative flex h-screen overflow-hidden">

            {{-- Sidebar Desktop --}}
            <aside class="hidden md:flex md:flex-shrink-0">
                <nav class="flex flex-col w-64 bg-white border-r border-slate-200 h-full shadow-sm">
                    <div class="px-6 py-6 border-b border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-900 tracking-wide">FIS - Admin</h2>
                        <p class="text-xs text-slate-400 mt-0.5">Seguimiento Académico</p>
                    </div>
                    <div class="flex-1 flex flex-col px-3 py-4 space-y-1 overflow-y-auto">
                        <a href="{{ url('admin/dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->is('admin/dashboard*') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ url('admin/electivos') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->is('admin/electivos*') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <span>Sondeo Electivos</span>
                        </a>
                        <a href="{{ url('admin/reportes') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->is('admin/reportes*') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <span>Reportes Riesgo</span>
                        </a>
                        <a href="{{ url('admin/importar') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->is('admin/importar*') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <span>Importar Datos</span>
                        </a>
                    </div>
                </nav>
            </aside>

            {{-- Mobile Sidebar Overlay --}}
            <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 md:hidden" x-transition:enter="transition-opacity duration-300" x-transition:leave="transition-opacity duration-200">
                <div class="absolute inset-0 bg-slate-600/50" @click="sidebarOpen = false"></div>
                <div class="relative flex h-full max-w-xs">
                    <nav class="flex flex-col w-64 bg-white border-r border-slate-200 h-full shadow-xl">
                        <div class="flex items-center justify-between px-6 py-6 border-b border-slate-100">
                            <div>
                                <h2 class="text-lg font-semibold text-slate-900 tracking-wide">FIS - Admin</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Seguimiento Académico</p>
                            </div>
                            <button @click="sidebarOpen = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="flex-1 flex flex-col px-3 py-4 space-y-1 overflow-y-auto">
                            <a href="{{ url('admin/dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->is('admin/dashboard*') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}" @click="sidebarOpen = false">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ url('admin/electivos') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->is('admin/electivos*') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}" @click="sidebarOpen = false">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                <span>Sondeo Electivos</span>
                            </a>
                            <a href="{{ url('admin/reportes') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->is('admin/reportes*') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}" @click="sidebarOpen = false">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                <span>Reportes Riesgo</span>
                            </a>
                            <a href="{{ url('admin/importar') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 {{ request()->is('admin/importar*') ? 'bg-blue-50 text-blue-700' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700' }}" @click="sidebarOpen = false">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>Importar Datos</span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>

            {{-- Main Content Area --}}
            <div class="flex flex-col flex-1 min-w-0">

                {{-- Navbar --}}
                <header class="bg-white/80 backdrop-blur-sm border-b border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between h-16 px-4 sm:px-6">
                        <div class="flex items-center gap-3">
                            <button @click="sidebarOpen = true" class="md:hidden text-slate-500 hover:text-slate-700 focus:outline-none transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                </svg>
                            </button>
                            <h1 class="text-lg font-semibold text-slate-900">
                                @yield('page-title', 'Panel de Administración')
                            </h1>
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="text-sm text-slate-500">Admin</span>
                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-semibold shadow-sm">
                                A
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Page Content --}}
                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                    @yield('content')
                </main>

            </div>

        </div>
    </div>

</body>
</html>
