@extends('layouts.ligaMenu')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header con efecto gaming -->
    <div class="relative mb-8">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg shadow-lg transform -skew-y-1"></div>
        <div class="relative bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-purple-600">
                    Actividad de la Liga
                </span>
            </h1>
            <p class="text-gray-600">Historial completo de movimientos</p>
        </div>
    </div>

    <!-- Tarjeta de actividades -->
    <div class="bg-white bg-opacity-90 backdrop-blur-sm rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <!-- Filtros (opcional) -->
        <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex flex-wrap gap-3">
            <a href="{{ route('actividad', ['liga' => $liga->id]) }}" 
            class="px-3 py-1 rounded-full text-sm font-medium {{ request('tipo') ? 'bg-gray-100 text-gray-800 hover:bg-gray-200' : 'bg-blue-100 text-blue-800' }}">
            Todos
            </a>
            <a href="{{ route('actividad', ['liga' => $liga->id, 'tipo' => 'compra']) }}" 
            class="px-3 py-1 rounded-full text-sm font-medium {{ request('tipo') == 'compra' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
            Compras
            </a>
            <a href="{{ route('actividad', ['liga' => $liga->id, 'tipo' => 'venta']) }}" 
            class="px-3 py-1 rounded-full text-sm font-medium {{ request('tipo') == 'venta' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
            Ventas
            </a>
            <a href="{{ route('actividad', ['liga' => $liga->id, 'tipo' => 'evento']) }}" 
            class="px-3 py-1 rounded-full text-sm font-medium {{ request('tipo') == 'evento' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
            Eventos
            </a>
        </div>


        <!-- Lista de actividades -->
        <div class="divide-y divide-gray-200">
            @forelse($actividades as $actividad)
            <div class="p-5 hover:bg-gray-50 transition-all duration-200 activity-item">
                <div class="flex justify-between items-start">
                    <div class="flex items-start space-x-4">
                        <!-- Avatar con efecto gaming -->
                        @if($actividad->equipo)
                        <div class="relative">
                            <img src="{{ $actividad->equipo->usuario->foto_url ?? 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1745910938/fotoperfil_predeterminada.png' }}" 
                                 alt="{{ $actividad->equipo->usuario->nombre ?? 'Usuario' }}" 
                                 class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md">
                            <!-- Badge según tipo de actividad -->
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-full flex items-center justify-center 
                                        @if($actividad->tipo === 'compra') bg-green-500 @elseif($actividad->tipo === 'venta') bg-red-500 @else bg-blue-500 @endif
                                        border-2 border-white">
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
                        
                        <!-- Contenido de la actividad -->
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <p class="font-semibold text-gray-800">
                                    @switch($actividad->tipo)
                                        @case('compra')
                                            <span class="text-green-600">💰 Compra:</span>
                                            {{ $actividad->equipo?->usuario?->nombre ?? 'Usuario desconocido' }} adquirió a <span class="font-bold">{{ $actividad->jugador->nombre ?? 'un jugador' }}</span>
                                        @break
                                        
                                        @case('venta')
                                            <span class="text-red-600">💸 Venta:</span>
                                            {{ $actividad->equipo?->usuario?->nombre ?? 'Usuario desconocido' }} liberó a <span class="font-bold">{{ $actividad->jugador->nombre ?? 'un jugador' }}</span>
                                        @break
                                        
                                        @default
                                            <span class="text-blue-600">📢</span> {{ $actividad->descripcion }}
                                    @endswitch
                                </p>
                            </div>
                            
                            @if(in_array($actividad->tipo, ['compra', 'venta']))
                            <div class="mt-1 flex items-center space-x-3">
                                <span class="px-2 py-1 bg-gray-100 text-sm rounded-md">
                                     {{ number_format($actividad->precio, 0, ',', '.') }} €
                                </span>
                                @if($actividad->jugador)
                                <span class="px-2 py-1 bg-gray-100 text-sm rounded-md">
                                    🎮 {{ $actividad->jugador->posicion }}
                                </span>
                                <span class="px-2 py-1 bg-gray-100 text-sm rounded-md">
                                    ⚡ {{ $actividad->jugador->puntos }} pts
                                </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Fecha con estilo gaming -->
                    <span class="text-xs font-mono bg-gray-100 text-gray-500 px-2 py-1 rounded-md">
                        {{ $actividad->fecha_formateada }}
                    </span>
                </div>
            </div>
            @empty
            <!-- Estado vacío con diseño mejorado -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-700 mb-1">No hay actividad aún</h3>
                <p class="text-gray-500 max-w-md mx-auto">Cuando ocurran eventos en la liga, aparecerán aquí.</p>
            </div>
            @endforelse
        </div>

        <!-- Paginación con estilo gaming -->
        @if($actividades->hasPages())
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
            {{ $actividades->links() }}

        </div>
        @endif
    </div>
</div>

<style>
    /* Efectos y animaciones gaming */
    .activity-item {
        transition: all 0.3s ease;
        position: relative;
    }
    
    .activity-item:hover {
        background-color: #f8fafc;
        transform: translateX(3px);
    }
    
    .activity-item:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(to bottom, #3B82F6, #8B5CF6);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .activity-item:hover:before {
        opacity: 1;
    }
    
    /* Efecto para los badges de filtro */
    .bg-gray-100:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    /* Estilo para el título con efecto gradiente */
    .gradient-text {
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
</style>
@endsection