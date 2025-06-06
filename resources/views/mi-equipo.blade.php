@extends('layouts.ligaMenu')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-8 gaming-background transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="min-h-screen bg-white/80 dark:bg-gray-900/50 py-8 rounded-xl shadow-lg transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div id="flash-notification" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-1000 w-full max-w-xl px-4 hidden">
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl border-2 border-purple-500 p-5 shadow-2xl overflow-hidden gaming-notification">
                        <div class="absolute inset-0 rounded-lg border-2 border-purple-500 border-opacity-20 pointer-events-none flash-border"></div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4 flash-icon text-3xl text-purple-400"></div>
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-xl mb-1 flash-title tracking-wider text-gray-900 dark:text-white"></h3>
                                <p class="flash-message text-gray-600 dark:text-gray-300"></p>
                            </div>
                            
                            <!-- Botón de cerrar -->
                            <button class="flash-close ml-3 text-gray-400 hover:text-gray-700 dark:hover:text-white text-2xl transition-transform hover:scale-110">
                                &times;
                            </button>
                        </div>
                        
                        <!-- Barra de progreso -->
                        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-200 dark:bg-black/40">
                            <div class="flash-timer h-full bg-purple-500"></div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="mt-4 mb-6 p-4 rounded-lg border-2 border-green-400 bg-gradient-to-br from-green-100 to-white dark:from-green-900/80 dark:to-gray-900 text-green-800 dark:text-green-100 shadow-lg shadow-green-500/20 relative overflow-hidden gaming-notification">
                        <div class="absolute inset-0 border-2 border-green-300/30 rounded-lg pointer-events-none"></div>
                        <div class="flex items-start">
                            <div class="mr-3 text-green-500 dark:text-green-400 animate-pulse">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-green-700 dark:text-green-300 text-xl mb-1 font-mono tracking-wider">¡CAMBIO REALIZADO!</h4>
                                <p class="text-green-600 dark:text-green-100 text-shadow font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mt-4 mb-6 p-4 rounded-lg border-2 border-red-400 bg-gradient-to-br from-red-100 to-white dark:from-red-900/80 dark:to-gray-900 text-red-800 dark:text-red-100 shadow-lg shadow-red-500/20 relative overflow-hidden error-notification">
                        <div class="absolute inset-0 border-2 border-red-300/30 rounded-lg pointer-events-none"></div>
                        <div class="flex items-start">
                            <div class="mr-3 text-red-500 dark:text-red-400 animate-pulse">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-red-700 dark:text-red-300 text-xl mb-1 font-mono tracking-wider">¡ERROR!</h4>
                                <p class="text-red-600 dark:text-red-100 text-shadow font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Encabezado -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl sm:tracking-tight lg:text-6xl gaming-title">
                        @lang('messages.mi_equipo')
                    </h1>
                    <h2 class="mt-3 text-2xl font-semibold text-purple-600 dark:text-purple-400 neon-text">
                        @lang('messages.liga'): {{ $liga->nombre }}
                    </h2>
                </div>

                <!-- Valor total del equipo -->
                <div class="bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900 dark:to-purple-900 rounded-xl shadow-2xl p-6 mb-12 transform transition hover:scale-[1.02] duration-300 border border-indigo-300 dark:border-indigo-500/30 gaming-card">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold text-indigo-800 dark:text-indigo-200 opacity-90">@lang('messages.valor_total')</h3>
                            <p class="text-indigo-600 dark:text-indigo-300 mt-1">@lang('messages.actualizar_timepo')</p>
                        </div>
                        <span class="text-3xl font-bold text-indigo-900 dark:text-white bg-indigo-200/50 dark:bg-indigo-900/50 px-4 py-2 rounded-lg border border-indigo-300 dark:border-indigo-500/50">
                            {{ isset($valorTotal) ? number_format($valorTotal, 0, ',', '.') : '0' }} €
                        </span>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900 dark:to-purple-900 rounded-xl shadow-2xl p-6 mb-12 transform transition hover:scale-[1.02] duration-300 border border-indigo-300 dark:border-indigo-500/30 gaming-card">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-semibold text-indigo-800 dark:text-indigo-200 opacity-90">@lang('messages.presupuesto_equipo')</h3>
                            <p class="text-indigo-600 dark:text-indigo-300 mt-1">@lang('messages.actualizar_timepo')</p>
                        </div>
                        <span class="text-3xl font-bold text-indigo-900 dark:text-white bg-indigo-200/50 dark:bg-indigo-900/50 px-4 py-2 rounded-lg border border-indigo-300 dark:border-indigo-500/50">
                           {{ $equipo->presupuesto ? number_format($equipo->presupuesto, 0, ',', '.') : '0' }} €
                        </span>
                    </div>
                </div>
                

                <!-- Mapa de LoL interactivo -->
                <div class="relative mb-16 group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-400 to-blue-500 dark:from-purple-600 dark:to-blue-500 rounded-lg blur opacity-25 group-hover:opacity-50 transition  "></div>
                    <div class="relative bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl flex justify-center items-center p-1 border border-purple-300 dark:border-purple-500/30">
                        <!-- Mapa base -->
                        <img src="{{ asset('Imagenes/mapa_light.svg') }}"alt="Mapa de League of Legends" 
                            class="w-full max-w-3xl h-auto rounded-md border-2 border-gray-300 dark:border-gray-700 shadow-lg">
                                         
                        <!-- Contenedores para cada posición -->
                        <div class="absolute inset-0">
                            <!-- TOP -->
                            <div class="absolute top-32 left-1/4 transform -translate-x-1/2 -translate-y-1/2">
                               @include('components.posicion-selector', [
                                    'posicion' => 'Top',
                                    'jugadorActual' => $equipo->jugadores
                                        ->filter(fn($j) => $j->posicion === 'Top' && $j->pivot->es_titular)
                                        ->first(),
                                    'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117549/topLogo_rsvrc0.png'
                                ])
                            </div>

                            <!-- JUNGLA -->
                            <div class="absolute top-72 left-96 transform -translate-x-1/2 -translate-y-1/2">
                                @include('components.posicion-selector', [
                                    'posicion' => 'Jungla',
                                    'jugadorActual' => $equipo->jugadores
                                        ->filter(fn($j) => $j->posicion === 'Jungla' && $j->pivot->es_titular)
                                        ->first(),
                                    'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117550/jngLogo_azrjmn.webp'
                                ])
                            </div>
                            
                            <!-- MID -->
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                @include('components.posicion-selector', [
                                    'posicion' => 'Mid',
                                    'jugadorActual' => $equipo->jugadores
                                        ->filter(fn($j) => $j->posicion === 'Mid' && $j->pivot->es_titular)
                                        ->first(),
                                    'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/midLogo_kn7okb.png'
                                ])
                            </div>
                            
                            <!-- ADC -->
                            <div class="absolute bottom-16 right-80 transform -translate-x-1/2 -translate-y-1/2">
                                @include('components.posicion-selector', [
                                    'posicion' => 'Adc',
                                    'jugadorActual' => $equipo->jugadores
                                        ->filter(fn($j) => $j->posicion === 'Adc' && $j->pivot->es_titular)
                                        ->first(),
                                    'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/adcLogo_idgdnc.png'
                                ])
                            </div>
                            
                            <!-- SUPPORT -->
                            <div class="absolute bottom-32 right-80 transform translate-x-1/2 -translate-y-1/2">
                                @include('components.posicion-selector', [
                                    'posicion' => 'Support',
                                    'jugadorActual' => $equipo->jugadores
                                        ->filter(fn($j) => $j->posicion === 'Support' && $j->pivot->es_titular)
                                        ->first(),
                                    'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/supportLogo_gcrpbi.png'
                                ])
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Conteo de titulares -->
                <div class="mb-12 flex justify-end">
                    <div class="bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900 dark:to-purple-900 rounded-xl shadow-lg p-3 transform transition hover:scale-[1.05] duration-300 inline-flex justify-center items-center animate-pulse max-w-xs border border-indigo-300 dark:border-indigo-500/50">
                        <span class="text-indigo-900 dark:text-white text-lg font-semibold">
                            @lang('messages.titulares') {{ $titulares->count() }} / 5
                        </span>
                    </div>
                </div>

                <!-- Jugadores del equipo -->
                <div class="mb-12">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">@lang('messages.tus-jugadores')</h3>
                        <span class="px-4 py-2 bg-indigo-200/50 dark:bg-indigo-900/50 text-indigo-800 dark:text-indigo-200 rounded-full text-sm font-medium border border-indigo-300 dark:border-indigo-500/30">
                            {{ count($jugadoresEquipo ?? []) }} @lang('messages.jugadores')
                        </span>
                    </div>
                    
                    @if(isset($jugadoresEquipo) && count($jugadoresEquipo) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
                        @foreach($jugadoresEquipo as $jugador)
                            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700 gaming-card">
                                <!-- Encabezado de la tarjeta -->
                                <div class="absolute top-3 left-3 right-3 flex justify-between items-start z-10">
                                    <!-- Logo equipo real -->
                                    <div class="bg-white dark:bg-gray-700 rounded-full p-1 shadow-md border border-gray-200 dark:border-gray-700">
                                        <img src="{{ $logosEquipos[$jugador->equipo_real] ?? '' }}" 
                                            class="w-8 h-8 rounded-full object-contain">
                                    </div>
                                
                                    <!-- Icono posición -->
                                    <div class="bg-white dark:bg-gray-700 rounded-full p-1.5 shadow-md flex items-center border border-gray-200 dark:border-gray-700">
                                        <img src="@switch($jugador->posicion)
                                            @case('Top') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117549/topLogo_rsvrc0.png @break
                                            @case('Jungla') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117550/jngLogo_azrjmn.webp @break
                                            @case('Mid') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/midLogo_kn7okb.png @break
                                            @case('Adc') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/adcLogo_idgdnc.png @break
                                            @default https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/supportLogo_gcrpbi.png
                                        @endswitch"
                                        class="w-6 h-6">
                                    </div>
                                </div>
                                
                                <!-- Imagen del jugador -->
                                <div class="h-40 overflow-hidden relative">
                                    <img src="{{ $jugador->imagen_url }}"  
                                        class="w-full h-full object-cover transition duration-500 hover:scale-110">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-4 w-full">
                                        <h4 class="font-bold text-xl text-white drop-shadow-md">{{ $jugador->nombre }}</h4>
                                        <div class="flex items-center mt-1">
                                            <span class="text-indigo-200 text-sm font-medium bg-black/30 px-2 py-0.5 rounded border border-indigo-300 dark:border-indigo-500/30">
                                                {{ $jugador->equipo_real }} • {{ $jugador->posicion }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Información del jugador -->
                                <div class="p-5">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ number_format($jugador->valor, 0, ',', '.') }} €
                                        </span>
                                    </div>
                                    
                                    <!-- Barra de progreso para KDA -->
                                    @php
                                        $kills = $jugador->estadisticas->kills ?? 0;
                                        $muertes = $jugador->estadisticas->muertes ?? 0;
                                        $asistencias = $jugador->estadisticas->asistencias ?? 0;
                                        $kda = number_format(($kills + $asistencias) / ($muertes ?: 1), 2);
                                        $kdaPercentage = min(($kills + $asistencias) / ($muertes ?: 1) * 10, 100);
                                    @endphp

                                    <div class="mb-2">
                                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                            <span>KDA</span>
                                            <span>{{ $kda }}</span>
                                        </div>
                                       <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                            <div 
                                                class="bg-[#00bfff] h-1.5 transition-all duration-300 ease-in-out shadow-[0_0_10px_#00bfff]" 
                                                style="width: {{ $kdaPercentage }}%">
                                            </div>
                                        </div>
                                    </div>
                                 
                                    <!-- Estadísticas -->
                                    <div class="grid grid-cols-3 gap-2 mt-4 text-center">
                                        <div class="bg-blue-100/50 dark:bg-blue-900/50 p-2 rounded-lg border border-blue-200 dark:border-blue-500/30">
                                            <p class="text-xs text-blue-800 dark:text-blue-300">Kills</p>
                                            <p class="font-bold text-blue-700 dark:text-blue-200">{{ $jugador->estadisticas->kills }}</p>
                                        </div>
                                        <div class="bg-purple-100/50 dark:bg-purple-900/50 p-2 rounded-lg border border-purple-200 dark:border-purple-500/30">
                                            <p class="text-xs text-purple-800 dark:text-purple-300">Deads</p>
                                            <p class="font-bold text-purple-700 dark:text-purple-200">{{ $jugador->estadisticas->muertes ?? '-' }}</p>
                                        </div>
                                        <div class="bg-green-100/50 dark:bg-green-900/50 p-2 rounded-lg border border-green-200 dark:border-green-500/30">
                                            <p class="text-xs text-green-800 dark:text-green-300">Asist</p>
                                            <p class="font-bold text-green-700 dark:text-green-200">{{ $jugador->estadisticas->asistencias ?? '-' }}</p>
                                        </div>
                                    </div>

                                    @php
                                        $esTitular = $jugador->pivot->es_titular ?? false;
                                        $valorVenta = $jugador->valor * 0.9;
                                    @endphp

                                    <!-- Botón de Titularidad -->
                                    <button onclick="gestionarTitularidad({{ $jugador->id }}, {{ $equipo->id }}, {{ $liga->id }}, {{ $esTitular ? 'true' : 'false' }})"
                                        class="mt-3 w-full {{ $esTitular ? 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-400 hover:to-red-500 dark:from-red-700 dark:to-red-900 dark:hover:from-red-600 dark:hover:to-red-800' : 'bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-400 hover:to-purple-500 dark:from-indigo-700 dark:to-purple-900 dark:hover:from-indigo-600 dark:hover:to-purple-800' }} text-white py-2 px-4 rounded-lg transition-all duration-300 flex items-center justify-center border {{ $esTitular ? 'border-red-300 dark:border-red-500/50' : 'border-indigo-300 dark:border-indigo-500/50' }} shadow-lg hover:shadow-xl gaming-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            @if($esTitular)
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            @endif
                                        </svg>
                                        <span class="font-bold tracking-wide">{{ $esTitular ? __('messages.banquillo') : __('messages.titular') }}</span>
                                    </button>

                                    <!-- Botón de Venta -->
                                    <button onclick="venderJugador({{ $jugador->id }}, {{ $equipo->id }}, {{ $liga->id }}, {{ $valorVenta }}, '{{ $jugador->nombre }}')"
                                        class="mt-2 w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 dark:from-amber-600 dark:to-amber-800 dark:hover:from-amber-500 dark:hover:to-amber-700 text-white py-2 px-4 rounded-lg transition-all duration-300 flex items-center justify-center border border-amber-300 dark:border-amber-500/50 shadow-lg hover:shadow-xl gaming-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="font-bold tracking-wide">@lang('messages.vender') </span>
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        <!-- Modal de confirmación de venta -->
                        <div id="venta-modal" class="fixed inset-0 bg-black/50 dark:bg-black/70 flex items-center justify-center z-50 hidden">
                            <div class="bg-white dark:bg-gray-900 border-2 border-amber-400 dark:border-amber-500 rounded-xl p-6 max-w-md w-full mx-4 gaming-modal">
                                <div class="text-center">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2" id="venta-jugador-nombre"></h3>
                                    <p class="text-amber-500 dark:text-amber-400 text-lg mb-4">@lang('messages.ganaras'): <span id="venta-jugador-precio" class="font-bold"></span> €</p>
                                    <p class="text-gray-600 dark:text-gray-300 mb-6">@lang('messages.vender_jugador')</p>
                                    
                                    <div class="flex justify-center space-x-4">
                                        <button onclick="document.getElementById('venta-modal').classList.add('hidden')" 
                                                class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white px-6 py-2 rounded-lg border border-gray-300 dark:border-gray-600 transition gaming-button">
                                            @lang('messages.cancelar')
                                        </button>
                                        <button id="confirmar-venta-btn" 
                                                class="bg-amber-500 hover:bg-amber-400 dark:bg-amber-600 dark:hover:bg-amber-500 text-white px-6 py-2 rounded-lg border border-amber-400 dark:border-amber-500 transition gaming-button">
                                            @lang('messages.confirmar_venta')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                        <div class="text-center py-12 bg-gray-100 dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-800 dark:text-gray-200">No tienes jugadores en este equipo</h3>
                            <p class="mt-1 text-gray-600 dark:text-gray-400">Añade jugadores para comenzar a competir</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <form id="titularidad-form" method="POST" action="" style="display: none;">
            @csrf
        </form>

        <style>
            .gaming-background {
                background-color: #f9fafb;
                background-image: 
                    radial-gradient(at 20% 30%, rgba(209, 213, 219, 0.2) 0, transparent 50%),
                    radial-gradient(at 80% 70%, rgba(199, 210, 254, 0.1) 0, transparent 50%);
            }
            
            .dark .gaming-background {
                background-color: #0f172a;
                background-image: 
                    radial-gradient(at 20% 30%, rgba(55, 65, 81, 0.2) 0, transparent 50%),
                    radial-gradient(at 80% 70%, rgba(79, 70, 229, 0.1) 0, transparent 50%);
            }
            
            .gaming-title {
                background: linear-gradient(90deg, #6366f1, #8b5cf6, #a855f7);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                text-shadow: 0 0 10px rgba(99, 102, 241, 0.3);
            }
            
            .neon-text {
                text-shadow: 0 0 5px rgba(139, 92, 246, 0.5), 0 0 10px rgba(139, 92, 246, 0.3);
                animation: neon-pulse 2s infinite alternate;
            }
            
            @keyframes neon-pulse {
                from {
                    text-shadow: 0 0 5px rgba(139, 92, 246, 0.5), 0 0 10px rgba(139, 92, 246, 0.3);
                }
                to {
                    text-shadow: 0 0 10px rgba(139, 92, 246, 0.7), 0 0 20px rgba(139, 92, 246, 0.5);
                }
            }
            
            .gaming-card {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            
            .gaming-card:hover {
                box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.2);
                transform: translateY(-5px);
            }
            
            .gaming-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 2px;
                background: linear-gradient(90deg, transparent, rgba(99, 102, 241, 0.6), transparent);
                opacity: 0;
                transition: opacity 0.3s ease;
            }
            
            .gaming-card:hover::before {
                opacity: 1;
            }
            
            .gaming-button {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }
            
            .gaming-button:hover {
                transform: translateY(-2px);
            }
            
            .gaming-button::after {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(
                    to bottom right,
                    rgba(255, 255, 255, 0) 45%,
                    rgba(255, 255, 255, 0.1) 50%,
                    rgba(255, 255, 255, 0) 55%
                );
                transform: rotate(30deg);
                transition: all 0.3s ease;
            }
            
            .gaming-button:hover::after {
                left: 100%;
            }
            
            .gaming-notification {
                animation: pixelGlow 2s infinite;
                border-image: linear-gradient(45deg, #6366f1, #8b5cf6) 1;
            }
            
            @keyframes pixelGlow {
                0% { box-shadow: 0 0 5px rgba(99, 102, 241, 0.5); }
                50% { box-shadow: 0 0 20px rgba(99, 102, 241, 0.8); }
                100% { box-shadow: 0 0 5px rgba(99, 102, 241, 0.5); }
            }
            
            .error-notification {
                animation: errorPulse 1.5s infinite;
            }
            
            @keyframes errorPulse {
                0% { opacity: 0.8; }
                50% { opacity: 1; }
                100% { opacity: 0.8; }
            }
            
           .gaming-modal {
                position: relative; 
                box-shadow: 0 0 30px rgba(245, 158, 11, 0.3);
                border-radius: 1rem; 
                overflow: hidden; 
                z-index: 1000; 
            }

            .gaming-modal::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                border-radius: inherit;
                padding: 2px; /* crea un pequeño borde */
                background: linear-gradient(45deg, #f59e0b, #f97316, #f59e0b);
                z-index: -1;
                mask: 
                linear-gradient(#fff 0 0) content-box, 
                linear-gradient(#fff 0 0);
                mask-composite: exclude;
                -webkit-mask-composite: destination-out;
                animation: borderRotate 4s linear infinite;
                pointer-events: none;
            }
            @keyframes borderRotate {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }


        </style>
    </div>
</div>
<script>
    function asignarJugador(jugadorId, equipoId, ligaId) {
        const url = `/liga/${ligaId}/equipo/${equipoId}/jugador/${jugadorId}/asignar`;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            } else {
                throw new Error(data.error || 'Error al asignar jugador');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(error.message || 'Ocurrió un error');
        });
    }

    function gestionarTitularidad(jugadorId, equipoId, ligaId, esTitular) {
        const url = `/liga/${ligaId}/equipo/${equipoId}/jugador/${jugadorId}/asignar`;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                sessionStorage.setItem('flashMessage', JSON.stringify({
                    success: data.message || (esTitular ? 'Jugador movido al banquillo' : 'Jugador asignado como titular')
                }));
                location.reload();
            } else {
                sessionStorage.setItem('flashError', JSON.stringify({
                    error: data.error || 'Error al actualizar titularidad'
                }));
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            sessionStorage.setItem('flashError', JSON.stringify({
                error: 'Error al conectar con el servidor'
            }));
            location.reload();
        });
    }

    function venderJugador(jugadorId, equipoId, ligaId, valorVenta, nombreJugador) {
        document.getElementById('venta-jugador-nombre').textContent = nombreJugador;
        document.getElementById('venta-jugador-precio').textContent = valorVenta.toLocaleString('es-ES');
        
        const modal = document.getElementById('venta-modal');
        modal.classList.remove('hidden');
        
        // Configurar el botón de confirmación
        const confirmarBtn = document.getElementById('confirmar-venta-btn');
        confirmarBtn.onclick = async function() {
            try {
                // Obtener puntos del jugador desde el servidor
                const response = await fetch(`/liga/${ligaId}/equipo/${equipoId}/jugador/${jugadorId}/puntos`);
                const data = await response.json();
                
                if (data.success) {
                    realizarVenta(jugadorId, equipoId, ligaId, valorVenta, data.puntos);
                } else {
                    throw new Error(data.error || 'Error al obtener puntos del jugador');
                }
            } catch (error) {
                console.error('Error:', error);
                sessionStorage.setItem('flashError', JSON.stringify({
                    error: error.message
                }));
                location.reload();
            }
            modal.classList.add('hidden');
        };
    }

    function realizarVenta(jugadorId, equipoId, ligaId, valorVenta, puntosJugador) {
        fetch(`/liga/${ligaId}/equipo/${equipoId}/jugador/${jugadorId}/vender`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                jugador_id: jugadorId,
                valor_venta: valorVenta,
                puntos_jugador: puntosJugador
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                sessionStorage.setItem('flashMessage', JSON.stringify({
                    success: data.message
                }));
            } else {
                sessionStorage.setItem('flashError', JSON.stringify({
                    error: data.error || 'Error al vender el jugador'
                }));
            }
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            sessionStorage.setItem('flashError', JSON.stringify({
                error: 'Error al conectar con el servidor'
            }));
            location.reload();
        });
    }

    // Mostrar mensajes flash al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        const showFlashNotification = (type, title, message) => {
            const notification = document.getElementById('flash-notification');
            const icon = notification.querySelector('.flash-icon');
            const notificationTitle = notification.querySelector('.flash-title');
            const notificationMessage = notification.querySelector('.flash-message');
            const closeBtn = notification.querySelector('.flash-close');
            const timerBar = notification.querySelector('.flash-timer');
            const border = notification.querySelector('.flash-border');
            
            // Resetear clases
            notification.className = 'fixed top-6 left-1/2 transform -translate-x-1/2 z-1000 w-full max-w-xl px-4';
            border.className = 'absolute inset-0 rounded-lg border-2 border-opacity-20 pointer-events-none flash-border';
            
            // Configurar según el tipo
            if (type === 'success') {
                // Estilo éxito
                notification.classList.add('text-green-100');
                border.classList.add('border-green-500', 'animate-pulse');
                icon.innerHTML = '🎯';
                icon.classList.add('text-green-400', 'animate-bounce');
                timerBar.classList.add('bg-gradient-to-r', 'from-green-500', 'to-cyan-500');
                title = '¡OPERACIÓN EXITOSA!';
            } else {
                // Estilo error
                notification.classList.add('text-red-100');
                border.classList.add('border-red-500', 'animate-pulse');
                icon.innerHTML = '⚡';
                icon.classList.add('text-red-400', 'animate-pulse');
                timerBar.classList.add('bg-gradient-to-r', 'from-red-500', 'to-amber-500');
                title = '¡ALERTA!';
            }
            
            // Configurar contenido
            notificationTitle.textContent = title;
            notificationMessage.textContent = message;
            notification.classList.remove('hidden');
            
            // Animación de la barra de tiempo
            timerBar.style.transition = 'none';
            timerBar.style.width = '100%';
            setTimeout(() => {
                timerBar.style.transition = 'width 5s linear';
                timerBar.style.width = '0%';
            }, 50);
            
            // Efecto de aparición
            notification.style.opacity = '0';
            notification.style.transform = 'translate(-50%, -20px)';
            notification.style.transition = 'all 0.3s ease-out';
            
            setTimeout(() => {
                notification.style.opacity = '1';
                notification.style.transform = 'translate(-50%, 0)';
            }, 10);
            
            // Cerrar manualmente
            closeBtn.addEventListener('click', hideNotification);
            
            // Cerrar automáticamente después de 5 segundos
            const autoClose = setTimeout(hideNotification, 5000);
            
            function hideNotification() {
                clearTimeout(autoClose);
                notification.style.opacity = '0';
                notification.style.transform = 'translate(-50%, -20px)';
                
                setTimeout(() => {
                    notification.classList.add('hidden');
                }, 300);
            }
        };
        
        // Comprobar mensajes flash almacenados
        const flashMessage = sessionStorage.getItem('flashMessage');
        const flashError = sessionStorage.getItem('flashError');
        
        if (flashMessage) {
            const data = JSON.parse(flashMessage);
            showFlashNotification('success', '', data.success);
            sessionStorage.removeItem('flashMessage');
        }
        
        if (flashError) {
            const data = JSON.parse(flashError);
            showFlashNotification('error', '', data.error);
            sessionStorage.removeItem('flashError');
        }
    });

</script>
@endsection