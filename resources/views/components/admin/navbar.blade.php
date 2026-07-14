<header class="bg-white shadow-sm border-b border-gray-200">

    <div class="flex items-center justify-between h-16 px-6">

        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <h1 class="text-lg font-semibold text-gray-800">
                @yield('page-title', 'Panel de Administración')
            </h1>
        </div>

        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-500">Admin</span>
            <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-sm font-semibold">
                A
            </div>
        </div>

    </div>

</header>
