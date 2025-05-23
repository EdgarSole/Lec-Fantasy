@extends('layouts.ligaMenu')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Encabezado -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl mb-4">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 dark:from-indigo-400 dark:to-purple-400">
                    Clasificación
                </span>
            </h1>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-300">
                Liga: <span class="text-indigo-600 dark:text-indigo-400">{{ $liga->nombre }}</span>
            </h2>
        </div>

        <!-- Tabla de clasificación -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <!-- Cabecera de la tabla -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">General</h3>
                    <span class="text-white/90 text-sm">
                        Actualizado: {{ now()->addHours(2)->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>
            
            <!-- Cuerpo de la tabla -->
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($equipos as $index => $equipo)
                <div 
                    class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors   {{ $equipo->usuario_id == auth()->id() ? 'bg-indigo-50 dark:bg-indigo-900/30' : '' }} cursor-pointer"
                    onclick="mostrarJugadoresEquipo({{ $equipo->id }})"
                >
                    <div class="px-6 py-4 flex items-center">
                        <!-- Posición -->
                        <div class="w-12 flex-shrink-0 text-center">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full 
                                @if($index + 1 == 1) bg-gradient-to-br from-yellow-400 to-yellow-600 text-white
                                @elseif($index + 1 == 2) bg-gradient-to-br from-gray-300 to-gray-400 text-gray-800 dark:from-gray-400 dark:to-gray-500
                                @elseif($index + 1 == 3) bg-gradient-to-br from-amber-600 to-amber-800 text-white
                                @else bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 @endif
                                font-bold">
                                {{ $index + 1 }}
                            </span>
                        </div>
                        
                        <!-- Logo y nombre -->
                        <div class="flex items-center flex-1 min-w-0">
                            <div class="flex-shrink-0">
                                <div class="relative h-14 w-14 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600 shadow-lg bg-gradient-to-tr from-white to-gray-100 dark:from-gray-700 dark:to-gray-800 p-0.5 transition-transform hover:scale-105">
                                    <img
                                        class="h-full w-full object-cover rounded-full"
                                        src="{{ $equipo->usuario->foto_url }}"
                                        alt="Logo de {{ $equipo->usuario->nombre }}"
                                    >
                                </div>
                            </div>

                            <div class="ml-4 min-w-0">
                                <div class="flex items-center">
                                    <p class="text-lg font-bold text-gray-900 dark:text-white truncate">
                                        {{ $equipo->usuario->nombre }}
                                        @if($equipo->usuario_id == auth()->id())
                                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">Tú</span>
                                        @endif
                                    </p>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Valor del equipo: <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ number_format($equipo->valor_total, 0, ',', '.') }} €</span>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Puntos -->
                        <div class="ml-4 flex-shrink-0">
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($equipo->puntos, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Puntos</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Estadísticas adicionales -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Mejor equipo -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">🏆 Mejor equipo</h3>
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold">
                        1
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $equipos->first()->usuario->nombre }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($equipos->first()->puntos, 0, ',', '.') }} pts</p>
                    </div>
                </div>
            </div>
            
            <!-- Tu posición -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">🎯 Tu posición</h3>
                @php
                    $tuPosicion = $equipos->search(function($item) {
                        return $item->usuario_id == auth()->id();
                    }) + 1;
                @endphp
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                        {{ $tuPosicion }}
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900 dark:text-white">Tú</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ number_format($equipos->where('usuario_id', auth()->id())->first()->puntos ?? 0, 0, ',', '.') }} pts
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Peor equipo -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">💩 Peor equipo</h3>
                <div class="flex items-center">
                    <!-- Imagen del usuario -->
                    <div class="relative h-12 w-12 rounded-full overflow-hidden border border-gray-300 dark:border-gray-600 shadow-md bg-white dark:bg-gray-700 p-0.5">
                        <img 
                            src="{{ $equipos->last()->usuario->foto_url }}" 
                            alt="Avatar de {{ $equipos->last()->usuario->nombre }}" 
                            class="h-full w-full object-cover rounded-full"
                        >
                    </div>

                    <!-- Nombre y puntos -->
                    <div class="ml-4">
                        <p class="font-medium text-gray-900 dark:text-white">{{ $equipos->last()->usuario->nombre }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ number_format($equipos->last()->puntos, 0, ',', '.') }} pts</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de jugadores - Versión mejorada -->
<div id="jugadoresModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Fondo del modal con transición suave -->
        <div class="fixed inset-0 transition-opacity duration-300 ease-in-out" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 bg-opacity-75 dark:bg-opacity-85 backdrop-blur-sm"></div>
        </div>
        
        <!-- Contenido del modal con animación -->
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <!-- Header con gradiente -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 id="modalTitulo" class="text-xl font-bold text-white truncate"></h3>
                    <button onclick="cerrarModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Cuerpo del modal -->
            <div class="bg-white dark:bg-gray-800 px-6 py-4 max-h-[70vh] overflow-y-auto">
                <div id="jugadoresList" class="space-y-3">
                    <!-- Aquí se cargarán los jugadores dinámicamente -->
                </div>
            </div>
            
            <!-- Footer del modal -->
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-3 border-t border-gray-200 dark:border-gray-600">
                <button 
                    type="button" 
                    onclick="cerrarModal()" 
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-base font-medium text-white hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all   sm:ml-3 sm:w-auto sm:text-sm"
                >
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const jugadoresEquipos = @json($jugadoresEquiposArray);
    
    function mostrarJugadoresEquipo(equipoId) {
        // Filtrar jugadores del equipo seleccionado
        const jugadores = jugadoresEquipos.filter(je => je.equipo_id === equipoId);
        
        // Obtener el nombre del equipo (del elemento HTML)
        const equipoNombre = document.querySelector(`[onclick="mostrarJugadoresEquipo(${equipoId})"] .text-lg`).textContent.trim();
        
        // Configurar el título del modal
        document.getElementById('modalTitulo').textContent = `Jugadores de ${equipoNombre}`;
        
        // Generar HTML de los jugadores con nuevo diseño
        const jugadoresHTML = jugadores.map(jugador => `
            <div class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-500 transition-colors   shadow-sm">
                <div class="flex-shrink-0 relative">
                    <img 
                        src="${jugador.imagen_url}" 
                        alt="${jugador.nombre}" 
                        class="h-14 w-14 rounded-lg object-cover border-2 border-white dark:border-gray-800 shadow-md"
                    >
                </div>
                <div class="ml-4 flex-1 min-w-0">
                    <h4 class="text-md font-semibold text-gray-900 dark:text-white truncate">${jugador.nombre}</h4>
                    <div class="flex items-center mt-1 space-x-2">
                        <span class="text-xs font-medium px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200">${jugador.posicion}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">${jugador.equipo_real}</span>
                    </div>
                    <div class="mt-2">
                        <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded">${jugador.valor.toLocaleString()} €</span>
                        <span class="text-sm font-semibold text-amber-700 dark:text-amber-500 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-0.5 rounded">${jugador.puntos.toLocaleString()} Puntos</span>
                    </div>
                </div>
            </div>
        `).join('');
        
        // Insertar en el modal
        document.getElementById('jugadoresList').innerHTML = jugadoresHTML;
        
        // Mostrar el modal con animación
        const modal = document.getElementById('jugadoresModal');
        modal.classList.remove('hidden');
        modal.style.opacity = '0';
        setTimeout(() => { modal.style.opacity = '1' }, 10);
    }
    
    function cerrarModal() {
        const modal = document.getElementById('jugadoresModal');
        modal.style.opacity = '0';
        setTimeout(() => { modal.classList.add('hidden') }, 300);
    }
</script>
@endsection