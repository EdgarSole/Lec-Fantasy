@extends('layouts.ligaMenu')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex flex-col h-screen bg-gray-900 rounded-lg shadow-xl overflow-hidden">
        <!-- Encabezado del chat -->
        <div class="bg-indigo-800 text-white p-4 flex items-center">
            <div class="flex-shrink-0">
                <img src="{{ $liga->logo_url ?? asset('images/default-liga.png') }}" 
                     alt="Logo de {{ $liga->nombre }}" 
                     class="h-10 w-10 rounded-full object-cover">
            </div>
            <div class="ml-3">
                <h2 class="text-xl font-bold">Chat de {{ $liga->nombre }}</h2>
                <p class="text-indigo-200 text-sm">{{ $liga->descripcion }}</p>
            </div>
        </div>

        <!-- Área de mensajes -->
        <div id="mensajes-container" class="flex-1 p-4 overflow-y-auto bg-gray-800 space-y-3">
            @foreach($mensajes as $mensaje)
                <div class="flex {{ $mensaje->usuario_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="flex max-w-xs lg:max-w-md {{ $mensaje->usuario_id == auth()->id() ? 'flex-row-reverse' : '' }}">
                        <!-- Avatar del usuario -->
                        <div class="flex-shrink-0 h-10 w-10">
                            <img src="{{ $mensaje->usuario->foto_url ?? asset('images/default-user.png') }}" 
                                 alt="{{ $mensaje->usuario->nombre }}" 
                                 class="h-10 w-10 rounded-full border-2 border-indigo-500">
                        </div>
                        
                        <!-- Contenedor del mensaje -->
                        <div class="ml-3 mr-3 {{ $mensaje->usuario_id == auth()->id() ? 'bg-indigo-600' : 'bg-gray-700' }} 
                                    rounded-lg p-3 shadow-lg">
                            <!-- Nombre y hora -->
                            <div class="flex items-center {{ $mensaje->usuario_id == auth()->id() ? 'justify-end' : 'justify-start' }} 
                                        space-x-2 mb-1">
                                <span class="font-bold text-sm {{ $mensaje->usuario_id == auth()->id() ? 'text-indigo-100' : 'text-gray-300' }}">
                                    {{ $mensaje->usuario->nombre }}
                                </span>
                                <span class="text-xs {{ $mensaje->usuario_id == auth()->id() ? 'text-indigo-200' : 'text-gray-400' }}">
                                    {{ $mensaje->created_at->format('H:i') }}
                                </span>
                            </div>
                            
                            <!-- Texto del mensaje -->
                            <p class="text-sm {{ $mensaje->usuario_id == auth()->id() ? 'text-white' : 'text-gray-200' }}">
                                {{ $mensaje->mensaje }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Formulario para enviar mensajes -->
        <div class="bg-gray-700 p-4 border-t border-gray-600">
            <form id="form-mensaje" action="{{ route('chat.enviar', $liga) }}" method="POST" class="flex">
                @csrf
                <input type="text" name="mensaje" id="input-mensaje" 
                       class="flex-1 bg-gray-600 text-white rounded-l-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                       placeholder="Escribe un mensaje..." required>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-r-lg transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript para el chat en tiempo real -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mensajesContainer = document.getElementById('mensajes-container');
        const formMensaje = document.getElementById('form-mensaje');
        const inputMensaje = document.getElementById('input-mensaje');
        
        // Hacer scroll al final de los mensajes al cargar
        mensajesContainer.scrollTop = mensajesContainer.scrollHeight;
        
        // Configuración de Echo para recibir mensajes en tiempo real
        window.Echo.private(`liga.${'{{ $liga->id }}'}`)
            .listen('NuevoMensajeLiga', (data) => {
                const mensaje = data.mensaje;
                const esPropio = mensaje.usuario_id == {{ auth()->id() }};
                
                const mensajeHTML = `
                    <div class="flex ${esPropio ? 'justify-end' : 'justify-start'}">
                        <div class="flex max-w-xs lg:max-w-md ${esPropio ? 'flex-row-reverse' : ''}">
                            <div class="flex-shrink-0 h-10 w-10">
                                <img src="${mensaje.usuario.foto_perfil || '/images/default-user.png'}" 
                                     alt="${mensaje.usuario.name}" 
                                     class="h-10 w-10 rounded-full border-2 border-indigo-500">
                            </div>
                            <div class="ml-3 mr-3 ${esPropio ? 'bg-indigo-600' : 'bg-gray-700'} 
                                        rounded-lg p-3 shadow-lg">
                                <div class="flex items-center ${esPropio ? 'justify-end' : 'justify-start'} 
                                            space-x-2 mb-1">
                                    <span class="font-bold text-sm ${esPropio ? 'text-indigo-100' : 'text-gray-300'}">
                                        ${mensaje.usuario.name}
                                    </span>
                                    <span class="text-xs ${esPropio ? 'text-indigo-200' : 'text-gray-400'}">
                                        ${new Date(mensaje.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                    </span>
                                </div>
                                <p class="text-sm ${esPropio ? 'text-white' : 'text-gray-200'}">
                                    ${mensaje.mensaje}
                                </p>
                            </div>
                        </div>
                    </div>
                `;
                
                mensajesContainer.insertAdjacentHTML('beforeend', mensajeHTML);
                mensajesContainer.scrollTop = mensajesContainer.scrollHeight;
            });
        
        // Enviar mensaje con AJAX
        formMensaje.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    mensaje: inputMensaje.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    inputMensaje.value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
</script>
@endsection