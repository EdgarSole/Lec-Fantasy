<x-app-layout>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300" x-data="{ sidebarOpen: window.innerWidth >= 1000, mobileMenuOpen: false }" x-init="() => {
        window.addEventListener('resize', () => {
            sidebarOpen = window.innerWidth >= 1000;
            if (window.innerWidth >= 1000) mobileMenuOpen = false;
        });
    }">
        <!-- Menú lateral -->
       <div
            x-show="sidebarOpen || mobileMenuOpen"
            x-transition
            :class="{
                'w-64': sidebarOpen || mobileMenuOpen,
                'fixed inset-0 z-40 translate-x-0': mobileMenuOpen,
                '-translate-x-full lg:translate-x-0': !mobileMenuOpen,
                'hidden': !(sidebarOpen || mobileMenuOpen)
            }"
            class="bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 shadow-lg border-r border-gray-200 dark:border-gray-700 flex flex-col transition-all duration-300 ease-in-out transform lg:relative"
        >

            <!-- Botón de cerrar en móvil -->
            <div class="lg:hidden flex justify-end p-4">
                <button @click="mobileMenuOpen = false" class="p-1 rounded-full text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-5 border-b border-gray-300 dark:border-gray-700 flex items-center bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700">
                <img src="{{ $liga->logo_url }}" alt="Logo Liga" class="min-w-14 h-14 rounded-full border-2 border-cyan-400 dark:border-cyan-500 object-cover shadow-md dark:shadow-cyan-500/20">
                
                <div class="ml-4 overflow-hidden">
                    <h1 class="text-lg font-bold text-gray-800 dark:text-gray-100 truncate">{{ $liga->nombre }}</h1>
                    <p class="text-cyan-600 dark:text-cyan-400 flex items-center text-sm mt-1">
                        <span class="inline-block w-2 h-2 bg-green-400 dark:bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        {{ $liga->usuario_id == auth()->id() ? __('messages.lider') : __('messages.miembro') }}
                    </p>
                </div>
            </div>

            <!-- Navegación -->
            <nav class="flex-1 flex flex-col justify-between py-6 px-3 space-y-2">
                <div class="space-y-2">
                    @php
                        $rutaActual = request()->route()->getName();
                    @endphp
                    <a href="{{ route('mi-liga', $liga) }}" 
                       x-on:click="if (window.innerWidth < 1000) mobileMenuOpen = false"
                       class="flex items-center py-4 px-4 rounded-lg font-medium transition-colors duration-150 border-l-4 {{ $rutaActual === 'mi-liga' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 border-blue-500 dark:border-cyan-500' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 {{ $rutaActual === 'mi-liga' ? 'text-blue-600 dark:text-cyan-400' : 'text-gray-600 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        @lang('messages.mi_liga')
                    </a>

                    <a href="{{ route('actividad', $liga) }}" 
                    x-on:click="if (window.innerWidth < 1000) mobileMenuOpen = false"
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-colors duration-150 border-l-4
                    {{ $rutaActual === 'actividad' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 border-blue-500 dark:border-cyan-500' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        @lang('messages.actividad')
                    </a>
                    
                    <a href="{{ route('mi-equipo', $liga) }}" 
                    x-on:click="if (window.innerWidth < 1000) mobileMenuOpen = false"
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-colors duration-150 border-l-4
                    {{ $rutaActual === 'mi-equipo' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 border-blue-500 dark:border-cyan-500' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @lang('messages.mi_equipo')
                    </a>
                    
                    <a href="{{ route('mercado', $liga) }}" 
                    x-on:click="if (window.innerWidth < 1000) mobileMenuOpen = false"
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-colors duration-150 border-l-4
                    {{ $rutaActual === 'mercado' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 border-blue-500 dark:border-cyan-500' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @lang('messages.mercado')
                    </a>
                    
                    <a href="{{ route('clasificacion', $liga) }}" 
                    x-on:click="if (window.innerWidth < 1000) mobileMenuOpen = false"
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-colors duration-150 border-l-4
                    {{ $rutaActual === 'clasificacion' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 border-blue-500 dark:border-cyan-500' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        @lang('messages.clasificacion')
                    </a>
                    
                    <a href="{{ route('chat', $liga) }}"
                    x-on:click="if (window.innerWidth < 1000) mobileMenuOpen = false"
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-colors duration-150 border-l-4
                    {{ $rutaActual === 'chat' ? 'bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 border-blue-500 dark:border-cyan-500' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8a9 9 0 100-18 9 9 0 000 18z" />
                        </svg>
                        @lang('messages.chat')
                    </a>
                </div>

                <!-- Sección inferior -->
                <div class="mt-auto space-y-4">
                    <a href="{{ route('inicio') }}" 
                       x-on:click="if (window.innerWidth < 1000) mobileMenuOpen = false"
                       class="flex items-center py-3 px-4 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-all border-l-4 border-gray-400 dark:border-gray-500">
                        <svg class="w-5 h-5 mr-3 text-gray-700 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        @lang('messages.volver_inicio')
                    </a>
                    
                    <div class="px-3 py-2 border-t border-gray-200 dark:border-gray-700 text-center text-xs text-gray-500 dark:text-gray-400">
                        <p> @lang('messages.liga_creada_el') {{ $liga->created_at->format('d/m/Y') }}</p>
                        <p class="mt-1">© {{ date('Y') }} LoL Fantasy</p>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Contenido principal -->
        <div class="flex-1 overflow-auto bg-white dark:bg-gray-800 transition-colors duration-300 relative">
            <!-- Botón de menú móvil (hamburguesa) -->
            <button 
                x-show="!mobileMenuOpen"
                x-transition
                @click="mobileMenuOpen = true" 
                class="lg:hidden fixed bottom-6 left-6 z-50 p-3 bg-blue-500 text-white rounded-full shadow-lg hover:bg-blue-600 transition-colors"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>


            <!-- Contenido de la vista -->
            <div class="p-8 pb-20 lg:pb-8">
                @yield('content')
            </div>
             
        </div>
    </div>
    
</x-app-layout>

<style>
    .w-64 {
        z-index: 50;
        position: relative;
    }
</style>