
<x-app-layout>
    @section('content')
    <div id="loading-screen" class="fixed inset-0 z-1000 flex items-center justify-center bg-gray-900 transition-opacity duration-5000">
        <div class="text-center">
            <div class="mb-6 text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-600">
                LEC FANTASY
            </div>

            <div class="relative w-20 h-20 mx-auto mb-6">
                <div class="absolute inset-0 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
                <div class="absolute inset-2 border-4 border-purple-600 border-b-transparent rounded-full animate-spin animation-delay-200"></div>
            </div>

            <!-- Texto cargando con efecto -->
            <div class="text-xl font-semibold text-white">
                <span class="animate-pulse">@lang('messages.cargando')</span>
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
            <h2 class="text-2xl font-bold text-gray-800 bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-500 dark:to-purple-500 bg-clip-text text-transparent">
                 @lang('messages.buscador')
            </h2>
            <div class="relative w-full md:w-1/3">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-blue-500 dark:text-blue-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
                <input type="text" id="nombreFilter" class="block w-full p-3 pl-10 text-base text-gray-800 dark:text-gray-200 border-2 border-blue-200 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-500 shadow-sm transition-all " placeholder="{{ __('messages.buscar_jugador_nombre') }}" autocomplete="off">
            </div>
        </div>
    </x-slot>

    <div class="py-6 px-4 bg-gradient-to-b from-blue-50 dark:from-gray-900 to-white dark:to-gray-800 min-h-screen">
        <!-- Filtros -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg dark:shadow-gray-900/50 mb-8 p-6 border-2 border-blue-100 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Filtro por posición -->
                <div>
                    <label for="posicionFilter" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">@lang('messages.posicion')</label>
                    <select id="posicionFilter" class="bg-white dark:bg-gray-700 border-2 border-blue-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-base rounded-xl focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-500 block w-full p-3 shadow-sm transition-all ">
                        <option value="">@lang('messages.todas_posiciones')</option>
                        <option value="Top">Top</option>
                        <option value="Jungla">Jungla</option>
                        <option value="Mid">Mid</option>
                        <option value="Adc">ADC</option>
                        <option value="Support">Support</option>
                    </select>
                </div>

                <!-- Filtro por equipo -->
                <div>
                    <label for="equipoFilter" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">@lang('messages.equipo')</label>
                    <select id="equipoFilter" data-placeholder="{{ __('messages.todos_equipos') }}"  class="bg-white dark:bg-gray-700 border-2 border-blue-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-base rounded-xl focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-500 block w-full p-3 shadow-sm transition-all ">
                        <option value="">@lang('messages.todos_equipos')</option>
                        @foreach($equipos as $equipo)
                            <option value="{{ $equipo }}" data-logo="{{ $logosEquipos[$equipo] ?? '' }}">
                                {{ $equipo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Ordenar por -->
                <div>
                    <label for="ordenFilter" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300 uppercase">@lang('messages.ordenador_por')</label>
                    <select id="ordenFilter" class="bg-white dark:bg-gray-700 border-2 border-blue-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 text-base rounded-xl focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-500 block w-full p-3 shadow-sm transition-all ">
                        <option value="puntos_desc">@lang('messages.mayor_menor')</option>
                        <option value="puntos_asc">@lang('messages.menor_mayor')</option>                            
                        <option value="nombre_asc">@lang('messages.nombre_az')</option>
                        <option value="nombre_desc">@lang('messages.nombre_za')</option>
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
                
                // Colores según equipo
                $teamColors = [
                    'Team Heretics'      => 'bg-gradient-to-r from-black to-white text-black dark:text-white',        
                    'Fnatic'        => 'bg-orange-500 text-white',                               
                    'G2'            => 'bg-gradient-to-r from-black to-red-600 text-white',      
                    'Karmine Corp'  => 'bg-gradient-to-r from-teal-400 to-cyan-500 text-white',   
                    'Movistar KOI'  => 'bg-gradient-to-r from-purple-600 to-white text-black dark:text-white',                                
                    'Team Vitality' => 'bg-yellow-200 text-black dark:text-gray-900',                               
                    'SK'            => 'bg-gradient-to-r from-pink-400 to-purple-300 text-white',
                    'GiantX'        => 'bg-gradient-to-r from-blue-700 to-black text-white',     
                    'Rogue'         => 'bg-gradient-to-r from-blue-400 to-yellow-400 text-black dark:text-gray-900',
                    'BDS'           => 'bg-pink-400 text-white',                    
                ];

                $teamBg = $teamColors[$jugador->equipo_real] ?? 'bg-gray-500 text-black dark:text-white';
                
            @endphp

            <div class="jugador-card group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg dark:shadow-gray-900/50 hover:shadow-xl dark:hover:shadow-gray-900/70 transition-all  transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-500 relative"
                data-nombre="{{ strtolower($jugador->nombre) }}"
                data-posicion="{{ $jugador->posicion }}"
                data-equipo="{{ $jugador->equipo_real }}"
                data-puntos="{{ $jugador->puntos }}"
                data-jugador-id="{{ $jugador->id }}">
                
                <!-- Banda superior con posición -->
                <div class="absolute top-0 left-0 w-full h-2 {{$teamBg}}"></div>
                
                <!-- Encabezado con equipo -->
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800">
                    <div class="flex items-center space-x-2">
                        @if(isset($logosEquipos[$jugador->equipo_real]))
                        <img src="{{ $logosEquipos[$jugador->equipo_real] }}" alt="{{ $jugador->equipo_real }}" 
                            class="w-6 h-6 object-contain rounded-full border border-gray-200 dark:border-gray-200 bg-white dark:bg-gray-400 p-0.5">
                        @endif
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300 truncate max-w-[120px]">{{ $jugador->equipo_real }}</span>
                    </div>
                    
                    <!-- Badge de posición -->
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm
                        @if($jugador->posicion == 'Top') bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200
                        @elseif($jugador->posicion == 'Jungla') bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200
                        @elseif($jugador->posicion == 'Mid') bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-200
                        @elseif($jugador->posicion == 'ADC') bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200
                        @else bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-200
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
                    <div class="relative group-hover:scale-105 transition-transform ">
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 opacity-20 blur-md -z-10 group-hover:opacity-30 transition-opacity "></div>
                        <img src="{{ $jugador->imagen_url ?? 'https://via.placeholder.com/150' }}" 
                            alt="{{ $jugador->nombre }}" 
                            class="w-32 h-32 rounded-full object-cover border-4 border-white dark:border-gray-800 shadow-md">
                        <!-- Efecto hover sobre la imagen -->
                        <div class="absolute inset-0 rounded-full bg-gradient-to-t from-gray-900/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity  flex items-end justify-center pb-4">
                            <span class="text-white font-bold text-sm bg-black/50 px-2 py-1 rounded-full cursor-pointer" onclick="mostrarEstadisticasJugador({{ $jugador->id }})">
                                 @lang('messages.ver_detalles')
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Nombre del jugador -->
                <div class="text-center mt-4 px-4">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors ">
                        {{ $jugador->nombre }}
                    </h3>
                </div>
                
                <!-- Estadísticas principales -->
                <div class="grid grid-cols-2 gap-3 p-4 mt-2">
                    <!-- KDA -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/40 rounded-xl p-3 text-center border border-blue-200 dark:border-blue-800 shadow-sm group-hover:shadow-md dark:group-hover:shadow-blue-900/50 transition-shadow ">
                        <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">KDA RATIO</p>
                        <p class="text-xl font-bold text-gray-800 dark:text-gray-200 mt-1 flex items-center justify-center">
                            {{ $kda }}

                            @if($kda > 5)
                                <span class="ml-1 text-xs bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 px-1.5 py-0.5 rounded-full">@lang('messages.top')</span>
                            @elseif($kda >= 3 && $kda <= 5)
                                <span class="ml-1 text-xs bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200 px-1.5 py-0.5 rounded-full">@lang('messages.bueno')</span>
                            @elseif($kda >= 2 && $kda < 3)
                                <span class="ml-1 text-xs bg-orange-100 dark:bg-orange-900/50 text-orange-800 dark:text-orange-200 px-1.5 py-0.5 rounded-full">@lang('messages.normal')</span>
                            @else
                                <span class="ml-1 text-xs bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200 px-1.5 py-0.5 rounded-full">@lang('messages.malo')</span>
                            @endif

                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $kills }}/{{ $muertes }}/{{ $asistencias }}</p>
                    </div>
                    
                    <!-- Puntos -->
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/30 dark:to-yellow-800/40 rounded-xl p-3 text-center border border-yellow-200 dark:border-yellow-800 shadow-sm group-hover:shadow-md dark:group-hover:shadow-yellow-900/50 transition-shadow ">
                        <p class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 uppercase tracking-wider">@lang('messages.puntos')</p>
                        <p class="text-xl font-bold text-yellow-700 dark:text-yellow-300 mt-1 flex items-center justify-center">
                            {{ $jugador->puntos }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 text-yellow-500 dark:text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1"> @lang('messages.total_fantasy')</p>
                    </div>
                </div>
                
                <!-- Botón de ver estadísticas -->
                <div class="px-4 pb-4">
                    <button class="w-full flex items-center justify-center space-x-2 bg-gradient-to-r from-blue-500 to-purple-600 dark:from-blue-600 dark:to-purple-700 hover:from-blue-600 hover:to-purple-700 dark:hover:from-blue-700 dark:hover:to-purple-800 text-white font-medium py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition-all  transform group-hover:scale-[1.02]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span> @lang('messages.ver_estadisticas')</span>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div id="estadisticasModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Fondo del modal - ahora con onclick -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" onclick="cerrarEstadisticasModal()">
                <div class="absolute inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm"></div>
            </div>
            
            <!-- Contenido del modal - evita que el click se propague -->
            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl w-full" onclick="event.stopPropagation()">
                    <!-- Header con gradiente -->
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-700 dark:to-purple-700 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <img id="modalJugadorImagen" src="" alt="" class="w-24 h-24 rounded-full border-4 border-white dark:border-gray-800 shadow-lg mr-6 object-cover">

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
                    <div class="bg-white dark:bg-gray-800 px-6 py-4 max-h-[70vh] overflow-y-auto">
                        <!-- Puntos y KDA destacados -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 border-2 border-blue-100 dark:border-blue-800">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase"> @lang('messages.puntos_totales')</p>
                                        <p id="modalJugadorPuntos" class="text-2xl font-bold text-gray-800 dark:text-gray-200 mt-1">0</p>
                                    </div>
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 dark:bg-green-900/30 rounded-xl p-4 border-2 border-green-100 dark:border-green-800">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase">KDA Ratio</p>
                                        <p id="modalJugadorKDA" class="text-2xl font-bold text-gray-800 dark:text-gray-200 mt-1">0.00</p>
                                        <p id="modalJugadorKillsMuertesAsistencias" class="text-xs text-gray-500 dark:text-gray-400 mt-1">0 / 0 / 0</p>
                                    </div>
                                    <div class="w-12 h-12 rounded-full bg-green-100 dark:bg-green-900/50 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Estadísticas detalladas en tabs -->
                        <div class="mb-6">
                            <div class="border-b border-gray-200 dark:border-gray-700">
                                <nav class="-mb-px flex space-x-8">
                                    <button onclick="cambiarTab('combate')" id="tabCombate" class="tab-activo whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-blue-500 dark:border-blue-400 text-blue-600 dark:text-blue-400">
                                         @lang('messages.combate')
                                    </button>
                                    <button onclick="cambiarTab('objetivos')" id="tabObjetivos" class="tab-inactivo whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                                         @lang('messages.objectivos')
                                    </button>
                                    <button onclick="cambiarTab('economia')" id="tabEconomia" class="tab-inactivo whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600">
                                         @lang('messages.economia')
                                    </button>
                                </nav>
                            </div>
                        </div>
                        
                        <!-- Contenido de los tabs -->
                        <div id="contenidoCombate" class="tab-contenido grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Estadísticas de combate -->
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                     @lang('messages.estadisticas_combate')
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.dano_a_campeones')</span>
                                        <span id="estadDanioCampeones" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.dano_recibido')</span>
                                        <span id="estadDanioRecibido" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.tiempo_muerto') /s</span>
                                        <span id="estadTiempoMuerto" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Multikills
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Solo kills</span>
                                        <span id="estadSoloKills" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Double kills</span>
                                        <span id="estadDoubleKills" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Triple kills</span>
                                        <span id="estadTripleKills" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Quadra kills</span>
                                        <span id="estadQuadraKills" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Penta kills</span>
                                        <span id="estadPentaKills" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="contenidoObjetivos" class="tab-contenido hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Estadísticas de objetivos -->
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                    </svg>
                                    @lang('messages.objectivos')
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.puntos_de_vision')</span>
                                        <span id="estadPuntosVision" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.objectivos_robados')</span>
                                        <span id="estadObjetivoRobado" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.dano_a_torres')</span>
                                        <span id="estadDanioTorres" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.primera_sangre')</span>
                                        <span id="estadPrimeraSangre" class="text-sm font-medium text-gray-800 dark:text-gray-200">No</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.primera_torre')</span>
                                        <span id="estadPrimeraTorre" class="text-sm font-medium text-gray-800 dark:text-gray-200">No</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="contenidoEconomia" class="tab-contenido hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Estadísticas de economía -->
                            <div class="bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                                <h4 class="font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @lang('messages.economia')
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.oro_total')</span>
                                        <span id="estadOro" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.botin_conseguido')</span>
                                        <span id="estadBotinConseguido" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">@lang('messages.botin_perdido')</span>
                                        <span id="estadBotinPerdido" class="text-sm font-medium text-gray-800 dark:text-gray-200">0</span>
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
       /* === MODO CLARO === */
        .select2-container--default .select2-selection--single {
            background-color: #ffffff !important;
        
            font-size: 1rem !important;
            padding: 0.75rem 1rem !important;
            border-radius: 0.75rem !important;
            border: 2px solid #bfdbfe !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
            transition: all 0.3s ease !important;
            min-height: 3.25rem !important;
            height: auto !important;
        }

        .select2-container--default .select2-selection--single:focus {
            outline: none !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0 !important;

            line-height: 1.5 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50% !important;
            transform: translateY(-50%) !important;
            right: 1rem !important;
            height: 100% !important;
        }

        .select2-results__option {
            padding: 8px 12px !important;
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            background-color: #ffffff !important;
            
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6 !important;
            color: #ffffff !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #eef2ff !important;
            color: #1e40af !important;
        }

        /* === MODO OSCURO === */
        .dark .select2-container--default .select2-selection--single {
            background-color: #374151 !important;
            
            border: 2px solid #4b5563 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.4) !important;
        }

        .dark .select2-container--default .select2-selection--single:focus {
            border-color: #60a5fa !important;
            box-shadow: 0 0 0 2px rgba(147, 197, 253, 0.5) !important;
        }

        .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #e5e7eb !important; /* text-gray-200 */
        }

        .dark .select2-results__option {
            background-color: #1f2937 !important;
            color: #e5e7eb !important; /* text-gray-200 */
        }

        .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }

        .dark .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #111827 !important;
            color: #93c5fd !important;
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
            placeholder: "Todos los equipos", 
            allowClear: true,
            minimumResultsForSearch: Infinity
        });
        $('#equipoFilter').val('').trigger('change');


        // Función para mostrar logos en las opciones
        function formatOptionWithLogo(option) {
            if (!option.id) return option.text;
            
            const $option = $(
                `<span class="flex items-center gap-2 ">
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
</x-app-layout>