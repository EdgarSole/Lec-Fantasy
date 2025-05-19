<x-app-layout>
    <x-slot name="header">
        <div class="text-center mb-10 px-4 sm:px-0">
            <h2 class="text-3xl font-extrabold text-gray-800 inline-flex items-center">
                <span class="inline-block animate-bounce mr-3 text-amber-600">🏆</span>
                MIS LIGAS
                <span class="inline-block animate-bounce ml-3 text-gray-700 delay-100">⚔️</span>
            </h2>
            <div class="mt-3 h-1 bg-gradient-to-r from-transparent via-cyan-400 to-transparent rounded-full opacity-70 max-w-md mx-auto"></div>
        </div>
        @if(session('success'))
            <div class="mt-4 mb-6 p-4 rounded-lg border-2 border-green-400 bg-gradient-to-br from-green-900/80 to-green-800/90 text-green-100 shadow-lg shadow-green-500/20 relative overflow-hidden">
                <!-- Efecto de borde gaming -->
                <div class="absolute inset-0 border-2 border-green-300/30 rounded-lg pointer-events-none"></div>
                
                <!-- Icono y contenido -->
                <div class="flex items-start">
                    <div class="mr-3 text-green-400 animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-green-300 text-xl mb-1 font-mono tracking-wider">¡ENHORABUENA!</h4>
                        <p class="text-green-100 text-shadow font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mt-4 mb-6 p-4 rounded-lg border-2 border-red-400 bg-gradient-to-br from-red-900/80 to-red-800/90 text-red-100 shadow-lg shadow-red-500/20 relative overflow-hidden">
                <!-- Efecto de borde gaming -->
                <div class="absolute inset-0 border-2 border-red-300/30 rounded-lg pointer-events-none"></div>
                
                <!-- Icono y contenido -->
                <div class="flex items-start">
                    <div class="mr-3 text-red-400 animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-red-300 text-xl mb-1 font-mono tracking-wider">ERROR DETECTADO</h4>
                        <ul class="text-red-100 text-shadow space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="flex items-start">
                                    <span class="text-red-400 mr-2">■</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                
                <div class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-red-400"></div>
                <div class="absolute top-0 right-0 w-3 h-3 border-t-2 border-r-2 border-red-400"></div>
                <div class="absolute bottom-0 left-0 w-3 h-3 border-b-2 border-l-2 border-red-400"></div>
                <div class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-red-400"></div>
            </div>
        @endif

    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="flex flex-wrap gap-5 mb-12 justify-center">
                <button type="button" onclick="document.getElementById('create-league-modal').classList.remove('hidden')" class="px-8 py-3.5 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl font-bold text-white hover:from-blue-600 hover:to-cyan-600 transition-all duration-200 transform hover:scale-[1.03] shadow-lg shadow-cyan-300/40 border-b-2 border-cyan-600/70 active:scale-95">
                    🏆 CREAR LIGA 
                </button>
                <button 
                    x-data
                    @click="$dispatch('open-join-modal')" 
                    class="px-8 py-3.5 bg-gradient-to-r from-green-400 to-emerald-500 rounded-xl font-bold text-white hover:from-green-500 hover:to-emerald-600 transition-all duration-200 transform hover:scale-[1.03] shadow-lg shadow-emerald-300/40 border-b-2 border-emerald-600/70 active:scale-95">
                    🎮 UNIRSE A LIGA
                </button>
            </div>

            <!-- Modal para crear liga -->
            <div id="create-league-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
                <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-5 text-white">
                        <h3 class="text-xl font-bold text-center">CREAR NUEVA LIGA</h3>
                    </div>
                    
                    <form class="p-6" method="POST"  action="{{ route('ligas.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Nombre -->
                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700 font-medium mb-2">Nombre de la Liga</label>
                            <input type="text" id="nombre" name="nombre" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        </div>
                        
                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="descripcion" class="block text-gray-700 font-medium mb-2">Descripción</label>
                            <textarea id="descripcion" name="descripcion" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"></textarea>
                        </div>
                        
                        <!-- Tipo de liga (select) -->
                        <div class="mb-4">
                            <label for="tipo" class="block text-gray-700 font-medium mb-2">Tipo de Liga</label>
                            <select id="tipo" name="tipo" onchange="passwordPrivada(this)" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                <option value="publica">Pública</option>
                                <option value="privada">Privada</option>
                            </select>
                        </div>
                        
                        <!-- Contraseña (solo para privada) - inicialmente oculto -->
                        <div id="password-field" class="mb-4 hidden">
                            <label for="contrasena" class="block text-gray-700 font-medium mb-2">Contraseña</label>
                            <input type="password" id="contrasena" name="contrasena" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                            <p class="text-sm text-gray-500 mt-1">Solo los jugadores con esta contraseña podrán unirse</p>
                        </div>
                        
                        <!-- Logo de la liga -->
                        <div class="mb-6">
                            <label for="logo_url" class="block text-gray-700 font-medium mb-2">Logo de la Liga</label>
                            <input type="file" id="logo_url" name="logo_url" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        
                        <!-- Botones -->
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="document.getElementById('create-league-modal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                                Cancelar
                            </button>
                            <button type="submit" class="px-5 py-2.5 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600 transition">
                                Crear Liga
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal para unirse a una liga - Buscar Liga -->
            <div x-data="joinLeagueModal()" 
                x-show="showJoinModal" 
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4"
                style="display: none;"
                @open-join-modal.window="showJoinModal = true; searchLeagues()"
                @keydown.escape="showJoinModal = false">
                
                <!-- Modal principal de búsqueda -->
                <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-200"
                    @click.away="showJoinModal = false"
                    x-show="!showConfirmModal"
                    x-transition>
                    
                    <!-- Header limpio -->
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-5 ">
                        <h3 class="text-xl font-bold text-white text-center">Unirse a Liga</h3>
                        <button @click="showJoinModal = false" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Contenido -->
                    <div class="p-5">
                        <!-- Buscador elegante -->
                        <div class="relative mb-5">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input 
                                x-model="searchTerm" 
                                @input.debounce.300ms="searchLeagues()"
                                type="text" 
                                placeholder="Buscar ligas por nombre..." 
                                class="w-full pl-10 pr-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            >
                            <div x-show="isLoading" class="absolute right-3 top-3.5">
                                <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Resultados con scroll -->
                        <div class="max-h-[300px] overflow-y-auto pr-2 custom-scrollbar-light" x-ref="resultsContainer">
                            <template x-if="leagues.length === 0 && !isLoading">
                                <div class="text-center py-6">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h4 class="mt-2 text-gray-500 font-medium">No se encontraron ligas</h4>
                                    <p class="mt-1 text-gray-400 text-sm" x-text="searchTerm.length >= 2 ? 'Prueba con otro nombre' : 'Empieza a escribir para buscar'"></p>
                                </div>
                            </template>
                            
                            <template x-for="(league, index) in leagues" :key="league.id">
                                <div 
                                    @click="selectLeague(league)"
                                    class="flex items-center p-3 mb-2 rounded-lg cursor-pointer transition-all hover:bg-blue-50 hover:translate-x-1 border border-gray-200 hover:border-blue-300"
                                    x-intersect.once="$el.scrollIntoView({ behavior: 'smooth', block: 'nearest' })"
                                >
                                    <div class="relative">
                                        <img 
                                            :src="league.logo_url || 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1746528986/fotoliga_predeterminada.webp'" 
                                            alt="Logo liga" 
                                            class="w-12 h-12 rounded-full object-cover border-2 border-gray-200"
                                        >
                                        
                                    </div>
                                    <div class="ml-4 flex-1 min-w-0">
                                        <h4 class="font-medium text-gray-800 truncate" x-text="league.nombre"></h4>
                                        <div class="flex items-center mt-1">
                                            <span class="text-xs px-2 py-0.5 rounded-full"
                                                :class="{
                                                    'bg-purple-100 text-purple-800 border border-purple-200': league.tipo === 'privada',
                                                    'bg-blue-100 text-blue-800 border border-blue-200': league.tipo === 'publica'
                                                }"
                                                x-text="league.tipo === 'privada' ? 'Privada' : 'Pública'">
                                            </span>
                                            <span class="ml-2 text-xs text-gray-500" x-text="`${league.usuarios_count} miembros`"></span>
                                        </div>
                                    </div>
                                    <svg class="h-5 w-5 text-gray-400 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                            </template>
                        </div>
                        
                        <!-- Contador de resultados -->
                        <div class="text-right mt-3 text-xs text-gray-500" 
                            x-text="leagues.length > 0 ? `Mostrando ${leagues.length} ligas` : ''"
                            x-show="leagues.length > 0">
                        </div>
                    </div>
                </div>
                
                <!-- Modal de confirmación -->
                <div 
                    x-show="showConfirmModal" 
                    class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-200"
                    @click.away="showConfirmModal = false"
                >
                    <div class="bg-white p-5 border-b border-gray-200 relative">
                        <h3 class="text-xl font-bold text-gray-800 text-center">Confirmar Unión</h3>
                        <button @click="showConfirmModal = false" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="relative">
                                <img 
                                    :src="selectedLeague?.logo_url || 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1746528986/fotoliga_predeterminada.webp'" 
                                    alt="Logo liga" 
                                    class="w-16 h-16 rounded-full object-cover border-2 border-gray-200"
                                >
                                <span class="absolute -bottom-1 -right-1 bg-blue-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center shadow-md">
                                    <span x-text="selectedLeague?.usuarios_count || 0" class="text-xs"></span>
                                </span>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-bold text-lg text-gray-800" x-text="selectedLeague?.nombre"></h4>
                                <span class="text-xs px-2 py-0.5 rounded-full mt-1 inline-block"
                                    :class="{
                                        'bg-purple-100 text-purple-800 border border-purple-200': selectedLeague?.tipo === 'privada',
                                        'bg-blue-100 text-blue-800 border border-blue-200': selectedLeague?.tipo === 'publica'
                                    }"
                                    x-text="selectedLeague?.tipo === 'privada' ? 'Liga Privada' : 'Liga Pública'">
                                </span>
                            </div>
                        </div>
                        
                        <template x-if="selectedLeague?.tipo === 'privada'">
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contraseña requerida</label>
                                <div class="relative">
                                    <input 
                                        x-model="password"
                                        type="password" 
                                        placeholder="Ingresa la contraseña de la liga" 
                                        class="w-full px-4 py-3 bg-white border border-gray-300 rounded-lg text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    >
                                    <div class="absolute right-3 top-3.5 text-gray-400">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <p x-show="error" class="mt-3 text-sm text-red-500 flex items-center" x-text="error">
                            <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </p>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button 
                                @click="showConfirmModal = false" 
                                class="px-5 py-2.5 bg-white text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-all border border-gray-300 hover:border-gray-400"
                            >
                                Cancelar
                            </button>
                            <button 
                                @click="joinLeague()" 
                                class="px-5 py-2.5 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600 transition-all shadow hover:shadow-md border border-blue-600 flex items-center"
                            >
                                <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                Unirse
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
            @isset($ligas)
            @forelse($ligas as $liga)
                @php
                    $equipoUsuario = $liga->equipos->where('usuario_id', auth()->id())->first();
                    $posicion = $equipoUsuario ? $equipoUsuario->posicion : '--';
                @endphp
                
                <div class="bg-[#fff7f0] rounded-2xl overflow-hidden border-2 border-cyan-300 hover:border-cyan-400 transition-all duration-300 shadow-lg shadow-cyan-100/50 relative group">

                        <!-- Efecto de brillo sutil al hover -->
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-100/20 to-blue-100/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Parte superior: Info de la Liga -->
                        <div class="p-6 relative z-10 border-b border-gray-100">
                            <div class="flex items-center mb-4">
                                <div class="relative">
                                    <img src="{{ $liga->logo_url }}" alt="Logo Liga" class="w-16 h-16 rounded-full border-2 border-cyan-400 object-cover shadow-md">
                                    
                                    <!-- Mostrar medalla según la posición -->
                                    @if($posicion == 1)
                                        <div class="absolute -bottom-1 -right-1 bg-amber-400 text-xs font-bold rounded-full w-7 h-7 flex items-center justify-center shadow-sm border border-amber-300">
                                            🥇
                                        </div>
                                    @elseif($posicion == 2)
                                        <div class="absolute -bottom-1 -right-1 bg-gray-400 text-xs font-bold rounded-full w-7 h-7 flex items-center justify-center shadow-sm border border-silver-300">
                                            🥈
                                        </div>
                                    @elseif($posicion == 3)
                                        <div class="absolute -bottom-1 -right-1 bg-orange-400 text-xs font-bold rounded-full w-7 h-7 flex items-center justify-center shadow-sm border border-bronze-300">
                                            🥉
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-5">
                                    <h3 class="font-bold text-xl text-gray-800">{{ strtoupper($liga->nombre) }}</h3>
                                    <p class="text-cyan-600 flex items-center text-sm mt-1">
                                        <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                        {{ $liga->usuario_id == auth()->id() ? 'Líder' : 'Miembro' }}
                                    </p>
                                </div>
                            </div>

                            
                            <!-- Mini descripción -->
                            <p class="text-gray-600 text-sm mt-3 line-clamp-2">
                                {{ $liga->descripcion ?? 'Sin descripción' }}
                            </p>
                        </div>
                        
                        <!-- Parte media: Separador visual -->
                        <div class="bg-gradient-to-r from-transparent via-cyan-300 to-transparent h-px w-full"></div>
                        
                        <!-- Parte inferior: Puntuación y acciones -->
                        <div class="p-6 relative z-10">
                            <!-- Sección de Puntuación - Estilo Gaming Claro -->
                            <div class="bg-[#fffaf5] p-4 rounded-lg mb-4 border border-gray-200 shadow-inner">
                                <h4 class="text-xs font-mono text-cyan-600 mb-3 tracking-wider">ESTADÍSTICAS</h4>
                                
                                <!-- Barra de progreso con posición real -->
                                <div class="mb-3">
                                    @php
                                    $totalMiembros = $liga->miembros_count;
                                    @endphp
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-xs font-medium text-gray-600">TU POSICIÓN</span>
                                        <span class="text-amber-600 font-bold text-sm">{{ $posicion }}/{{ $totalMiembros }}</span>
                                    </div>
                                    @php
                                        $posicionNumerica = is_numeric($posicion) ? (int) $posicion : null;
                                        $porcentajePosicion = $totalMiembros > 1
                                        ? ((($totalMiembros - $posicion) / ($totalMiembros - 1)) * 100)
                                        : 100;

                                    @endphp

                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-gradient-to-r from-amber-400 to-amber-500 h-2.5 rounded-full"
                                            style="width: {{ $porcentajePosicion }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Mini estadísticas con datos reales -->
                                <div class="grid grid-cols-3 gap-2 text-center">
                                    <div class="bg-[#fffaf5] p-2 rounded border border-gray-100 shadow-sm">
                                        <p class="text-cyan-600 text-xs">PUNTOS</p>
                                        <p class="text-gray-800 font-bold">{{ $equipoUsuario->puntos ?? '--' }}</p>
                                    </div>
                                    <div class="bg-[#fffaf5] p-2 rounded border border-gray-100 shadow-sm">
                                        <p class="text-cyan-600 text-xs">SALDO</p>
                                        <p class="text-gray-800 font-bold">{{ $equipoUsuario ? number_format($equipoUsuario->presupuesto, 0, ',', '.') . '€' : '--' }}</p>
                                    </div>
                                    <div class="bg-[#fffaf5] p-2 rounded border border-gray-100 shadow-sm">
                                        <p class="text-cyan-600 text-xs">VALOR EQUIPO</p>
                                        <p class="text-gray-800 font-bold">
                                            {{ number_format($liga->valor_equipo, 0, ',', '.') }} €
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Botones de Acción -->
                            <div class="flex space-x-3">
                                <a href="{{ route('mi-liga', $liga->id) }}" class="flex-[65] bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white py-3 px-4 rounded-lg text-center font-medium transition-all duration-200 hover:scale-[1.02] active:scale-95 shadow-md shadow-cyan-400/30 border-b border-cyan-500/50 text-sm flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    VER LIGA
                                </a>

                                <form method="POST" action="{{ route('ligas.salir', $liga->id) }}" class="flex-[35]" id="abandonarLigaForm-{{ $liga->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="button" 
                                        onclick="confirmarSalida({{ $liga->id }}, {{ $liga->miembros_count }})" 
                                        class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-400 hover:to-pink-500 text-white py-3 px-4 rounded-lg font-medium transition-all duration-200 hover:scale-[1.02] active:scale-95 shadow-md shadow-pink-400/30 border-b border-pink-500/50 text-sm flex items-center justify-center"
                                    >
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        ABANDONAR
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-16">
                        <div class="bg-white border-2 border-cyan-300 rounded-xl p-8 max-w-md mx-auto shadow-md">
                            <svg class="w-16 h-16 mx-auto text-cyan-400/60 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-xl font-medium text-gray-700">NO TIENES LIGAS</h3>
                            <p class="text-gray-500 mt-2 mb-4">Crea una nueva liga o únete a una existente para comenzar</p>
                            
                        </div>
                    </div>
                @endforelse
            @else
                <div class="col-span-2 text-center py-10">
                    <div class="bg-red-100 border-2 border-red-300 rounded-xl p-6 max-w-md mx-auto shadow-sm">
                        <svg class="w-12 h-12 mx-auto text-red-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-red-600">ERROR AL CARGAR LIGAS</h3>
                        <p class="text-gray-600 mt-1">No se pudieron cargar tus ligas. Intenta recargar la página.</p>
                    </div>
                </div>
            @endisset
        </div>
            <br><br>
            <!-- Sección de reglas estilo terminal -->
            <div class="bg-white p-6 rounded-2xl border-2 border-gray-200 shadow-lg shadow-blue-100/30 mb-8">
                <div class="flex items-center mb-5">
                    <div class="flex space-x-2 mr-4">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    </div>
                    <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">
                        SISTEMA DE PUNTUACIÓN
                    </h3>
                </div>
                <div class="bg-gray-50/80 p-5 rounded-xl border border-gray-200 font-mono text-green-600">
                    <p class="mb-3"><span class="text-purple-500">>></span> <span class="text-yellow-600">POR CADA KILL <i class="fa-solid fa-skull"></i>:</span> <span class="text-gray-800">2 PUNTOS</span></p>
                    <p class="mb-3"><span class="text-purple-500">>></span> <span class="text-yellow-600">POR CADA ASISTENCIA <i class="fa-solid fa-handshake-angle"></i>:</span> <span class="text-gray-800">1 PUNTO </span></p>
                    <p class="mb-3"><span class="text-purple-500">>></span> <span class="text-yellow-600">POR CADA TORRE DESTRUIDA <i class="fa-solid fa-gopuram"></i>:</span> <span class="text-gray-800">1 PUNTO</span></p>
                    <p class="mb-3"><span class="text-purple-500">>></span> <span class="text-yellow-600">POR CADA OBJETIVO <i class="fa-solid fa-spaghetti-monster-flying"></i>:</span> <span class="text-gray-800">4 PUNTOS</span></p>
                    <p><span class="text-purple-500">>></span> <span class="text-yellow-600">ACTUALIZACIÓN <i class="fa-solid fa-rotate-right"></i>:</span> <span class="text-gray-800">Automática tras cada jornada</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pequeño script para mostrar/ocultar campo de contraseña -->
    <script>
        
        function passwordPrivada(select) {
            const passwordField = document.getElementById('password-field');
            if (select.value === 'privada') {
                passwordField.classList.remove('hidden');
            } else {
                passwordField.classList.add('hidden');
            }
        }

        function unirse() {
        // Realizar la solicitud de unirse a la liga
        fetch('/ligas/unirse', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                liga_id: Alpine.store('modal').selectedLiga.id,
                password: Alpine.store('modal').password
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                Alpine.store('modal').error = data.message || 'Error al unirse.';
            }
        });
    }
    
    function joinLeagueModal() {
    return {
        showJoinModal: false,
        showConfirmModal: false,
        searchTerm: '',
        leagues: [],
        selectedLeague: null,
        password: '',
        error: '',
        isLoading: false,
        
        async searchLeagues() {
            this.isLoading = true;
            try {
                const url = this.searchTerm 
                    ? `/ligas/buscar?search=${encodeURIComponent(this.searchTerm)}`
                    : '/ligas/buscar';
                
                const response = await fetch(url);
                const data = await response.json();
                
                // Ordenar por número de miembros (descendente)
                this.leagues = data.sort((a, b) => b.usuarios_count - a.usuarios_count);
                
                // Auto-scroll al principio
                if (this.$refs.resultsContainer) {
                    this.$refs.resultsContainer.scrollTop = 0;
                }
            } catch (e) {
                console.error('Error buscando ligas:', e);
                this.error = 'Error al buscar ligas';
                this.leagues = [];
            } finally {
                this.isLoading = false;
            }
        },
        
        selectLeague(league) {
            this.selectedLeague = league;
            this.showConfirmModal = true;
            this.password = '';
        },
        
        async joinLeague() {
            this.error = '';
            
            try {
                const response = await fetch('/ligas/unirse', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        liga_id: this.selectedLeague.id,
                        password: this.password
                    })
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || 'Error al unirse a la liga');
                }
                
                if (data.success) {
                    window.location.reload();
                } else {
                    this.error = data.message;
                }
            } catch (error) {
                this.error = error.message;
            }
        }
    }
}
function confirmarSalida(ligaId, miembrosCount) {
    console.log('Intentando abandonar liga:', ligaId);

    Swal.fire({
        title: '¿Abandonar liga?',
        html: `
            <div style="text-align:center;">
                <div style="width:100%;height:0;padding-bottom:100%;position:relative;margin-bottom:10px;">
                   <img src="{{ asset('imagenes/abejaGift.gif') }}" alt="Abeja GIF" width="100%" height="100%" style="position:absolute;">
                </div>
                <p style="color:#f3f4f6; font-family:'Press Start 2P', monospace; font-size:12px;">
                    ¿Estás seguro de que quieres abandonar esta liga?
                </p>
            </div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Abandonar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        background: '#111827',
        allowOutsideClick: false,
        customClass: {
            popup: 'border-4 border-indigo-600 rounded-xl shadow-xl',
            confirmButton: 'text-white font-bold rounded-lg px-4 py-2 shadow-md',
            cancelButton: 'text-white font-bold rounded-lg px-4 py-2 shadow-md ml-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(`abandonarLigaForm-${ligaId}`);
            if (form) {
                console.log('Enviando formulario para liga:', ligaId);
                form.submit();
            } else {
                console.error('No se encontró el formulario');
                Swal.fire('Error', 'No se pudo procesar la solicitud', 'error');
            }
        }
    });
}

    </script>
    <style>
        .custom-scrollbar-light::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar-light::-webkit-scrollbar-track {
            background: rgba(229, 231, 235, 0.5);
            border-radius: 10px;
        }
        .custom-scrollbar-light::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.5);
            border-radius: 10px;
        }
        .custom-scrollbar-light::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.7);
        }
    </style>
</x-app-layout>