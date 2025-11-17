<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Liga: {{ $liga->nombre }}</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Detalles y usuarios de la liga.</p>
            </div>

            <div class="space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-sm font-semibold text-gray-800 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200">Panel admin</a>
                <a href="{{ route('admin.ligas.edit', $liga) }}" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition-all duration-200 shadow-lg hover:shadow-blue-500/25">Editar</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 space-y-6">
            @if(session('success'))
                <div class="mb-4 p-4 rounded-xl border-2 border-green-400 dark:border-green-600 bg-gradient-to-br from-green-900/80 to-green-800/90 text-green-100 shadow-lg backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Información de la liga -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200/70 dark:border-gray-700/70 p-6 backdrop-blur-sm bg-white/95 dark:bg-gray-800/95">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <img src="{{ $liga->logo_url }}" alt="Logo" class="w-20 h-20 rounded-full object-cover border-2 border-cyan-400 dark:border-cyan-500 shadow-lg">
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ $liga->nombre }}</h3>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-500 dark:bg-blue-600 text-white border border-blue-600 dark:border-blue-500">
                                    {{ ucfirst($liga->tipo) }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 dark:bg-purple-700 text-purple-700 dark:text-purple-50 border border-purple-200 dark:border-purple-500">
                                    {{ optional($liga->creador)->nombre ?? 'Desconocido' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="mb-4">
                            <p class="font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Descripción
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                                {{ $liga->descripcion ?: 'Sin descripción.' }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-4 text-xs text-gray-500 dark:text-gray-400">
                            <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-900/50 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Creada: {{ optional($liga->created_at)->format('d/m/Y H:i') ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-900/50 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Actualizada: {{ optional($liga->updated_at)->format('d/m/Y H:i') ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de usuarios y estadísticas -->
            <div x-data="{ openId: null, equipoDeleteId: null }" class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200/70 dark:border-gray-700/70 overflow-hidden backdrop-blur-sm bg-white/95 dark:bg-gray-800/95">
                <!-- Modal de confirmación para quitar usuario/equipo -->
                <div x-cloak x-show="equipoDeleteId" class="fixed inset-0 z-50 flex items-center justify-center px-4">
                    <div class="absolute inset-0 bg-black/60" @click="equipoDeleteId = null"></div>
                    <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 max-w-sm w-full p-5">
                        <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-2">Quitar usuario de la liga</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-4">Se eliminará su equipo y todos sus jugadores de esta liga. ¿Seguro que quieres continuar?</p>

                        <div class="flex justify-end gap-2 text-xs">
                            <button type="button" @click="equipoDeleteId = null" class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">Cancelar</button>

                            <form :action="equipoDeleteId ? '{{ url('admin/ligas/'.$liga->id.'/usuarios') }}/' + equipoDeleteId : '#'" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700 shadow-sm">Sí, quitar</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-3">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Usuarios en la liga</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-200 border border-cyan-200 dark:border-cyan-800">
                            {{ $liga->equipos->count() }} equipos
                        </span>
                    </div>

                    <!-- Formulario para añadir usuarios a la liga -->
                    <form action="{{ route('admin.ligas.usuarios.add', $liga) }}" method="POST" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                        @csrf
                        <select name="usuario_id" class="w-full sm:w-56 text-xs rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            <option value="" disabled selected>Seleccionar usuario para añadir</option>
                            @foreach($usuariosDisponibles as $usuario)
                                <option value="{{ $usuario->id }}">{{ $usuario->nombre }} (ID: {{ $usuario->id }})</option>
                            @endforeach
                        </select>
                        <button type="submit" class="inline-flex items-center justify-center px-3 py-2 text-xs font-semibold rounded-lg bg-gradient-to-r from-emerald-500 to-emerald-600 text-white shadow-sm hover:shadow-md hover:from-emerald-600 hover:to-emerald-700 transition-all duration-200">
                            Añadir usuario
                        </button>
                    </form>
                </div>

                @if($liga->equipos->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <div class="max-w-md mx-auto">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-700">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No hay equipos en esta liga</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Los equipos aparecerán aquí cuando se unan a la liga.</p>
                        </div>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-4 text-left">Usuario</th>
                                    <th class="px-6 py-4 text-center">Posición</th>
                                    <th class="px-6 py-4 text-right">Presupuesto</th>
                                    <th class="px-6 py-4 text-right">Puntos</th>
                                    <th class="px-6 py-4 text-right">Jugadores</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($liga->equipos as $equipo)
                                <tr 
                                    @click="openId = openId === {{ $equipo->id }} ? null : {{ $equipo->id }}" 
                                    class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 dark:hover:from-blue-900/20 dark:hover:to-cyan-900/20 transition-all duration-300 cursor-pointer border-l-4 border-l-transparent hover:border-l-cyan-400 dark:hover:border-l-cyan-600"
                                >
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @php
                                                $usuario = $equipo->usuario;
                                                $foto = $usuario && $usuario->foto_url ? $usuario->foto_url : asset('Imagenes/LecFantasyLogoV3-TextoBlanco.PNG');
                                            @endphp
                                            <div class="relative">
                                                <img src="{{ $foto }}" alt="Foto usuario" class="w-10 h-10 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-lg group-hover:border-cyan-200 dark:group-hover:border-cyan-800 transition-colors">
                                                <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-white dark:border-gray-800 shadow-sm"></div>
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-semibold text-gray-900 dark:text-gray-100 group-hover:text-cyan-700 dark:group-hover:text-cyan-300 transition-colors">
                                                    {{ optional($usuario)->nombre ?? 'Usuario eliminado' }}
                                                </h4>
                                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                                    <span>ID: {{ $equipo->usuario_id }}</span>
                                                    <span class="w-1 h-1 bg-gray-300 dark:bg-gray-600 rounded-full"></span>
                                                    <span>Equipo: {{ $equipo->id }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if(!is_null($equipo->posicion))
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-gradient-to-br from-yellow-400 to-orange-500 text-white shadow-lg transform group-hover:scale-110 transition-transform">
                                                {{ $equipo->posicion }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-medium bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 border border-gray-300 dark:border-gray-600">
                                                -
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex flex-col items-end">
                                            <span class="font-bold text-gray-900 dark:text-gray-100 text-sm group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                                {{ number_format($equipo->presupuesto ?? 0, 0, ',', '.') }}
                                            </span>
                                            <span class="text-xs text-green-600 dark:text-green-400 font-semibold">€</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex flex-col items-end">
                                            <span class="font-bold text-gray-900 dark:text-gray-100 text-sm group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                {{ $equipo->puntos ?? 0 }}
                                            </span>
                                            <span class="text-xs text-blue-600 dark:text-blue-400 font-semibold">pts</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-3">
                                            <div class="flex items-center gap-1">
                                                <span class="font-bold text-gray-900 dark:text-gray-100 text-sm group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                                    {{ $equipo->jugadores->count() }}
                                                </span>
                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-cyan-500 transition-colors transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>

                                            <!-- Botón para quitar usuario/equipo de la liga -->
                                            <button type="button" @click.stop="equipoDeleteId = {{ $equipo->id }}" class="px-3 py-1.5 text-[11px] font-semibold rounded-lg bg-red-600 text-white hover:bg-red-700 shadow-sm">
                                                Quitar
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Detalle de jugadores como fila desplegable -->
                                <tr x-cloak x-show="openId === {{ $equipo->id }}" x-transition>
                                    <td colspan="5" class="px-6 pb-4 pt-4 bg-gray-50 dark:bg-gray-900">

                                        @if($equipo->jugadores->isEmpty())
                                            <div class="text-center py-6">
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Este equipo no tiene jugadores asignados.</p>
                                            </div>
                                        @else
                                            <!-- Stats del equipo -->
                                            <div class="mb-4 grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                                                <div class="bg-white dark:bg-gray-700 rounded-xl p-3 shadow-sm border border-gray-200 dark:border-gray-600">

                                                    <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $equipo->puntos ?? 0 }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Puntos totales</div>
                                                </div>
                                                <div class="bg-white dark:bg-gray-700 rounded-xl p-3 shadow-sm border border-gray-200 dark:border-gray-600">
                                                    <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ number_format($equipo->presupuesto ?? 0, 0, ',', '.') }}€</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Presupuesto</div>
                                                </div>
                                                <div class="bg-white dark:bg-gray-700 rounded-xl p-3 shadow-sm border border-gray-200 dark:border-gray-600">
                                                    <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $equipo->jugadores->count() }}</div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Jugadores</div>
                                                </div>
                                            </div>

                                            <!-- Lista de jugadores -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                                @foreach($equipo->jugadores as $jugador)
                                                    @php
                                                        $fotoJugador = $jugador->imagen_url ?? 'https://via.placeholder.com/64x64?text=JG';
                                                        $posicionColors = [
                                                            'TOP' => 'from-red-500 to-pink-600',
                                                            'JUNGLE' => 'from-green-500 to-emerald-600', 
                                                            'MID' => 'from-blue-500 to-cyan-600',
                                                            'ADC' => 'from-yellow-500 to-orange-600',
                                                            'SUPPORT' => 'from-purple-500 to-indigo-600'
                                                        ];
                                                        $colorClass = $posicionColors[$jugador->posicion] ?? 'from-gray-500 to-gray-600';
                                                    @endphp
                                                    <div class="bg-gray-50 dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm hover:shadow-md transition-all duration-200 hover:border-cyan-300 dark:hover:border-cyan-500 group">

                                                        <div class="flex items-center gap-4">
                                                            <div>
                                                                <img src="{{ $fotoJugador }}" alt="{{ $jugador->nombre }}" class="w-14 h-14 rounded-full object-cover border-2 border-white dark:border-gray-600 shadow-lg group-hover:scale-105 transition-transform">
                                                            </div>

                                                            <div class="flex-1">
                                                                <div class="flex items-start justify-between">
                                                                    <div>
                                                                        <h5 class="font-bold text-gray-900 dark:text-gray-100 text-sm">{{ $jugador->nombre }}</h5>
                                                                        <span class="inline-block px-2 py-1 rounded-full text-[10px] font-bold bg-gradient-to-r {{ $colorClass }} text-white uppercase mt-1 shadow-sm">
                                                                            {{ $jugador->posicion }}
                                                                        </span>
                                                                    </div>
                                                                    <div class="text-right">
                                                                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $jugador->puntos ?? 0 }}</div>
                                                                        <div class="text-xs text-green-600 dark:text-green-400 font-semibold">{{ number_format($jugador->valor ?? 0, 0, ',', '.') }}€</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>