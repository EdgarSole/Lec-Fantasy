<x-app-layout>
    <div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Encabezado -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-gray-100 sm:text-5xl mb-4">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                        Top Global
                    </span>
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Clasificación general de todos los equipos ordenados por puntuación
                </p>
            </div>

           <!-- Buscador -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-8 border border-gray-200 dark:border-gray-700">
                <div class="relative">
                    <input 
                        type="text" 
                        id="busqueda-global" 
                        placeholder="Buscar por usuario o liga..." 
                        class="w-full pl-10 pr-4 py-3 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    >
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Tabla de clasificación -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <!-- Cabecera de la tabla -->
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Clasificación Global</h3>
                        <span class="text-white/90 text-sm">
                            Total equipos: {{ $equipos->total() }}
                        </span>
                    </div>
                </div>
                
                <!-- Cuerpo de la tabla -->
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($equipos as $index => $equipo)
                    <div class="fila-equipo hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 {{ $equipo->usuario_id == auth()->id() ? 'bg-indigo-50 dark:bg-indigo-900' : '' }}">
                        <div class="px-6 py-4 flex items-center">
                            <!-- Posición global -->
                            <div class="w-12 flex-shrink-0 text-center">
                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full 
                                    @if($equipos->currentPage() == 1)
                                        @if($index + 1 == 1) bg-gradient-to-br from-yellow-400 to-yellow-600 text-white
                                        @elseif($index + 1 == 2) bg-gradient-to-br from-gray-300 to-gray-400 dark:from-gray-600 dark:to-gray-700 text-gray-800 dark:text-gray-200
                                        @elseif($index + 1 == 3) bg-gradient-to-br from-amber-600 to-amber-800 text-white
                                        @else bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 @endif
                                    @else
                                        bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300
                                    @endif
                                    font-bold">
                                    {{ ($equipos->currentPage() - 1) * $equipos->perPage() + $index + 1 }}
                                </span>
                            </div>
                            
                            <!-- Logo y nombre del usuario -->
                            <div class="flex items-center flex-1 min-w-0">
                                <div class="flex-shrink-0">
                                    <div class="relative h-14 w-14 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600 shadow-lg bg-gradient-to-tr from-white to-gray-100 dark:from-gray-700 dark:to-gray-900 p-0.5">
                                        <img
                                            class="h-full w-full object-cover rounded-full"
                                            src="{{ $equipo->usuario->foto_url }}"
                                            alt="Logo de {{ $equipo->usuario->nombre }}"
                                        >
                                    </div>
                                </div>

                                <div class="ml-4 min-w-0">
                                    <div class="flex items-center">
                                        <p class="text-lg font-bold truncate nombre-usuario text-gray-900 dark:text-gray-100">
                                            {{ $equipo->usuario->nombre }}
                                            @if($equipo->usuario_id == auth()->id())
                                                <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-800 text-indigo-800 dark:text-indigo-100">Tú</span>
                                            @endif
                                        </p>
                                    </div>
                                    <p class="text-sm mt-1 text-gray-500 dark:text-gray-400">
                                        <span class="nombre-liga font-semibold text-indigo-600 dark:text-indigo-400">
                                            {{ $equipo->liga->nombre ?? 'Sin liga' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Puntos -->
                            <div class="ml-4 flex-shrink-0">
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ number_format($equipo->puntos, 0, ',', '.') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Puntos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Paginación -->
                @if($equipos->hasPages())
                <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $equipos->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Script de filtrado -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('busqueda-global');
        const filas = document.querySelectorAll('.fila-equipo');

        input.addEventListener('input', function () {
            const filtro = this.value.toLowerCase();

            filas.forEach(fila => {
                const nombreUsuario = fila.querySelector('.nombre-usuario')?.textContent.toLowerCase() || '';
                const nombreLiga = fila.querySelector('.nombre-liga')?.textContent.toLowerCase() || '';

                const coincide = nombreUsuario.includes(filtro) || nombreLiga.includes(filtro);
                fila.style.display = coincide ? '' : 'none';
            });
        });
    });
    </script>
</x-app-layout>
