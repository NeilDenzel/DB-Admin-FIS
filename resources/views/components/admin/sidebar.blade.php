<nav class="flex flex-col w-64 bg-gray-900 text-white h-full">

    <div class="px-6 py-6 border-b border-gray-700">
        <h2 class="text-lg font-semibold tracking-wide">FIS - Admin</h2>
        <p class="text-xs text-gray-400 mt-0.5">Seguimiento Académico</p>
    </div>

    <div class="flex-1 flex flex-col px-4 py-4 space-y-1 overflow-y-auto">

        <a href="{{ url('admin/dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/dashboard*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ url('admin/electivos') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/electivos*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Sondeo Electivos
        </a>

        <a href="{{ url('admin/reportes') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/reportes*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Reportes Riesgo
        </a>

        <a href="{{ url('admin/importar') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/importar*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Importar Datos
        </a>

    </div>

    <div class="px-4 py-4 border-t border-gray-700">
        <button onclick="toggleSidebar()" class="md:hidden flex items-center gap-2 text-sm text-gray-400 hover:text-white w-full">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cerrar menú
        </button>
    </div>

</nav>
