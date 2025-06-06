<x-app-layout>
    <x-slot name="header">
        <div class="text-center mb-12 px-4 sm:px-0">
                <!-- Título -->
                <h2 class="text-4xl font-bold tracking-tight dark:text-gray-100 text-gray-800 mb-4">
                    @lang('messages.mis-ligas')
                </h2>
                
                <!-- Barra divisora con animación RGB -->
                <div class="relative max-w-md mx-auto h-1.5 rounded-full overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-500 via-cyan-400 to-purple-600 dark:from-amber-400 dark:via-cyan-300 dark:to-purple-500 animate-[rgbFlow_3s_linear_infinite]"></div>
                </div>
                
                <div class="mt-3 flex justify-center space-x-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-cyan-400 dark:bg-cyan-300 animate-pulse"></span>
                    <span class="inline-block w-2 h-2 rounded-full bg-purple-600 dark:bg-purple-400 animate-pulse delay-100"></span>
                    <span class="inline-block w-2 h-2 rounded-full bg-amber-500 dark:bg-amber-400 animate-pulse delay-200"></span>
                </div>
            </div>
            @if(session('success'))
                <div id="successAlert" class="mt-4 mb-6 p-4 rounded-lg border-2 border-green-400 dark:border-green-600 bg-gradient-to-br from-green-900/80 dark:from-green-800 to-green-800/90 dark:to-green-900/90 text-green-100 dark:text-green-50 shadow-lg shadow-green-500/20 dark:shadow-green-600/20 relative overflow-hidden">
                    <div class="absolute inset-0 border-2 border-green-300/30 dark:border-green-400/20 rounded-lg pointer-events-none"></div>
                    
                    <!-- Icono y contenido -->
                    <div class="flex items-start">
                        <div class="mr-3 text-green-400 dark:text-green-300 animate-pulse">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-green-300 dark:text-green-200 text-xl mb-1 font-mono tracking-wider"> @lang('messages.enhorabuena')</h4>
                            <p class="text-green-100 dark:text-green-50 text-shadow font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div id="errorAlert" class="mt-4 mb-6 p-4 rounded-lg border-2 border-red-400 dark:border-red-600 bg-gradient-to-br from-red-900/80 dark:from-red-900 to-red-800/90 dark:to-red-900/90 text-red-100 dark:text-red-50 shadow-lg shadow-red-500/20 dark:shadow-red-600/20 relative overflow-hidden">
                    <div class="absolute inset-0 border-2 border-red-300/30 dark:border-red-400/20 rounded-lg pointer-events-none"></div>
                    
                    <!-- Icono y contenido -->
                    <div class="flex items-start">
                        <div class="mr-3 text-red-400 dark:text-red-300 animate-pulse">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-red-300 dark:text-red-200 text-xl mb-1 font-mono tracking-wider">@lang('messages.errordetectado')</h4>
                            <ul class="text-red-100 dark:text-red-50 text-shadow space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="flex items-start">
                                        <span class="text-red-400 dark:text-red-300 mr-2">■</span>
                                        <span>{{ $error }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    
                    <div class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-red-400 dark:border-red-300"></div>
                    <div class="absolute top-0 right-0 w-3 h-3 border-t-2 border-r-2 border-red-400 dark:border-red-300"></div>
                    <div class="absolute bottom-0 left-0 w-3 h-3 border-b-2 border-l-2 border-red-400 dark:border-red-300"></div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-red-400 dark:border-red-300"></div>
                </div>
            @endif
        </x-slot>

<div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen border-t border-[#3b82f6] shadow-[0_0_10px_#3b82f6] dark:border-t-1 dark:border-[#39ff14] dark:shadow-[0_0_10px_#39ff14]">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
        <div class="flex flex-col sm:flex-row gap-5 mb-12 justify-center items-center sm:items-stretch">
            <button type="button"
                onclick="document.getElementById('create-league-modal').classList.remove('hidden')"
                class="w-full sm:w-[260px] px-8 py-3.5 bg-gradient-to-r from-blue-500 to-cyan-500 dark:from-blue-600 dark:to-cyan-600 rounded-xl font-bold text-white hover:from-blue-600 hover:to-cyan-600 dark:hover:from-blue-700 dark:hover:to-cyan-700 transition-all transform hover:scale-[1.03] shadow-lg shadow-cyan-300/40 dark:shadow-cyan-500/30 border-b-2 border-cyan-600/70 dark:border-cyan-700/70 active:scale-95 text-center">
                🏆 @lang('messages.crear-liga-may')
            </button>

            <button x-data @click="$dispatch('open-join-modal')"
                class="w-full sm:w-[260px] px-8 py-3.5 bg-gradient-to-r from-green-400 to-emerald-500 dark:from-green-500 dark:to-emerald-600 rounded-xl font-bold text-white hover:from-green-500 hover:to-emerald-600 dark:hover:from-green-600 dark:hover:to-emerald-700 transition-all transform hover:scale-[1.03] shadow-lg shadow-emerald-300/40 dark:shadow-emerald-500/30 border-b-2 border-emerald-600/70 dark:border-emerald-700/70 active:scale-95 text-center">
                🎮 @lang('messages.unirse-liga')
            </button>
        </div>

        <!-- Modal para crear liga -->
        <div id="create-league-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
            <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-500 dark:from-blue-600 dark:to-cyan-600 p-5 text-white">
                    <h3 class="text-xl font-bold text-center"> @lang('messages.crear-nueva-liga-may')</h3>
                </div>
                
                <form id="crearLigaForm" class="p-6" method="POST"  action="{{ route('ligas.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Nombre -->
                    <div class="mb-4">
                        <label for="nombre" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">@lang('messages.nombre_liga') <b class="text-red-700">*</b></label>
                        <input type="text" id="nombre" name="nombre" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    </div>
                    
                    <!-- Descripción -->
                    <div class="mb-4">
                        <label for="descripcion" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">@lang('messages.descripcion')</label>
                        <textarea id="descripcion" name="descripcion" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"></textarea>
                    </div>
                    
                    <!-- Tipo de liga (select) -->
                    <div class="mb-4">
                        <label for="tipo" class="block text-gray-700 dark:text-gray-300 font-medium mb-2"> @lang('messages.tipo_liga')</label>
                        <select id="tipo" name="tipo" onchange="passwordPrivada(this)" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                            <option value="publica"> @lang('messages.publica')</option>
                            <option value="privada"> @lang('messages.privada')</option>
                        </select>
                    </div>
                    
                    <!-- Contraseña (solo para privada) - inicialmente oculto -->
                    <div id="password-field" class="mb-4 hidden">
                        <label for="contrasena" class="block text-gray-700 dark:text-gray-300 font-medium mb-2"> @lang('messages.contraseña')</label>
                        <input type="password" id="contrasena" name="contrasena" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"> @lang('messages.jugadores_con_contraseña')</p>
                    </div>
                    
                    <!-- Logo de la liga -->
                    <div class="mb-6">
                        <label for="logo_url" class="block text-gray-700 dark:text-gray-300 font-medium mb-2"> @lang('messages.logo_liga')</label>
                        <input type="file" id="logo_url" name="logo_url" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 dark:file:bg-blue-900/20 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900/30">
                    </div>
                    
                    <!-- Botones -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById('create-league-modal').classList.add('hidden')" class="px-5 py-2.5 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                             @lang('messages.cancelar')
                        </button>
                        <button  id="crearLigaBtn" type="submit" class="px-5 py-2.5 bg-blue-500 dark:bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-600 dark:hover:bg-blue-700 transition">
                             @lang('messages.crear_liga')
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
            <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700"
                @click.away="showJoinModal = false"
                x-show="!showConfirmModal"
                x-transition>
                
                <!-- Header limpio -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-4 relative ">
                    <h3 class="text-xl font-bold text-white text-center">@lang('messages.unirse_liga')</h3>
                    <button @click="showJoinModal = false" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-300 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Contenido -->
                <div class="p-5">
                    
                    <div class="relative mb-5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            x-model="searchTerm" 
                            @input.debounce.300ms="searchLeagues()"
                            type="text" 
                            placeholder="@lang('messages.buscar_ligas_por_nombre')" 
                            class="w-full pl-10 pr-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-600 focus:border-green-500 dark:focus:border-green-600 transition-all"
                        >
                        <div x-show="isLoading" class="absolute right-3 top-3.5">
                            <svg class="animate-spin h-5 w-5 text-blue-500 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Resultados con scroll -->
                    <div class="max-h-[300px] overflow-y-auto pr-2 custom-scrollbar-light dark:custom-scrollbar-dark" x-ref="resultsContainer">
                        <template x-if="leagues.length === 0 && !isLoading">
                            <div class="text-center py-6">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h4 class="mt-2 text-gray-500 dark:text-gray-400 font-medium"> @lang('messages.no_encontrado_ligas')</h4>
                                <p class="mt-1 text-gray-400 dark:text-gray-500 text-sm" x-text="searchTerm.length >= 2 ? 'Prueba con otro nombre' : 'Empieza a escribir para buscar'"></p>
                            </div>
                        </template>
                        
                        <template x-for="(league, index) in leagues" :key="league.id">
                            <div 
                                @click="selectLeague(league)"
                                class="flex items-center p-3 mb-2 rounded-lg cursor-pointer transition-all hover:bg-blue-50 dark:hover:bg-gray-700 hover:translate-x-1 border border-gray-200 dark:border-gray-700 hover:border-green-300 dark:hover:border-green-500"
                                x-intersect.once="$el.scrollIntoView({ behavior: 'smooth', block: 'nearest' })"
                            >
                                <div class="relative">
                                    <img 
                                        :src="league.logo_url || 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1746528986/fotoliga_predeterminada.webp'" 
                                        alt="Logo liga" 
                                        class="w-12 h-12 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                                    >
                                    
                                </div>
                                <div class="ml-4 flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-800 dark:text-gray-200 truncate" x-text="league.nombre"></h4>
                                    <div class="flex items-center mt-1">
                                        <span class="text-xs px-2 py-0.5 rounded-full"
                                            :class="{ 
                                                'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-200 border border-purple-200 dark:border-purple-700': league.tipo === 'privada',
                                                'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-700': league.tipo === 'publica'
                                            }"
                                             x-text="league.tipo === 'privada' ? '{{ __('messages.privada') }}' : '{{ __('messages.publica') }}'">
                                        </span>
                                        <span class="ml-2 text-xs text-gray-500 dark:text-gray-400" x-text="`${league.usuarios_count} @lang('messages.miembros')`"></span>
                                    </div>
                                </div>
                                <svg class="h-5 w-5 text-gray-400 dark:text-gray-500 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Contador de resultados -->
                    <div class="text-right mt-3 text-xs text-gray-500 dark:text-gray-400" 
                        x-text="leagues.length > 0 ? `@lang('messages.showing') ${leagues.length} @lang('messages.league')` : ''"
                        x-show="leagues.length > 0">
                    </div>
                </div>
            </div>
            
            <!-- Modal de confirmación -->
            <div 
                x-show="showConfirmModal" 
                class="w-full max-w-md bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-700"
                @click.away="showConfirmModal = false"
            >
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-4 relative">
                    <h3 class="text-xl font-bold text-gray-200 text-center"> @lang('messages.confirmar_union')</h3>
                    <button @click="showConfirmModal = false" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-300 hover:text-white transition">
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
                                class="w-16 h-16 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600"
                            >
                            
                        </div>
                        <div class="ml-4">
                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-200" x-text="selectedLeague?.nombre"></h4>
                            <span class="text-xs px-2 py-0.5 rounded-full mt-1 inline-block"
                                :class="{
                                    'bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-200 border border-purple-200 dark:border-purple-700': selectedLeague?.tipo === 'privada',
                                    'bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-700': selectedLeague?.tipo === 'publica'
                                }"
                                x-text="selectedLeague?.tipo === 'privada' ? '{{ __('messages.liga_privada') }}' : '{{ __('messages.liga_publica') }}'">
                            </span>
                        </div>
                    </div>
                    
                    <template x-if="selectedLeague?.tipo === 'privada'">
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"> @lang('messages.contraseña_requerida')</label>
                            <div class="relative">
                                <input 
                                    x-model="password"
                                    type="password" 
                                    placeholder="{{ __('messages.league_password_placeholder') }}" 
                                    class="w-full px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 dark:focus:border-blue-600 transition-all"
                                >
                                <div class="absolute right-3 top-3.5 text-gray-400 dark:text-gray-500">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <p x-show="error" class="mt-3 text-sm text-red-500 dark:text-red-400 flex items-center" x-text="error">
                        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </p>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button 
                            @click="showConfirmModal = false" 
                            class="px-5 py-2.5 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-600 transition-all border border-gray-300 dark:border-gray-600 hover:border-gray-400 dark:hover:border-gray-500"
                        >
                             @lang('messages.cancelar')
                        </button>
                        <button 
                            @click="joinLeague()" 
                            class="px-5 py-2.5 from-green-400 to-emerald-500 dark:from-green-500 dark:to-emerald-600 bg-gradient-to-r rounded-xl font-bold text-white hover:from-green-500 hover:to-emerald-600 dark:hover:from-green-600 dark:hover:to-emerald-700 transition-all  transform hover:scale-[1.03] shadow-lg shadow-emerald-300/40 dark:shadow-emerald-500/30 border-b-2 border-emerald-600/70 dark:border-emerald-700/70 active:scale-95 flex items-center"

                        >
                            <svg class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                             @lang('messages.unirse')
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
            
            <div class="bg-[#fff7f0] dark:bg-gray-800/90 rounded-2xl overflow-hidden border-2 border-cyan-300 dark:border-cyan-600 hover:border-cyan-400 dark:hover:border-cyan-500 transition-all  shadow-lg shadow-cyan-100/50 dark:shadow-cyan-900/30 relative group">

                    <!-- Efecto de brillo sutil al hover -->
                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-100/20 dark:from-cyan-900/10 to-blue-100/10 dark:to-blue-900/10 opacity-0 group-hover:opacity-100 transition-opacity "></div>
                    
                    <!-- Parte superior: Info de la Liga -->
                    <div class="p-6 relative z-10 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex items-center mb-4">
                            <div class="relative">
                                <img src="{{ $liga->logo_url }}" alt="Logo Liga" class="min-w-16 h-16 rounded-full border-2 border-cyan-400 dark:border-cyan-500 object-cover shadow-md">
                                
                                <!-- Mostrar medalla según la posición -->
                                @if($posicion == 1)
                                    <div class="absolute -bottom-1 -right-1 bg-amber-400 dark:bg-amber-500 text-xs font-bold rounded-full w-7 h-7 flex items-center justify-center shadow-sm border border-amber-300 dark:border-amber-400">
                                        🥇
                                    </div>
                                @elseif($posicion == 2)
                                    <div class="absolute -bottom-1 -right-1 bg-gray-400 dark:bg-gray-500 text-xs font-bold rounded-full w-7 h-7 flex items-center justify-center shadow-sm border border-silver-300 dark:border-gray-400">
                                        🥈
                                    </div>
                                @elseif($posicion == 3)
                                    <div class="absolute -bottom-1 -right-1 bg-orange-400 dark:bg-orange-500 text-xs font-bold rounded-full w-7 h-7 flex items-center justify-center shadow-sm border border-bronze-300 dark:border-orange-400">
                                        🥉
                                    </div>
                                @endif
                            </div>

                            <div class="ml-5">
                                <h3 class="font-bold text-xl text-gray-800 dark:text-gray-200">{{ strtoupper($liga->nombre) }}</h3>
                                <p class="text-cyan-600 dark:text-cyan-400 flex items-center text-sm mt-1">
                                    <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                    {{ $liga->usuario_id == auth()->id() ? __('messages.lider') : __('messages.miembro') }}
                                </p>

                            </div>
                        </div>

                        
                        <!-- Mini descripción -->
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-3 line-clamp-2">
                            {{ $liga->descripcion ?: __('messages.sin_descripcion') }}
                        </p>
                    </div>
                    
                    <!-- Parte media: Separador visual -->
                    <div class="bg-gradient-to-r from-transparent via-cyan-300 dark:via-cyan-500 to-transparent h-px w-full"></div>
                    
                    <!-- Parte inferior: Puntuación y acciones -->
                    <div class="p-6 relative z-10">
                        <!-- Sección de Puntuación -->
                        <div class="bg-[#fffaf5] dark:bg-gray-700/80 p-4 rounded-lg mb-4 border border-gray-200 dark:border-gray-600 shadow-inner">
                            <h4 class="text-xs font-mono text-cyan-600 dark:text-cyan-400 mb-3 tracking-wider"> @lang('messages.estadisticas')</h4>
                            
                            <!-- Barra de progreso con posición real -->
                            <div class="mb-3">
                                @php
                                $totalMiembros = $liga->miembros_count;
                                @endphp
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-xs font-medium text-gray-600 dark:text-gray-400"> @lang('messages.tu_posicion')</span>
                                    <span class="text-amber-600 dark:text-amber-400 font-bold text-sm">{{ $posicion }}/{{ $totalMiembros }}</span>
                                </div>
                                @php
                                    $posicionNumerica = is_numeric($posicion) ? (int) $posicion : null;
                                    $porcentajePosicion = $totalMiembros > 1
                                    ? ((($totalMiembros - $posicion) / ($totalMiembros - 1)) * 100)
                                    : 100;

                                @endphp

                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r from-amber-400 to-amber-500 dark:from-amber-500 dark:to-amber-600 h-2.5 rounded-full"
                                        style="width: {{ $porcentajePosicion }}%"></div>
                                </div>
                            </div>
                            
                            <!-- Mini estadísticas con datos reales -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 text-center">
                                <div class="bg-[#fffaf5] dark:bg-gray-700 p-2 rounded border border-gray-100 dark:border-gray-600 shadow-sm">
                                    <p class="text-cyan-600 dark:text-cyan-400 text-xs"> @lang('messages.puntos')</p>
                                    <p class="text-gray-800 dark:text-gray-200 font-bold break-words">{{ $equipoUsuario->puntos ?? '--' }}</p>
                                </div>
                                <div class="bg-[#fffaf5] dark:bg-gray-700 p-2 rounded border border-gray-100 dark:border-gray-600 shadow-sm">
                                    <p class="text-cyan-600 dark:text-cyan-400 text-xs"> @lang('messages.saldo')</p>
                                    <p class="text-gray-800 dark:text-gray-200 font-bold break-words">{{ $equipoUsuario ? number_format($equipoUsuario->presupuesto, 0, ',', '.') . '€' : '--' }}</p>
                                </div>
                                <div class="bg-[#fffaf5] dark:bg-gray-700 p-2 rounded border border-gray-100 dark:border-gray-600 shadow-sm">
                                    <p class="text-cyan-600 dark:text-cyan-400 text-xs"> @lang('messages.valor_equipo')</p>
                                    <p class="text-gray-800 dark:text-gray-200 font-bold break-words">{{ number_format($liga->valor_equipo, 0, ',', '.') }} €</p>
                                </div>
                            </div>

                        </div>
                        
                        <!-- Botones de Acción -->
                       <div class="flex flex-col md-custom:flex-row space-y-2 md-custom:space-y-0 md-custom:space-x-3">
                            <a href="{{ route('mi-liga', $liga->id) }}" 
                                class="flex-1 min-w-[180px] max-w-full md-custom:max-w-[65%] bg-gradient-to-r from-cyan-500 to-blue-600 dark:from-cyan-600 dark:to-blue-700 hover:from-cyan-400 hover:to-blue-500 dark:hover:from-cyan-500 dark:hover:to-blue-600 text-white py-3 px-4 rounded-lg text-center font-medium transition-all hover:scale-[1.02] active:scale-95 shadow-md shadow-cyan-400/30 dark:shadow-cyan-600/30 border-b border-cyan-500/50 dark:border-cyan-600/50 text-sm flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                @lang('messages.ver_liga_may')
                            </a>

                            <form method="POST" action="{{ route('ligas.salir', $liga->id) }}" 
                                class="flex-1 min-w-[120px] max-w-full md-custom:max-w-[35%]" 
                                id="abandonarLigaForm-{{ $liga->id }}">
                                @csrf
                                @method('DELETE')
                                <button 
                                type="button" 
                                onclick="confirmarSalida({{ $liga->id }}, {{ $liga->miembros_count }})" 
                                class="w-full bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-400 hover:to-pink-500 text-white py-3 px-4 rounded-lg font-medium transition-all hover:scale-[1.02] active:scale-95 shadow-md shadow-pink-400/30 border-b border-pink-500/50 text-sm flex items-center justify-center"
                                >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                @lang('messages.abandonar')
                                </button>
                            </form>
                        </div>

                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-16">
                        <div class="bg-white dark:bg-gray-800 border-2 border-cyan-300 dark:border-cyan-600 rounded-xl p-8 max-w-md mx-auto shadow-md dark:shadow-blue-900/40">
                            <svg class="w-16 h-16 mx-auto text-cyan-400/60 dark:text-cyan-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-xl font-medium text-gray-700 dark:text-gray-200">@lang('messages.no_tienes_ligas')</h3>
                            <p class="text-gray-500 dark:text-gray-400 mt-2 mb-4">@lang('messages.crea_o_unete')</p>
                        </div>
                    </div>
                @endforelse
            @else
                <div class="col-span-2 text-center py-10">
                    <div class="bg-red-100 dark:bg-red-950 border-2 border-red-300 dark:border-red-600 rounded-xl p-6 max-w-md mx-auto shadow-sm">
                        <svg class="w-12 h-12 mx-auto text-red-500 dark:text-red-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-red-600 dark:text-red-300">@lang('messages.error_ligas')</h3>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">@lang('messages.no_recargar_pagina')</p>
                    </div>
                </div>
            @endisset
        </div>
        <br><br>
        <!-- Sección de reglas estilo terminal -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border-2 border-gray-200 dark:border-gray-700 shadow-lg shadow-blue-100/30 dark:shadow-blue-900/40 mb-8 animate-fade-in-up transition-all ">
            <div class="flex items-center mb-5">
                <div class="flex space-x-2 mr-4">
                    <div class="w-3 h-3 rounded-full bg-red-400 animate-pulse"></div>
                    <div class="w-3 h-3 rounded-full bg-yellow-400 animate-pulse delay-100"></div>
                    <div class="w-3 h-3 rounded-full bg-green-400 animate-pulse delay-200"></div>
                </div>
                <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500 animate-gradient dark:from-cyan-400 dark:to-blue-300">
                    @lang('messages.sistema_puntuacion')
                </h3>
            </div>

            <div class="bg-gray-50/80 dark:bg-gray-800 p-5 rounded-xl border border-gray-200 dark:border-gray-600 font-mono text-green-600 dark:text-green-400 space-y-3">
                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_cada_kill') <i class="fa-solid fa-skull ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_kill')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_cada_asistencia') <i class="fa-solid fa-handshake-angle ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_asistencia')</span>
                </p>
                            
                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_cada_muerte') <i class="fa-solid fa-skull-crossbones ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_muerte')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_puntos_vision') <i class="fa-solid fa-eye ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_vision')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_objetivos_robados') <i class="fa-solid fa-hand-rock ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_objetivos_robados')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_dano_torres') <i class="fa-solid fa-gopuram ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_dano_torres')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_oro_conseguido') <i class="fa-solid fa-coins ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_oro')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_double_kill') <i class="fa-solid fa-2 ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_double_kill')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_triple_kill') <i class="fa-solid fa-3 ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_triple_kill')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_quadra_kill') <i class="fa-solid fa-4 ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_quadra_kill')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_penta_kill') <i class="fa-solid fa-5 ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_penta_kill')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_dano_campeones') <i class="fa-solid fa-bolt ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_dano_campeones')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_dano_recibido') <i class="fa-solid fa-shield-halved ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_dano_recibido')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_tiempo_muerto') <i class="fa-solid fa-hourglass-end ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_tiempo_muerto')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_botin_conseguido') <i class="fa-solid fa-gift ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_botin_conseguido')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_botin_perdido') <i class="fa-solid fa-box-open ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_botin_perdido')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_primera_sangre') <i class="fa-solid fa-droplet ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_primera_sangre')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.por_primera_torre') <i class="fa-solid fa-tower-broadcast ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.puntos_primera_torre')</span>
                </p>

                <p class="transition-all  hover:bg-gray-100 dark:hover:bg-gray-700 hover:scale-[1.02] hover:shadow-md rounded-lg p-1">
                    <span class="text-purple-500">>></span>
                    <span class="text-yellow-600 dark:text-yellow-400 group inline-flex items-center">
                        @lang('messages.actualizacion') <i class="fa-solid fa-rotate-right ml-1 group-hover:animate-spin-slow"></i>:
                    </span>
                    <span class="text-gray-800 dark:text-gray-200">@lang('messages.automatica_tras_jornada')</span>
                </p>
            </div>

        </div>
    <script>
        // Solo un click en el boton de crear liga para evitar errores
        document.getElementById('crearLigaForm').addEventListener('submit', function () {
            const boton = document.getElementById('crearLigaBtn');
            boton.disabled = true;
            boton.classList.add('opacity-50', 'cursor-not-allowed');
            boton.textContent = 'Creando...'; 
        });

        
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
            title: '@lang("messages.abandonar_liga")',
            html: `
                <div style="text-align:center;">
                    <div style="width:100%;height:0;padding-bottom:100%;position:relative;margin-bottom:10px;">
                    <img src="{{ asset('Imagenes/abejaGift.gif') }}" alt="Abeja GIF" width="100%" height="100%" style="position:absolute;">
                    </div>
                    <p style="color:#f3f4f6; font-family:'Press Start 2P', monospace; font-size:12px;">
                        @lang("messages.confirmar_abandonar")
                    </p>
                </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '@lang("messages.abandonar_min")',
            cancelButtonText: '@lang("messages.cancelar")',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            background: '#111827',
            allowOutsideClick: false,
            customClass: {
                popup: 'border-4 border-indigo-600 rounded-xl shadow-xl',
                confirmButton: 'text-white font-bold rounded-lg px-4 py-2 shadow-md',
                cancelButton: 'text-white font-bold rounded-lg px-4 py-2 shadow-md ml-2'
            }
        })
        .then((result) => {
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
    
    //Cuando hay un "success" o "error" desaparece a los 5 segundos el mensaje
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');

        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => successAlert.remove(), 500); 
            }, 5000);
        }

        if (errorAlert) {
            setTimeout(() => {
                errorAlert.classList.add('opacity-0', 'transition-opacity', 'duration-500');
                setTimeout(() => errorAlert.remove(), 500); 
            });
        }
    });

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
        @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out both;
        }
        @keyframes spinSlow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spinSlow 2s linear infinite;
        }
    </style>
</x-app-layout>