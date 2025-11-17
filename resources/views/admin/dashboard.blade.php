<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">Panel de Administrador</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Gestiona todas las ligas y usuarios de la plataforma.</p>
            </div>
        </div>
    </x-slot>

    <div x-data="{ ligaDeleteId: null }" class="py-8 bg-gradient-to-br from-gray-50 to-blue-50/30 dark:from-gray-900 dark:to-blue-900/20 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 space-y-6">
            @if(session('success'))
                <div class="mb-4 p-4 rounded-xl border-2 border-green-400 dark:border-green-600 bg-gradient-to-br from-green-900/80 to-green-800/90 text-green-100 shadow-lg backdrop-blur-sm">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Modal de confirmación para eliminar liga -->
            <div x-cloak x-show="ligaDeleteId" class="fixed inset-0 z-50 flex items-center justify-center px-4">
                <div class="absolute inset-0 bg-black/60" @click="ligaDeleteId = null"></div>
                <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 max-w-sm w-full p-5">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-2">Eliminar liga</h3>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-4">Se eliminará la liga y todos sus equipos y jugadores asociados. ¿Seguro que quieres continuar?</p>

                    <div class="flex justify-end gap-2 text-xs">
                        <button type="button" @click="ligaDeleteId = null" class="px-3 py-1.5 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700">Cancelar</button>

                        <form :action="ligaDeleteId ? '{{ url('admin/ligas') }}/' + ligaDeleteId : '#'" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700 shadow-sm">Sí, eliminar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tarjetas de acción -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.ligas.create') }}" class="group relative bg-gradient-to-br from-blue-500 via-blue-600 to-cyan-500 dark:from-blue-600 dark:via-blue-700 dark:to-cyan-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl text-white flex items-center justify-between transform hover:scale-[1.02] transition-all duration-300 overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-sm font-semibold uppercase tracking-wide opacity-90">Ligas</h3>
                        <p class="text-xl font-bold mt-1">Crear nueva liga</p>
                    </div>
                    <span class="text-3xl opacity-90 group-hover:scale-110 transition-transform relative z-10">＋</span>
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>

                <a href="{{ route('admin.usuarios.index') }}" class="group relative bg-gradient-to-br from-indigo-500 via-purple-600 to-violet-500 dark:from-indigo-600 dark:via-purple-700 dark:to-violet-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl text-white flex items-center justify-between transform hover:scale-[1.02] transition-all duration-300 overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-sm font-semibold uppercase tracking-wide opacity-90">Usuarios</h3>
                        <p class="text-xl font-bold mt-1">Ver usuarios</p>
                    </div>
                    <span class="text-3xl opacity-90 group-hover:scale-110 transition-transform relative z-10">👥</span>
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>

                <a href="{{ route('admin.usuarios.create') }}" class="group relative bg-gradient-to-br from-purple-500 via-purple-600 to-pink-500 dark:from-purple-600 dark:via-purple-700 dark:to-pink-600 rounded-2xl p-6 shadow-xl hover:shadow-2xl text-white flex items-center justify-between transform hover:scale-[1.02] transition-all duration-300 overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-sm font-semibold uppercase tracking-wide opacity-90">Usuarios</h3>
                        <p class="text-xl font-bold mt-1">Crear usuario</p>
                    </div>
                    <span class="text-3xl opacity-90 group-hover:scale-110 transition-transform relative z-10">★</span>
                    <div class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>
            </div>

            <!-- Buscador de ligas -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200/70 dark:border-gray-700/70 px-6 py-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                <div class="flex-shrink-0">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Buscar ligas</h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Filtra por nombre para encontrar rápidamente una liga.</p>
                </div>
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-3 w-full sm:flex-1 max-w-4xl">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 5a6 6 0 100 12 6 6 0 000-12z" />
                            </svg>
                        </span>
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $search ?? '' }}" 
                            placeholder="Buscar por nombre de liga..." 
                            class="w-full pl-10 pr-4 py-3 text-sm rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all duration-200" 
                        />
                    </div>
                    <button type="submit" class="px-6 py-3 text-sm font-semibold rounded-xl bg-gradient-to-r from-blue-500 to-cyan-500 text-white hover:from-blue-600 hover:to-cyan-600 shadow-lg hover:shadow-xl transition-all duration-200 whitespace-nowrap">
                        Buscar
                    </button>

                    @if(!empty($search))
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-3 text-sm font-semibold rounded-xl border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 shadow-sm transition-all duration-200 whitespace-nowrap">
                            Limpiar
                        </a>
                    @endif
                </form>
            </div>
            <!-- Tabla de ligas -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl border border-gray-200/70 dark:border-gray-700/70 overflow-hidden backdrop-blur-sm bg-white/95 dark:bg-gray-800/95">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900">
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Ligas registradas</h3>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-cyan-100 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-200 border border-cyan-200 dark:border-cyan-800">
                            Total: {{ $ligas->total() }}
                        </span>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Haz clic en cualquier liga para ver detalles
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Creador</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuarios</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Creada</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($ligas as $liga)
                                <tr @click="window.location='{{ route('admin.ligas.show', $liga) }}'" class="group hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 dark:hover:from-blue-900/20 dark:hover:to-cyan-900/20 transition-all duration-300 cursor-pointer border-l-4 border-l-transparent hover:border-l-blue-400 dark:hover:border-l-blue-600">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 text-sm font-medium text-gray-600 dark:text-gray-400 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            #{{ $liga->id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.ligas.show', $liga) }}" class="text-sm font-bold text-gray-900 dark:text-gray-100 group-hover:text-blue-700 dark:group-hover:text-blue-300 transition-colors">
                                            {{ $liga->nombre }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ optional($liga->creador)->nombre ?? 'Desconocido' }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            ID usuario: {{ $liga->usuario_id ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold shadow-sm
                                            {{ $liga->tipo === 'privada'
                                                ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white'
                                                : 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white' }}">
                                            {{ ucfirst($liga->tipo ?? 'n/d') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $liga->usuarios_count }}</span>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-900/50 px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-700">
                                            {{ optional($liga->created_at)->format('d/m/Y H:i') ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button type="button" @click.stop="ligaDeleteId = {{ $liga->id }}" class="px-4 py-2 text-xs font-semibold rounded-lg bg-gradient-to-r from-red-500 to-pink-500 text-white hover:from-red-600 hover:to-pink-600 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="max-w-md mx-auto">
                                            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-700">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No hay ligas registradas</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Crea la primera liga usando el botón superior</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-900 border-t border-gray-200 dark:border-gray-700">
                    {{ $ligas->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>