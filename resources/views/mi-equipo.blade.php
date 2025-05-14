@extends('layouts.ligaMenu')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Encabezado -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                Mi Equipo
            </h1>
            <h2 class="mt-3 text-2xl font-semibold text-indigo-600">
                Liga: {{ $liga->nombre }}
            </h2>
        </div>

        <!-- Valor total del equipo -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-2xl p-6 mb-12 transform transition hover:scale-[1.02] duration-300">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-semibold text-white opacity-90">Valor total del equipo</h3>
                    <p class="text-indigo-100 mt-1">Actualizado en tiempo real</p>
                </div>
                <span class="text-3xl font-bold text-white bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                    {{ isset($valorTotal) ? number_format($valorTotal, 0, ',', '.') : '0' }} €
                </span>
            </div>
        </div>

        <!-- Mapa de LoL interactivo -->
        <div class="relative mb-16 group">
            <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-blue-500 rounded-lg blur opacity-25 group-hover:opacity-50 transition duration-200"></div>
            <div class="relative bg-white rounded-lg overflow-hidden shadow-xl flex justify-center items-center p-1">
                <!-- Mapa base -->
                <img src="{{ asset('Imagenes/mapa_light.svg') }}" alt="Mapa de League of Legends" 
                    class="w-full max-w-3xl h-auto rounded-md border-2 border-white shadow-lg">
                
                <!-- Contenedores para cada posición -->
                <div class="absolute inset-0">
                    <!-- TOP -->
                    <div class="absolute top-32 left-1/4 transform -translate-x-1/2 -translate-y-1/2">
                        @include('components.posicion-selector', [
                            'posicion' => 'Top',
                            'jugadorActual' => $equipo->jugadores
                                ->where('pivot.posicion', 'Top')
                                ->where('pivot.es_titular', true)
                                ->first(),
                            'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117549/topLogo_rsvrc0.png'
                        ])
                    </div>

                    <!-- JUNGLA -->
                    <div class="absolute top-72 left-96 transform -translate-x-1/2 -translate-y-1/2">
                        @include('components.posicion-selector', [
                            'posicion' => 'Jungla',
                            'jugadorActual' => $equipo->jugadores
                                ->where('pivot.posicion', 'Jungla')
                                ->where('pivot.es_titular', true)
                                ->first(),
                            'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117550/jngLogo_azrjmn.webp'
                        ])
                    </div>
                    
                    <!-- MID -->
                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        @include('components.posicion-selector', [
                            'posicion' => 'Mid',
                            'jugadorActual' => $equipo->jugadores
                                ->where('pivot.posicion', 'Mid')
                                ->where('pivot.es_titular', true)
                                ->first(),
                            'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/midLogo_kn7okb.png'
                        ])
                    </div>
                    
                    <!-- ADC -->
                    <div class="absolute bottom-16 right-80 transform -translate-x-1/2 -translate-y-1/2">
                        @include('components.posicion-selector', [
                            'posicion' => 'Adc',
                            'jugadorActual' => $equipo->jugadores
                                ->where('pivot.posicion', 'Adc')
                                ->where('pivot.es_titular', true)
                                ->first(),
                            'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/adcLogo_idgdnc.png'
                        ])
                    </div>
                    
                    <!-- SUPPORT -->
                    <div class="absolute bottom-32 right-80 transform translate-x-1/2 -translate-y-1/2">
                        @include('components.posicion-selector', [
                            'posicion' => 'Support',
                            'jugadorActual' => $equipo->jugadores
                                ->where('pivot.posicion', 'Support')
                                ->where('pivot.es_titular', true)
                                ->first(),
                            'icono' => 'https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/supportLogo_gcrpbi.png'
                        ])
                    </div>
                </div>
            </div>
        </div>

        <!-- Jugadores del equipo -->
        <div class="mb-12">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800">Tus Jugadores</h3>
                <span class="px-4 py-2 bg-indigo-100 text-indigo-800 rounded-full text-sm font-medium">
                    {{ count($jugadores ?? []) }} jugadores
                </span>
            </div>
            
            @if(isset($jugadores) && count($jugadores) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
                @foreach($jugadores as $jugador)
                    <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                            <!-- Encabezado de la tarjeta -->
                            <div class="absolute top-3 left-3 right-3 flex justify-between items-start z-10">
                                <!-- Logo equipo real -->
                                <div class="bg-white bg-opacity-90 rounded-full p-1 shadow-md">
                                    <img src="{{ $logosEquipos[$jugador->equipo_real] ?? '' }}" 
                                         class="w-8 h-8 rounded-full object-contain">
                                </div>
                              
                                <!-- Icono posición -->
                                <div class="bg-white bg-opacity-90 rounded-full p-1.5 shadow-md flex items-center">
                                    <img src="@switch($jugador->posicion)
                                        @case('Top') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117549/topLogo_rsvrc0.png @break
                                        @case('Jungla') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117550/jngLogo_azrjmn.webp @break
                                        @case('Mid') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/midLogo_kn7okb.png @break
                                        @case('Adc') https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/adcLogo_idgdnc.png @break
                                        @default https://res.cloudinary.com/dpsvxf3qg/image/upload/v1747117431/supportLogo_gcrpbi.png
                                    @endswitch"
                                    class="w-5 h-5">
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
                                        <span class="text-indigo-200 text-sm font-medium bg-black/30 px-2 py-0.5 rounded">
                                            {{ $jugador->equipo_real }} • {{ $jugador->posicion }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                             <!-- Información del jugador -->
                            <div class="p-5">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-lg font-bold text-gray-900">
                                        {{ number_format($jugador->valor, 0, ',', '.') }} €
                                    </span>
                                </div>
                                 <!-- Barra de progreso para KDA -->
                                <div class="mb-2">
                                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                                        <span>KDA</span>
                                        <span>{{ $jugador->kda }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        <div class="bg-blue-600 h-1.5 rounded-full" 
                                             style="width: {{ min($jugador->kda * 10, 100) }}%"></div>
                                    </div>
                                </div>
                                 <!-- Estadísticas -->
                                <div class="grid grid-cols-3 gap-2 mt-4 text-center">
                                    <div class="bg-blue-50 p-2 rounded-lg">
                                        <p class="text-xs text-blue-500">CS/M</p>
                                        <p class="font-bold text-blue-700">{{ $jugador->cs }}</p>
                                    </div>
                                    <div class="bg-purple-50 p-2 rounded-lg">
                                        <p class="text-xs text-purple-500">Kills</p>
                                        <p class="font-bold text-purple-700">{{ $jugador->kills ?? '-' }}</p>
                                    </div>
                                    <div class="bg-green-50 p-2 rounded-lg">
                                        <p class="text-xs text-green-500">Asists</p>
                                        <p class="font-bold text-green-700">{{ $jugador->assists ?? '-' }}</p>
                                    </div>
                                </div>
                               <!-- Botón Añadir a mi equipo -->
                                <button onclick="asignarJugador({{ $jugador->id }}, {{ $equipo->id }}, {{ $liga->id }})"
                                    class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors duration-300 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Poner de titular
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-white rounded-xl shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No tienes jugadores en este equipo</h3>
                    <p class="mt-1 text-gray-500">Añade jugadores para comenzar a competir</p>
                </div>
            @endif
        </div>
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
</script>
@endsection