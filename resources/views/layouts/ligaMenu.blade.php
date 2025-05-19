{{-- resources/views/layouts/ligaMenu.blade.php --}}
<x-app-layout>
    <div class="flex h-screen bg-gray-50">
        <!-- Menú lateral mejorado -->
        <div class="w-64 bg-gradient-to-b from-gray-50 to-gray-100 shadow-lg border-r border-gray-200 flex flex-col">
            <div class="p-5 border-b border-gray-300 flex items-center bg-gradient-to-r from-blue-50 to-indigo-50">
                <img src="{{ $liga->logo_url }}" alt="Logo Liga" class="w-14 h-14 rounded-full border-2 border-cyan-400 object-cover shadow-md">
                <div>
                    <h1 class="text-lg font-bold text-gray-800">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $liga->nombre }}</h1>
                    <p class="text-cyan-600 flex items-center text-sm mt-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                        {{ $liga->usuario_id == auth()->id() ? 'Líder' : 'Miembro' }}
                    </p>
                </div>
            </div>

            <!-- Navegación mejorada -->
            <nav class="flex-1 flex flex-col justify-between py-6 px-3 space-y-2">
                <div class="space-y-2">
                    @php
                        $rutaActual = Route::currentRouteName();
                    @endphp

                    <a href="{{ route('mi-liga', $liga) }}"
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-all duration-200 border-l-4
                    {{ $rutaActual === 'mi-liga' ? 'bg-blue-100 text-blue-700 border-blue-500' : 'text-gray-700 hover:bg-gray-200 border-transparent' }}">
                        <!-- Icono -->
                        <svg class="w-5 h-5 mr-3 {{ $rutaActual === 'mi-liga' ? 'text-blue-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Mi Liga
                    </a>

                    <a href="{{ route('actividad', $liga) }}" 
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-all duration-200 border-l-4
                    {{ $rutaActual === 'actividad' ? 'bg-blue-100 text-blue-700 border-blue-500' : 'text-gray-700 hover:bg-gray-200 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Actividad
                    </a>
                    <a href="{{ route('mi-equipo', $liga) }}" 
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-all duration-200 border-l-4
                    {{ $rutaActual === 'mi-equipo' ? 'bg-blue-100 text-blue-700 border-blue-500' : 'text-gray-700 hover:bg-gray-200 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Mi Equipo
                    </a>
                    <a href="{{ route('mercado', $liga) }}" 
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-all duration-200 border-l-4
                    {{ $rutaActual === 'mercado' ? 'bg-blue-100 text-blue-700 border-blue-500' : 'text-gray-700 hover:bg-gray-200 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Mercado
                    </a>
                    <a href="{{ route('clasificacion', $liga) }}"
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-all duration-200 border-l-4
                    {{ $rutaActual === 'clasificacion' ? 'bg-blue-100 text-blue-700 border-blue-500' : 'text-gray-700 hover:bg-gray-200 border-transparent' }}">
                        <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Clasificación
                    </a>
                    <a href="{{ route('chat', $liga) }}"
                    class="flex items-center py-4 px-4 rounded-lg font-medium transition-all duration-200 border-l-4
                    {{ $rutaActual === 'chat' ? 'bg-blue-100 text-blue-700 border-blue-500' : 'text-gray-700 hover:bg-gray-200 border-transparent' }}">
                    <svg class="w-5 h-5 mr-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8a9 9 0 100-18 9 9 0 000 18z" />
                    </svg>
                    Chat
                    </a>
                </div>

                <!-- Sección inferior con botón de volver -->
                <div class="mt-auto space-y-4">
                    <a href="{{ route('inicio') }}" class="flex items-center py-3 px-4 rounded-lg bg-gray-200 text-gray-800 font-medium hover:bg-gray-300 transition-all duration-200 border-l-4 border-gray-400">
                        <svg class="w-5 h-5 mr-3 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Volver a Inicio
                    </a>
                    
                    <div class="px-3 py-2 border-t border-gray-200 text-center text-xs text-gray-500">
                        <p>Liga creada el {{ $liga->created_at->format('d/m/Y') }}</p>
                        <p class="mt-1">© {{ date('Y') }} LoL Fantasy</p>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Contenido principal -->
        <div class="flex-1 p-8 overflow-auto bg-white">
            @yield('content')
        </div>
    </div>
</x-app-layout>