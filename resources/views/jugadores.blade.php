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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="jugadoresContainer">
                @foreach($jugadores as $jugador)
                    <div class="jugador-card bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-blue-200 hover:border-blue-400 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1"
                        data-nombre="{{ strtolower($jugador->nombre) }}"
                        data-posicion="{{ $jugador->posicion }}"
                        data-equipo="{{ $jugador->equipo_real }}"
                        data-puntos="{{ $jugador->valor }}">
                        
                        <!-- Encabezado con equipo y posición -->
                        <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 border-b-2 border-blue-200">
                            <span class="flex items-center gap-2 text-sm font-bold text-blue-700">
                                @if(isset($logosEquipos[$jugador->equipo_real]))
                                    <img src="{{ $logosEquipos[$jugador->equipo_real] }}" alt="{{ $jugador->equipo_real }}" class="w-5 h-5 object-contain">
                                @endif
                                {{ $jugador->equipo_real }}
                            </span>

                            <span class="inline-flex items-center px-4 py-1 text-xs font-bold rounded-full shadow
                                @if($jugador->posicion == 'Top') bg-red-100 text-red-800 border border-red-300
                                @elseif($jugador->posicion == 'Jungla') bg-green-100 text-green-800 border border-green-300
                                @elseif($jugador->posicion == 'Mid') bg-yellow-100 text-yellow-800 border border-yellow-300
                                @elseif($jugador->posicion == 'ADC') bg-blue-100 text-blue-800 border border-blue-300
                                @else bg-purple-100 text-purple-800 border border-purple-300
                                @endif">
                                
                                {{-- Imagen según posición --}}
                                <img src="@switch($jugador->posicion)
                                    @case('Top') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117549/topLogo_rsvrc0.png @break
                                    @case('Jungla') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117550/jngLogo_azrjmn.webp @break
                                    @case('Mid') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/midLogo_kn7okb.png @break
                                    @case('Adc') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/adcLogo_idgdnc.png @break
                                    @default https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/supportLogo_gcrpbi.png
                                @endswitch"
                                alt="{{ $jugador->posicion }} icon"
                                class="w-4 h-4 mr-2">

                                {{ $jugador->posicion }}
                            </span>
                        </div>
                        
                        <!-- Imagen circular del jugador -->
                        <div class="flex justify-center mt-6">
                            <div class="relative">
                                <div class="absolute inset-0 rounded-full bg-gradient-to-br from-blue-300 to-purple-300 blur-md opacity-30 -z-10"></div>
                                <img src="{{ $jugador->imagen_url ?? 'https://via.placeholder.com/150' }}" alt="{{ $jugador->nombre }}" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg">
                            </div>
                        </div>
                        
                        <!-- Nombre del jugador -->
                        <div class="text-center mt-4 px-4">
                            <h3 class="text-xl font-bold text-gray-800">{{ $jugador->nombre }}</h3>
                        </div>
                        
                        <!-- Estadísticas (KDA y Puntos) -->
                        <div class="grid grid-cols-2 gap-4 p-4 mt-2">
                            <!-- KDA -->
                            <div class="bg-blue-50 rounded-xl p-3 text-center border-2 border-blue-100 shadow-inner">
                                <p class="text-xs font-semibold text-blue-600 uppercase">KDA</p>
                                <p class="text-lg font-bold text-gray-800 mt-1">
                                    {{ rand(3, 7) }}.{{ rand(0, 9) }}/{{ rand(1, 2) }}.{{ rand(0, 9) }}/{{ rand(5, 7) }}.{{ rand(0, 9) }}
                                </p>
                            </div>
                            
                            <!-- Puntos -->
                            <div class="bg-yellow-50 rounded-xl p-3 text-center border-2 border-yellow-100 shadow-inner">
                                <p class="text-xs font-semibold text-yellow-600 uppercase">PUNTOS</p>
                                <p class="text-lg font-bold text-yellow-700 mt-1">{{ $jugador->valor }}</p>
                            </div>
                        </div>
                        
                        <!-- Botón de ver estadísticas -->
                        <div class="px-4 pb-4">
                            <button class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-2 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-[1.02]">
                                VER ESTADÍSTICAS
                            </button>
                        </div>
                    </div>
                @endforeach
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