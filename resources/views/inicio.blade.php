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
                
                <!-- Efecto de esquina gaming -->
                <div class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-green-400"></div>
                <div class="absolute top-0 right-0 w-3 h-3 border-t-2 border-r-2 border-green-400"></div>
                <div class="absolute bottom-0 left-0 w-3 h-3 border-b-2 border-l-2 border-green-400"></div>
                <div class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-green-400"></div>
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
                
                <!-- Efecto de esquina gaming -->
                <div class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-red-400"></div>
                <div class="absolute top-0 right-0 w-3 h-3 border-t-2 border-r-2 border-red-400"></div>
                <div class="absolute bottom-0 left-0 w-3 h-3 border-b-2 border-l-2 border-red-400"></div>
                <div class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-red-400"></div>
            </div>
        @endif

    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <!-- Botones Gaming Mejorados -->
            <div class="flex flex-wrap gap-5 mb-12 justify-center">
                <button type="button" onclick="document.getElementById('create-league-modal').classList.remove('hidden')" class="px-8 py-3.5 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl font-bold text-white hover:from-blue-600 hover:to-cyan-600 transition-all duration-200 transform hover:scale-[1.03] shadow-lg shadow-cyan-300/40 border-b-2 border-cyan-600/70 active:scale-95">
                    🏆 CREAR LIGA
                </button>
                <button @click="openJoinLeagueModal" class="px-8 py-3.5 bg-gradient-to-r from-green-400 to-emerald-500 rounded-xl font-bold text-white hover:from-green-500 hover:to-emerald-600 transition-all duration-200 transform hover:scale-[1.03] shadow-lg shadow-emerald-300/40 border-b-2 border-emerald-600/70 active:scale-95">
                    🎮 UNIRSE A LIGA
                </button>
            </div>

            <!-- Modal para crear liga -->
            <div id="create-league-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-50">
                <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-cyan-500 p-5 text-white">
                        <h3 class="text-xl font-bold">CREAR NUEVA LIGA</h3>
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
                            <label for="codigo_unico" class="block text-gray-700 font-medium mb-2">Contraseña</label>
                            <input type="password" id="codigo_unico" name="codigo_unico" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
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
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                @isset($ligas)
                    @forelse($ligas as $liga)
                        <!-- Tarjeta de Liga - Estilo Gaming Mejorado -->
                        <div class="bg-gray-900 rounded-2xl overflow-hidden border-2 border-cyan-500/30 hover:border-cyan-400 transition-all duration-300 shadow-lg shadow-cyan-500/10 relative group">
                            <!-- Efecto de brillo al hover -->
                            <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/5 to-blue-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <!-- Parte superior: Info de la Liga -->
                            <div class="p-6 relative z-10 border-b border-cyan-900/50">
                                <div class="flex items-center mb-4">
                                    <div class="relative">
                                        <img src="{{ $liga->logo_url }}" alt="Logo Liga" class="w-16 h-16 rounded-full border-2 border-cyan-400 object-cover shadow-lg">
                                        <div class="absolute -bottom-1 -right-1 bg-amber-400 text-xs font-bold rounded-full w-7 h-7 flex items-center justify-center shadow-md border border-amber-200">🥇</div>
                                    </div>
                                    <div class="ml-5">
                                        <h3 class="font-bold text-xl text-cyan-100">{{ strtoupper($liga->nombre) }}</h3>
                                        <p class="text-cyan-400 flex items-center text-sm mt-1">
                                            <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                            {{ $liga->usuarios_count }} JUGADORES
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Mini descripción -->
                                <p class="text-gray-300 text-sm mt-3 line-clamp-2">
                                    {{ $liga->descripcion ?? 'Sin descripción' }}
                                </p>
                            </div>
                            
                            <!-- Parte media: Separador visual -->
                            <div class="bg-gradient-to-r from-transparent via-cyan-500/40 to-transparent h-px w-full"></div>
                            
                            <!-- Parte inferior: Puntuación y acciones -->
                            <div class="p-6 relative z-10">
                                <!-- Sección de Puntuación - Estilo HUD Gaming -->
                                <div class="bg-gray-800/80 p-4 rounded-lg mb-4 border border-cyan-500/20 shadow-inner">
                                    <h4 class="text-xs font-mono text-cyan-300 mb-3 tracking-wider">ESTADÍSTICAS</h4>
                                    
                                    <!-- Barra de progreso estilo gaming -->
                                    <div class="mb-3">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-xs font-medium text-gray-400">TU POSICIÓN</span>
                                            <span class="text-amber-300 font-bold text-sm">--</span>
                                        </div>
                                        <div class="w-full bg-gray-700 rounded-full h-2.5">
                                            <div class="bg-gradient-to-r from-amber-400 to-amber-600 h-2.5 rounded-full w-3/4 shadow-lg shadow-amber-500/30"></div>
                                        </div>
                                    </div>
                                    
                                    <!-- Mini estadísticas -->
                                    <div class="grid grid-cols-3 gap-2 text-center">
                                        <div class="bg-gray-900/50 p-2 rounded">
                                            <p class="text-cyan-300 text-xs">PUNTOS</p>
                                            <p class="text-white font-bold">--</p>
                                        </div>
                                        <div class="bg-gray-900/50 p-2 rounded">
                                            <p class="text-cyan-300 text-xs">KILLS</p>
                                            <p class="text-white font-bold">--</p>
                                        </div>
                                        <div class="bg-gray-900/50 p-2 rounded">
                                            <p class="text-cyan-300 text-xs">VICTORIAS</p>
                                            <p class="text-white font-bold">--</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Botones de Acción -->
                                <div class="flex space-x-3">
                                    <a  class="flex-1 bg-gradient-to-r from-cyan-600 to-blue-700 hover:from-cyan-500 hover:to-blue-600 text-white py-3 px-4 rounded-lg text-center font-medium transition-all duration-200 hover:scale-[1.02] active:scale-95 shadow-md shadow-cyan-500/20 border-b border-cyan-400/50 text-sm flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        VER LIGA
                                    </a>
                                    <form method="POST"  class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-pink-700 hover:from-red-500 hover:to-pink-600 text-white py-3 px-4 rounded-lg font-medium transition-all duration-200 hover:scale-[1.02] active:scale-95 shadow-md shadow-pink-500/20 border-b border-pink-400/50 text-sm flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            SALIR
                                        </button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Efectos de esquina gaming -->
                            <div class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-cyan-400"></div>
                            <div class="absolute top-0 right-0 w-3 h-3 border-t-2 border-r-2 border-cyan-400"></div>
                            <div class="absolute bottom-0 left-0 w-3 h-3 border-b-2 border-l-2 border-cyan-400"></div>
                            <div class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-cyan-400"></div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-16">
                            <div class="bg-gray-900/80 border-2 border-cyan-500/30 rounded-xl p-8 max-w-md mx-auto">
                                <svg class="w-16 h-16 mx-auto text-cyan-500/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="text-xl font-medium text-cyan-200">NO TIENES LIGAS</h3>
                                <p class="text-gray-400 mt-2 mb-4">Crea una nueva liga o únete a una existente para comenzar</p>
                                <div class="flex justify-center space-x-4">
                                    <button onclick="document.getElementById('create-league-modal').classList.remove('hidden')" class="px-6 py-2 bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-lg font-medium hover:from-cyan-500 hover:to-blue-500 transition">
                                        Crear Liga
                                    </button>
                                    <button class="px-6 py-2 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-lg font-medium hover:from-green-500 hover:to-emerald-500 transition">
                                        Unirse a Liga
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforelse
                @else
                    <div class="col-span-2 text-center py-10">
                        <div class="bg-red-900/20 border-2 border-red-500/30 rounded-xl p-6 max-w-md mx-auto">
                            <svg class="w-12 h-12 mx-auto text-red-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-red-300">ERROR AL CARGAR LIGAS</h3>
                            <p class="text-gray-400 mt-1">No se pudieron cargar tus ligas. Intenta recargar la página.</p>
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
    </script>
</x-app-layout>