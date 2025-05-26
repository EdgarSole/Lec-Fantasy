@extends('layouts.ligaMenu')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header con efecto gaming mejorado - Modo oscuro -->
    <div class="relative mb-8 group">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg transform -skew-y-1 group-hover:-skew-y-2 transition-all duration-300"></div>
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-300">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-2">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600">
                    @lang('messages.actividad_liga')
                </span>
            </h1>
            <p class="text-gray-600 dark:text-gray-300"> @lang('messages.historial_completo')</p>
        </div>
    </div>

    <!-- Tarjeta de actividades - Modo oscuro -->
    <div class="bg-white dark:bg-gray-800 bg-opacity-90 dark:bg-opacity-90 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-xl transition-shadow duration-300">
        <!-- Filtros mejorados - Modo oscuro -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-3 border-b border-gray-200 dark:border-gray-600 flex flex-wrap gap-3">
            @php
                $currentFilter = request('tipo');
            @endphp
            
            <a href="{{ route('actividad', ['liga' => $liga->id]) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium transition-all   {{ !$currentFilter ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 scale-105' : 'bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-500 hover:scale-105' }}">
               @lang('messages.todos')
            </a>
            
            <a href="{{ route('actividad', ['liga' => $liga->id, 'tipo' => 'compra']) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium transition-all   {{ $currentFilter == 'compra' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 scale-105' : 'bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-500 hover:scale-105' }}">
               <span class="flex items-center gap-1">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                       <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                   </svg>
                   @lang('messages.compras')
               </span>
            </a>
            
            <a href="{{ route('actividad', ['liga' => $liga->id, 'tipo' => 'venta']) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium transition-all   {{ $currentFilter == 'venta' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 scale-105' : 'bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-500 hover:scale-105' }}">
               <span class="flex items-center gap-1">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                       <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                   </svg>
                   @lang('messages.ventas')
               </span>
            </a>
            
            <a href="{{ route('actividad', ['liga' => $liga->id, 'tipo' => 'evento']) }}" 
               class="px-3 py-1 rounded-full text-sm font-medium transition-all   {{ $currentFilter == 'evento' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 scale-105' : 'bg-gray-100 dark:bg-gray-600 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-500 hover:scale-105' }}">
               <span class="flex items-center gap-1">
                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                       <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                   </svg>
                   @lang('messages.eventos')
               </span>
            </a>
        </div>

        <!-- Lista de actividades - Modo oscuro -->
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($actividades as $actividad)
            <div class="p-5 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all   activity-item group">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-start space-x-4 w-full">
                        @if($actividad->equipo)
                        <div class="relative group">
                            <img src="{{ $actividad->equipo->usuario->foto_url ?? 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1745910938/fotoperfil_predeterminada.png' }}" 
                                 alt="{{ $actividad->equipo->usuario->nombre ?? 'Usuario' }}" 
                                 class="w-12 h-12 rounded-full object-cover border-2 border-white dark:border-gray-800 shadow-md group-hover:border-blue-300 transition-all duration-300">
                            <!-- Badge según tipo de actividad -->
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full flex items-center justify-center 
                                        @if($actividad->tipo === 'compra') bg-green-500 @elseif($actividad->tipo === 'venta') bg-red-500 @else bg-blue-500 @endif
                                        border-2 border-white dark:border-gray-800 transform group-hover:scale-110 transition-transform  ">
                                @if($actividad->tipo === 'compra')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                @elseif($actividad->tipo === 'venta')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                                </svg>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <!-- Contenido de la actividad mejorado - Modo oscuro -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                                <p class="font-semibold text-gray-800 dark:text-gray-200 truncate">
                                    @switch($actividad->tipo)
                                        @case('compra')
                                            <span class="text-green-600 dark:text-green-400">💰 @lang('messages.compra'):</span>
                                                {{ $actividad->equipo?->usuario?->nombre ?? __('messages.usuario_desconocido') }}
                                                @lang('messages.compro_a')
                                            <span class="font-bold">{{ $actividad->jugador->nombre ?? __('messages.un_jugador') }}</span>
                                        @break
                                        
                                        @case('venta')
                                            <span class="text-red-600 dark:text-red-400">💸 @lang('messages.venta'):</span>
                                            {{ $actividad->equipo?->usuario?->nombre ?? __('messages.usuario_desconocido') }}
                                            @lang('messages.vendio_a')
                                            <span class="font-bold">{{ $actividad->jugador->nombre ?? __('messages.un_jugador') }}</span>
                                            @break

                                        @default
                                            <span class="text-blue-600 dark:text-blue-400">📢 @lang('messages.evento'):</span> {{ $actividad->descripcion }}
                                    @endswitch
                                </p>
                            </div>
                            
                            @if(in_array($actividad->tipo, ['compra', 'venta']))
                            <div class="mt-2 flex flex-wrap gap-2">
                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-sm rounded-md flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ number_format($actividad->precio, 0, ',', '.') }} €
                                </span>
                                @if($actividad->jugador)
                                <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-sm rounded-md flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                    {{ $actividad->jugador->puntos }} pts
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Fecha con estilo gaming mejorado - Modo oscuro -->
                    <span class="text-xs font-mono bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 px-2 py-1 rounded-md whitespace-nowrap ml-auto md:ml-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $actividad->fecha_formateada }}
                    </span>
                </div>
            </div>
            @empty
            <!-- Estado vacío con diseño mejorado - Modo oscuro -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300 mb-1"> @lang('messages.no_actividad')</h3>
                <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto"> @lang('messages.cuando_ocurra')</p>
                <div class="mt-4">
                    <a href="{{ route('mercado', ['liga' => $liga->id]) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors  ">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                        </svg>
                         @lang('messages.ir_mercado')
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if ($actividades->hasPages())
            <div class="bg-gray-50 dark:bg-gray-700 px-6 py-3 border-t border-gray-200 dark:border-gray-600">
                {{ $actividades->onEachSide(1)->links() }} 
            </div>
        @endif
    </div>
</div>

<style>
    .activity-item {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .activity-item:hover {
        background-color: #f8fafc;
        transform: translateX(5px);
    }
    
    .dark .activity-item:hover {
        background-color: #1e293b;
    }
    
    .activity-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #3B82F6, #8B5CF6);
        opacity: 0;
        transition: opacity 0.3s ease, transform 0.3s ease;
        transform: scaleY(0);
        transform-origin: center top;
    }
    
    .activity-item:hover::before {
        opacity: 1;
        transform: scaleY(1);
    }
    
    /* Efecto para los badges de filtro mejorado */
    .bg-gray-100:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    
    .dark .bg-gray-600:hover {
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    }
    
    /* Estilo para el título con efecto gradiente */
    .gradient-text {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    /* Animación para el hover del header */
    .group:hover .group-hover\:-skew-y-2 {
        --tw-skew-y: -2deg;
    }
</style>

<script>
    // Pequeña animación para los items al cargar
    document.addEventListener('DOMContentLoaded', () => {
        const items = document.querySelectorAll('.activity-item');
        items.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-10px)';
            item.style.transition = `all 0.3s ease ${index * 0.05}s`;
            
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 100);
        });
    });
</script>
@endsection