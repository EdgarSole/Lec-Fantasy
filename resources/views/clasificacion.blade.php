@extends('layouts.ligaMenu')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <!-- Encabezado -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                    Clasificación
                </span>
            </h1>
            <h2 class="text-2xl font-semibold text-gray-700">
                Liga: <span class="text-indigo-600">{{ $liga->nombre }}</span>
            </h2>
        </div>

        <!-- Tabla de clasificación -->
        <div class="bg-white rounded-xl shadow-2xl overflow-hidden border border-gray-200">
            <!-- Cabecera de la tabla -->
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-white">General</h3>
                    <span class="text-white/90 text-sm">Actualizado: {{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            <!-- Cuerpo de la tabla -->
            <div class="divide-y divide-gray-200">
                @foreach($equipos as $index => $equipo)
                <div class="hover:bg-gray-50 transition-colors duration-200 {{ $equipo->usuario_id == auth()->id() ? 'bg-indigo-50' : '' }}">
                    <div class="px-6 py-4 flex items-center">
                        <!-- Posición -->
                        <div class="w-12 flex-shrink-0 text-center">
                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full 
                                @if($index + 1 == 1) bg-gradient-to-br from-yellow-400 to-yellow-600 text-white
                                @elseif($index + 1 == 2) bg-gradient-to-br from-gray-300 to-gray-400 text-gray-800
                                @elseif($index + 1 == 3) bg-gradient-to-br from-amber-600 to-amber-800 text-white
                                @else bg-gray-100 text-gray-600 @endif
                                font-bold">
                                {{ $index + 1 }}
                            </span>
                        </div>
                        
                        <!-- Logo y nombre -->
                        <div class="flex items-center flex-1 min-w-0">
                            <div class="flex-shrink-0">
                                <div class="relative h-14 w-14 rounded-full overflow-hidden border border-gray-300 shadow-lg bg-gradient-to-tr from-white to-gray-100 p-0.5 transition-transform hover:scale-105">
                                    <img
                                        class="h-full w-full object-cover rounded-full"
                                        src="{{ $equipo->usuario->foto_url }}"
                                        alt="Logo de {{ $equipo->usuario->nombre }}"
                                    >
                                </div>
                            </div>

                            <div class="ml-4 min-w-0">
                                <div class="flex items-center">
                                    <p class="text-lg font-bold text-gray-900 truncate">
                                        {{ $equipo->usuario->nombre }}
                                        @if($equipo->usuario_id == auth()->id())
                                            <span class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">Tú</span>
                                        @endif
                                    </p>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    Valor del equipo: <span class="font-semibold text-indigo-600">{{ number_format($equipo->valor_total, 0, ',', '.') }} €</span>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Puntos -->
                        <div class="ml-4 flex-shrink-0">
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">{{ number_format($equipo->puntos, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-500 mt-1">Puntos</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Estadísticas adicionales -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Mejor equipo -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">🏆 Mejor equipo</h3>
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-600 flex items-center justify-center text-white font-bold">
                        1
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">{{ $equipos->first()->usuario->nombre }}</p>
                        <p class="text-sm text-gray-500">{{ number_format($equipos->first()->puntos, 0, ',', '.') }} pts</p>
                    </div>
                </div>
            </div>
            
            <!-- Tu posición -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">🎯 Tu posición</h3>
                @php
                    $tuPosicion = $equipos->search(function($item) {
                        return $item->usuario_id == auth()->id();
                    }) + 1;
                @endphp
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                        {{ $tuPosicion }}
                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">Tú</p>
                        <p class="text-sm text-gray-500">
                            {{ number_format($equipos->where('usuario_id', auth()->id())->first()->puntos ?? 0, 0, ',', '.') }} pts
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Peor equipo -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">💩 Peor equipo</h3>
                <div class="flex items-center">
                    <!-- Imagen del usuario -->
                    <div class="relative h-12 w-12 rounded-full overflow-hidden border border-gray-300 shadow-md bg-white p-0.5">
                        <img 
                            src="{{ $equipos->last()->usuario->foto_url }}" 
                            alt="Avatar de {{ $equipos->last()->usuario->nombre }}" 
                            class="h-full w-full object-cover rounded-full"
                        >
                    </div>

                    <!-- Nombre y puntos -->
                    <div class="ml-4">
                        <p class="font-medium text-gray-900">{{ $equipos->last()->usuario->nombre }}</p>
                        <p class="text-sm text-gray-500">{{ number_format($equipos->last()->puntos, 0, ',', '.') }} pts</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection