
<x-app-layout>
    @section('content')
    <div id="loading-screen" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 transition-opacity duration-5000">
        <div class="text-center">
            <!-- Logo gaming o texto -->
            <div class="mb-6 text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">
                LEC FANTASY
            </div>

            <div class="relative w-20 h-20 mx-auto mb-6">
                <div class="absolute inset-0 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                <div class="absolute inset-2 border-4 border-purple-600 border-b-transparent rounded-full animate-spin animation-delay-200"></div>
            </div>

            <!-- Texto cargando con efecto -->
            <div class="text-xl font-semibold text-white">
                <span class="animate-pulse">CARGANDO</span>
                <span class="animate-pulse animation-delay-100">.</span>
                <span class="animate-pulse animation-delay-200">.</span>
                <span class="animate-pulse animation-delay-300">.</span>
            </div>

            <!-- Barra de progreso -->
            <div class="w-64 h-2 mt-6 bg-gray-700 rounded-full overflow-hidden mx-auto">
                <div id="progress-bar" class="h-full bg-gradient-to-r from-blue-500 to-purple-600 rounded-full transition-all duration-[2000ms]"></div>
            </div>
        </div>
    </div>

    <div id="content" class="hidden">
        <!-- Buscador principal en el header -->
        <x-slot name="header">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-800 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    BUSCADOR DE JUGADORES LEC
                </h2>
                <div class="relative w-full md:w-1/3">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-blue-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="nombreFilter" class="block w-full p-3 pl-10 text-base text-gray-800 border-2 border-blue-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-300 focus:border-blue-500 shadow-sm transition-all duration-300" placeholder="Buscar jugador por nombre..." autocomplete="off">
                </div>
            </div>
        </x-slot>

        <div class="py-6 px-4 bg-gradient-to-b from-blue-50 to-white min-h-screen">
            <!-- Filtros -->
            <div class="bg-white rounded-2xl shadow-lg mb-8 p-6 border-2 border-blue-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Filtro por posición -->
                    <div>
                        <label for="posicionFilter" class="block mb-2 text-sm font-semibold text-gray-700 uppercase">Posición</label>
                        <select id="posicionFilter" class="bg-white border-2 border-blue-200 text-gray-700 text-base rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-500 block w-full p-3 shadow-sm transition-all duration-300">
                            <option value="">Todas las posiciones</option>
                            <option value="Top">Top</option>
                            <option value="Jungla">Jungla</option>
                            <option value="Mid">Mid</option>
                            <option value="Adc">ADC</option>
                            <option value="Support">Support</option>
                        </select>
                    </div>

                    <!-- Filtro por equipo -->
                    <div>
                        <label for="equipoFilter" class="block mb-2 text-sm font-semibold text-gray-700 uppercase">Equipo</label>
                        <select id="equipoFilter" data-placeholder="Todos los equipos" class="bg-white border-2 border-blue-200 text-gray-700 text-base rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-500 block w-full p-3 shadow-sm transition-all duration-300">
                            <option value="">Todos los equipos</option>
                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo }}" data-logo="{{ $logosEquipos[$equipo] ?? '' }}">
                                    {{ $equipo }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Ordenar por -->
                    <div>
                        <label for="ordenFilter" class="block mb-2 text-sm font-semibold text-gray-700 uppercase">Ordenar por</label>
                        <select id="ordenFilter" class="bg-white border-2 border-blue-200 text-gray-700 text-base rounded-xl focus:ring-2 focus:ring-blue-300 focus:border-blue-500 block w-full p-3 shadow-sm transition-all duration-300">
                            <option value="puntos_desc">Puntos (mayor a menor)</option>
                            <option value="puntos_asc">Puntos (menor a mayor)</option>                            
                            <option value="nombre_asc">Nombre (A-Z)</option>
                            <option value="nombre_desc">Nombre (Z-A)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Listado de jugadores - 3 por fila -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="jugadoresContainer">
                @foreach($jugadores as $jugador)
                @php
                    $stats = $jugador->estadisticas;
                    $kills = $stats->kills ?? 0;
                    $asistencias = $stats->asistencias ?? 0;
                    $muertes = $stats->muertes ?? 1;
                    $kda = number_format(($kills + $asistencias) / ($muertes ?: 1), 2);
                    
                    // Colores según posición
                    $positionColors = [
                        'Top' => 'bg-red-500',
                        'Jungla' => 'bg-green-500',
                        'Mid' => 'bg-yellow-500',
                        'ADC' => 'bg-blue-500',
                        'Support' => 'bg-purple-500'
                    ];
                    $positionBg = $positionColors[$jugador->posicion] ?? 'bg-gray-500';
                @endphp

                <div class="jugador-card group bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 hover:border-indigo-300 relative"
                    data-nombre="{{ strtolower($jugador->nombre) }}"
                    data-posicion="{{ $jugador->posicion }}"
                    data-equipo="{{ $jugador->equipo_real }}"
                    data-puntos="{{ $jugador->puntos }}"
                    data-jugador-id="{{ $jugador->id }}">
                    
                    <!-- Banda superior con posición -->
                    <div class="absolute top-0 left-0 w-full h-2 {{$positionBg}}"></div>
                    
                    <!-- Encabezado con equipo -->
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex items-center space-x-2">
                            @if(isset($logosEquipos[$jugador->equipo_real]))
                            <img src="{{ $logosEquipos[$jugador->equipo_real] }}" alt="{{ $jugador->equipo_real }}" 
                                class="w-6 h-6 object-contain rounded-full border border-gray-200 bg-white p-0.5">
                            @endif
                            <span class="text-sm font-semibold text-gray-700 truncate max-w-[120px]">{{ $jugador->equipo_real }}</span>
                        </div>
                        
                        <!-- Badge de posición -->
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm
                            @if($jugador->posicion == 'Top') bg-red-100 text-red-800
                            @elseif($jugador->posicion == 'Jungla') bg-green-100 text-green-800
                            @elseif($jugador->posicion == 'Mid') bg-yellow-100 text-yellow-800
                            @elseif($jugador->posicion == 'ADC') bg-blue-100 text-blue-800
                            @else bg-purple-100 text-purple-800
                            @endif">
                            <img src="@switch($jugador->posicion)
                                @case('Top') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117549/topLogo_rsvrc0.png @break
                                @case('Jungla') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117550/jngLogo_azrjmn.webp @break
                                @case('Mid') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/midLogo_kn7okb.png @break
                                @case('Adc') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/adcLogo_idgdnc.png @break
                                @default https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/supportLogo_gcrpbi.png
                            @endswitch"
                            alt="{{ $jugador->posicion }}" class="w-3 h-3 mr-1">
                            {{ $jugador->posicion }}
                        </span>
                    </div>
                    
                    <!-- Imagen del jugador con efecto hover -->
                    <div class="flex justify-center mt-2 px-4 relative">
                        <div class="relative group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 opacity-20 blur-md -z-10 group-hover:opacity-30 transition-opacity duration-300"></div>
                            <img src="{{ $jugador->imagen_url ?? 'https://via.placeholder.com/150' }}" 
                                alt="{{ $jugador->nombre }}" 
                                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-md">
                            <!-- Efecto hover sobre la imagen -->
                            <div class="absolute inset-0 rounded-full bg-gradient-to-t from-gray-900/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                                <span class="text-white font-bold text-sm bg-black/50 px-2 py-1 rounded-full cursor-pointer" onclick="mostrarEstadisticasJugador({{ $jugador->id }})">
                                    Ver detalles
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nombre del jugador -->
                    <div class="text-center mt-4 px-4">
                        <h3 class="text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors duration-300">
                            {{ $jugador->nombre }}
                        </h3>
                    </div>
                    
                    <!-- Estadísticas principales -->
                    <div class="grid grid-cols-2 gap-3 p-4 mt-2">
                        <!-- KDA -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-3 text-center border border-blue-200 shadow-sm group-hover:shadow-md transition-shadow duration-300">
                            <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">KDA RATIO</p>
                            <p class="text-xl font-bold text-gray-800 mt-1 flex items-center justify-center">
                                {{ $kda }}

                                @if($kda > 5)
                                    <span class="ml-1 text-xs bg-blue-100 text-blue-800 px-1.5 py-0.5 rounded-full">TOP</span>
                                @elseif($kda >= 3 && $kda <= 5)
                                    <span class="ml-1 text-xs bg-green-100 text-green-800 px-1.5 py-0.5 rounded-full">BUENO</span>
                                @elseif($kda >= 2 && $kda < 3)
                                    <span class="ml-1 text-xs bg-orange-100 text-orange-800 px-1.5 py-0.5 rounded-full">NORMAL</span>
                                @else
                                    <span class="ml-1 text-xs bg-red-100 text-red-800 px-1.5 py-0.5 rounded-full">MALO</span>
                                @endif

                            </p>
                            <p class="text-xs text-gray-500 mt-1">{{ $kills }}/{{ $muertes }}/{{ $asistencias }}</p>
                        </div>
                        
                        <!-- Puntos -->
                        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-3 text-center border border-yellow-200 shadow-sm group-hover:shadow-md transition-shadow duration-300">
                            <p class="text-xs font-semibold text-yellow-600 uppercase tracking-wider">PUNTOS</p>
                            <p class="text-xl font-bold text-yellow-700 mt-1 flex items-center justify-center">
                                {{ $jugador->puntos }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">Total Fantasy</p>
                        </div>
                    </div>
                    
                    <!-- Botón de ver estadísticas -->
                    <div class="px-4 pb-4">
                        <button class="w-full flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform group-hover:scale-[1.02]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>VER ESTADÍSTICAS</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="estadisticasModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Fondo del modal - ahora con onclick -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="cerrarEstadisticasModal()">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm"></div>
            </div>
            
            <!-- Contenido del modal - evita que el click se propague -->
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full" onclick="event.stopPropagation()">
                    <!-- Header con gradiente -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img id="modalJugadorImagen" src="" alt="" class="w-24 h-24 rounded-full border-4 border-white shadow-lg mr-6 object-cover">

                                <div>
                                    <h3 id="modalJugadorNombre" class="text-xl font-bold text-white"></h3>
                                    <div class="flex items-center mt-1">
                                        <span id="modalJugadorEquipo" class="text-sm text-white/90 flex items-center"></span>
                                        <span class="mx-2 text-white/50">•</span>
                                        <span id="modalJugadorPosicion" class="text-sm font-medium text-white"></span>
                                        <span class="mx-2 text-white/50">•</span>
                                        <span id="modalJugadorValor" class="text-sm font-medium text-white"><p></p></span>
                                    </div>
                                </div>
                            </div>
                            <button onclick="cerrarEstadisticasModal()" class="text-white hover:text-gray-200 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Cuerpo del modal -->
                    <div class="bg-white px-6 py-4 max-h-[70vh] overflow-y-auto">
                        <!-- Puntos y KDA destacados -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-blue-50 rounded-xl p-4 border-2 border-blue-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-semibold text-blue-600 uppercase">Puntos totales</p>
                                        <p id="modalJugadorPuntos" class="text-2xl font-bold text-gray-800 mt-1">0</p>
                                    </div>
                                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 rounded-xl p-4 border-2 border-green-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-semibold text-green-600 uppercase">KDA Ratio</p>
                                        <p id="modalJugadorKDA" class="text-2xl font-bold text-gray-800 mt-1">0.00</p>
                                        <p id="modalJugadorKillsMuertesAsistencias" class="text-xs text-gray-500 mt-1">0 / 0 / 0</p>
                                    </div>
                                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Estadísticas detalladas en tabs -->
                        <div class="mb-6">
                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex space-x-8">
                                    <button onclick="cambiarTab('combate')" id="tabCombate" class="tab-activo whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                                        Combate
                                    </button>
                                    <button onclick="cambiarTab('objetivos')" id="tabObjetivos" class="tab-inactivo whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        Objetivos
                                    </button>
                                    <button onclick="cambiarTab('economia')" id="tabEconomia" class="tab-inactivo whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                        Economía
                                    </button>
                                </nav>
                            </div>
                        </div>
                        
                        <!-- Contenido de los tabs -->
                        <div id="contenidoCombate" class="tab-contenido grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Estadísticas de combate -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    Estadísticas de Combate
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Daño a campeones</span>
                                        <span id="estadDanioCampeones" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Daño recibido</span>
                                        <span id="estadDanioRecibido" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Tiempo muerto /s</span>
                                        <span id="estadTiempoMuerto" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Multikills
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Solo kills</span>
                                        <span id="estadSoloKills" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Double kills</span>
                                        <span id="estadDoubleKills" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Triple kills</span>
                                        <span id="estadTripleKills" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Quadra kills</span>
                                        <span id="estadQuadraKills" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Penta kills</span>
                                        <span id="estadPentaKills" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="contenidoObjetivos" class="tab-contenido hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Estadísticas de objetivos -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                    </svg>
                                    Objetivos
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Puntos de visión</span>
                                        <span id="estadPuntosVision" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Objetivos robados</span>
                                        <span id="estadObjetivoRobado" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Daño a torres</span>
                                        <span id="estadDanioTorres" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Primera sangre</span>
                                        <span id="estadPrimeraSangre" class="text-sm font-medium text-gray-800">No</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Primera torre</span>
                                        <span id="estadPrimeraTorre" class="text-sm font-medium text-gray-800">No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="contenidoEconomia" class="tab-contenido hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Estadísticas de economía -->
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Economía
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Oro total</span>
                                        <span id="estadOro" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Botín conseguido</span>
                                        <span id="estadBotinConseguido" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Botín perdido</span>
                                        <span id="estadBotinPerdido" class="text-sm font-medium text-gray-800">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            border: 2px solid #bfdbfe !important;
            border-radius: 0.75rem !important;
            padding: 0.75rem !important;
            height: auto !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            right: 8px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0 !important;
            color: #374151 !important;
            line-height: 1.5 !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6 !important;
        }
        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #eef2ff !important;
            color: #1e40af !important;
        }
        .select2-results__option {
            padding: 8px 12px !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        .select2-container--default .select2-selection--single:focus {
            outline: none !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5) !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar la pantalla de carga
        const loadingScreen = document.getElementById('loading-screen');
        const content = document.getElementById('content');
        const progressBar = document.getElementById('progress-bar');
        
        // Animación de la barra de progreso (de 0% a 100% en 2 segundos)
        progressBar.style.width = '0%';
        setTimeout(() => { 
            progressBar.style.width = '100%'; 
        }, 100);  // Inicia la animación en 100ms para que se vea el cambio

        // Ocultar la pantalla de carga después de 2 segundos (la duración de la animación de la barra de progreso)
        setTimeout(() => {
            loadingScreen.classList.add('opacity-0');
            setTimeout(() => {
                loadingScreen.style.display = 'none';
                content.classList.remove('hidden');
            }, 500); // Este 500 es el tiempo para que la transición de opacidad ocurra antes de ocultar
        }, 2000); // Pantalla de carga se oculta después de 2 segundos
    });
    
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar Select2 para el filtro de equipos
        $('#equipoFilter').select2({
            templateResult: formatOptionWithLogo,
            templateSelection: formatOptionWithLogo,
            width: '100%',
            placeholder: "Todos los equipos", // Este texto debe coincidir con el <option>
            allowClear: true,
            minimumResultsForSearch: Infinity
        });
        $('#equipoFilter').val('').trigger('change');


        // Función para mostrar logos en las opciones
        function formatOptionWithLogo(option) {
            if (!option.id) return option.text;
            
            const $option = $(
                `<span class="flex items-center gap-2">
                    ${option.element.dataset.logo ? `<img src="${option.element.dataset.logo}" class="w-5 h-5 object-contain" />` : ''}
                    ${option.text}
                </span>`
            );
            
            return $option;
        }

        // Elementos del DOM
        const nombreFilter = document.getElementById('nombreFilter');
        const posicionFilter = document.getElementById('posicionFilter');
        const equipoFilter = document.getElementById('equipoFilter');
        const ordenFilter = document.getElementById('ordenFilter');
        const jugadoresContainer = document.getElementById('jugadoresContainer');
        const jugadorCards = document.querySelectorAll('.jugador-card');
        
        // Función para normalizar textos (eliminar acentos y convertir a minúsculas)
        function normalizarTexto(texto) {
            return texto.toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .trim();
        }
        
        // Función para aplicar todos los filtros
        function aplicarFiltros() {
            const nombreValue = normalizarTexto(nombreFilter.value);
            const posicionValue = posicionFilter.value;
            const equipoValue = $('#equipoFilter').val(); // Usamos jQuery para obtener el valor de Select2
            
            jugadorCards.forEach(card => {
                const nombre = normalizarTexto(card.dataset.nombre);
                const posicion = card.dataset.posicion;
                const equipo = card.dataset.equipo;
                
                // Aplicar filtros combinados
                const nombreMatch = nombre.includes(nombreValue) || nombreValue === "";
                const posicionMatch = posicionValue === "" || posicion === posicionValue;
                const equipoMatch = equipoValue === null || equipoValue === "" || equipo === equipoValue;
                
                if (nombreMatch && posicionMatch && equipoMatch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            
            ordenarJugadores();
        }
        
        // Función para ordenar jugadores
        function ordenarJugadores() {
            const order = ordenFilter.value;
            const visibleCards = Array.from(document.querySelectorAll('.jugador-card[style="display: block;"], .jugador-card:not([style])'));
            
            visibleCards.sort((a, b) => {
                if (order === 'puntos_desc') {
                    return b.dataset.puntos - a.dataset.puntos;
                } else if (order === 'puntos_asc') {
                    return a.dataset.puntos - b.dataset.puntos;
                } else if (order === 'nombre_asc') {
                    return normalizarTexto(a.dataset.nombre).localeCompare(normalizarTexto(b.dataset.nombre));
                } else if (order === 'nombre_desc') {
                    return normalizarTexto(b.dataset.nombre).localeCompare(normalizarTexto(a.dataset.nombre));
                }
                return 0;
            });
            
            // Reorganizar las tarjetas en el contenedor
            visibleCards.forEach(card => {
                jugadoresContainer.appendChild(card);
            });
        }
        
        // Event listeners
        nombreFilter.addEventListener('input', aplicarFiltros);
        posicionFilter.addEventListener('change', aplicarFiltros);
        $('#equipoFilter').on('change', aplicarFiltros); // Usamos jQuery para el evento change de Select2
        ordenFilter.addEventListener('change', ordenarJugadores);
        
        // Aplicar filtros iniciales
        aplicarFiltros();
    });
     function mostrarEstadisticasJugador(jugadorId) {
        // Aquí deberías hacer una petición AJAX para obtener las estadísticas del jugador
        // Pero como ya tienes los datos en la vista, podemos usar esos
        
        // Encuentra el jugador en la lista
        const jugador = {!! json_encode($jugadores->keyBy('id')) !!}[jugadorId];
        
        if (!jugador) return;
        
        // Configurar la información básica
        document.getElementById('modalJugadorImagen').src = jugador.imagen_url;
        document.getElementById('modalJugadorNombre').textContent = jugador.nombre;
        
        const equipoLogo = {!! json_encode($logosEquipos) !!}[jugador.equipo_real];
        const equipoHtml = equipoLogo 
            ? `<img src="${equipoLogo}" class="w-4 h-4 mr-1">${jugador.equipo_real}`
            : jugador.equipo_real;
        document.getElementById('modalJugadorEquipo').innerHTML = equipoHtml;
        
        document.getElementById('modalJugadorPosicion').textContent = jugador.posicion;
        document.getElementById('modalJugadorPuntos').textContent = jugador.puntos;
        
        const valor = jugador.valor; 
        const valorFormateado = valor.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + " €";

        document.getElementById('modalJugadorValor').textContent = valorFormateado;

   
        // Calcular KDA
        const kills = jugador.estadisticas?.kills || 0;
        const asistencias = jugador.estadisticas?.asistencias || 0;
        const muertes = jugador.estadisticas?.muertes || 1; // Evitar división por cero
        const kda = ((kills + asistencias) / muertes).toFixed(2);
        
        document.getElementById('modalJugadorKDA').textContent = kda;
        document.getElementById('modalJugadorKillsMuertesAsistencias').textContent = 
            `${kills} / ${muertes} / ${asistencias}`;
        
        // Configurar estadísticas de combate
        if (jugador.estadisticas) {
            document.getElementById('estadDanioCampeones').textContent = jugador.estadisticas.danio_campeones;
            document.getElementById('estadDanioRecibido').textContent = jugador.estadisticas.danio_recibido;
            document.getElementById('estadTiempoMuerto').textContent = jugador.estadisticas.tiempo_muerto;
            document.getElementById('estadSoloKills').textContent = jugador.estadisticas.solo_kills;
            document.getElementById('estadDoubleKills').textContent = jugador.estadisticas.double_kills;
            document.getElementById('estadTripleKills').textContent = jugador.estadisticas.triple_kills;
            document.getElementById('estadQuadraKills').textContent = jugador.estadisticas.quadra_kills;
            document.getElementById('estadPentaKills').textContent = jugador.estadisticas.penta_kills;
            document.getElementById('estadPuntosVision').textContent = jugador.estadisticas.puntos_vision;
            document.getElementById('estadObjetivoRobado').textContent = jugador.estadisticas.objetivo_robado;
            document.getElementById('estadDanioTorres').textContent = jugador.estadisticas.danio_torres;
            document.getElementById('estadPrimeraSangre').textContent = jugador.estadisticas.primera_sangre ? 'Sí' : 'No';
            document.getElementById('estadPrimeraTorre').textContent = jugador.estadisticas.primera_torre ? 'Sí' : 'No';
            document.getElementById('estadOro').textContent = jugador.estadisticas.oro;
            document.getElementById('estadBotinConseguido').textContent = jugador.estadisticas.botin_conseguido;
            document.getElementById('estadBotinPerdido').textContent = jugador.estadisticas.botin_perdido;
        }
        
        // Mostrar el modal
        document.getElementById('estadisticasModal').classList.remove('hidden');
    }
    
    // Función para cerrar el modal
    function cerrarEstadisticasModal() {
        document.getElementById('estadisticasModal').classList.add('hidden');
    }
    
    // Función para cambiar entre tabs
    function cambiarTab(tab) {
        // Ocultar todos los contenidos de tabs
        document.querySelectorAll('.tab-contenido').forEach(content => {
            content.classList.add('hidden');
        });
        
        // Mostrar el contenido seleccionado
        document.getElementById(`contenido${tab.charAt(0).toUpperCase() + tab.slice(1)}`).classList.remove('hidden');
        
        // Actualizar estado de los tabs
        document.querySelectorAll('.tab-activo, .tab-inactivo').forEach(tabElement => {
            if (tabElement.id === `tab${tab.charAt(0).toUpperCase() + tab.slice(1)}`) {
                tabElement.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                tabElement.classList.add('border-blue-500', 'text-blue-600');
            } else {
                tabElement.classList.remove('border-blue-500', 'text-blue-600');
                tabElement.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            }
        });
    }
    

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.jugador-card button').forEach(button => {
            button.addEventListener('click', function() {
                const jugadorId = this.closest('.jugador-card').dataset.jugadorId;
                mostrarEstadisticasJugador(jugadorId);
            });
        });
    });
    </script>
    @endpush
    <style>
        .select2-container--default .select2-selection--single {
    background-color: #ffffff !important;
    color: #374151 !important;
    font-size: 1rem !important;
    padding: 0.75rem 1rem !important;
    border-radius: 0.75rem !important;
    border: 2px solid #bfdbfe !important;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
    transition: all 0.3s ease !important;
    min-height: 3.25rem !important;
}

.select2-selection__rendered {
    line-height: 1.5 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 50% !important;
    transform: translateY(-50%) !important;
    right: 1rem !important;
}

    </style>
    
</x-app-layout>