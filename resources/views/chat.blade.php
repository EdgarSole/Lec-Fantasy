@extends('layouts.ligaMenu')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Exo+2:wght@400;500;600&display=swap" rel="stylesheet">
<div class="container mx-auto px-4 py-6">
    <!-- Modal para imagen ampliada -->
    <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center hidden">
        <div class="relative max-w-4xl max-h-[90vh]">
            <img id="modal-image" class="max-w-full max-h-[80vh] rounded-lg shadow-2xl">
            
        </div>
    </div>

    <!-- Menú desplegable para configuración -->
    <div id="config-menu" class="fixed right-4 top-20 bg-gray-800 border-2 border-indigo-500 rounded-lg shadow-2xl z-40 hidden w-64">
        <div class="p-4">
            <h3 class="text-indigo-400 font-bold mb-3 border-b border-indigo-500 pb-2">Opciones del Chat</h3>
            <button onclick="confirmClearChat()" class="w-full text-left py-2 px-3 hover:bg-gray-700 rounded-lg text-red-400 hover:text-red-300 transition-all">
                <i class="fas fa-trash mr-2"></i> Borrar todo el chat
            </button>
        </div>
    </div>

    <!-- Menú desplegable para usuarios -->
    <div id="users-menu" class="fixed right-4 top-20 bg-gray-800 border-2 border-indigo-500 rounded-lg shadow-2xl z-40 hidden w-64 max-h-[60vh] overflow-y-auto">
        <div class="p-4">
            <h3 class="text-indigo-400 font-bold mb-3 border-b border-indigo-500 pb-2">Participantes activos</h3>
            <div id="users-list">
                <!-- Los usuarios se cargarán aquí dinámicamente -->
                @foreach($participantes as $participante)
                <div class="flex items-center py-2 px-3 hover:bg-gray-700 rounded-lg transition-all">
                    <img src="{{ $participante->foto_url ?? asset('images/default-user.png') }}" 
                         class="w-8 h-8 rounded-full border border-indigo-400 mr-3">
                    <div class="flex-1">
                        <p class="text-sm text-white">{{ $participante->nombre }}</p>
                        <p class="text-xs text-gray-400">{{ $participante->mensajes_count }} mensajes</p>
                    </div>
                    <span class="h-2 w-2 rounded-full {{ $participante->is_online ? 'bg-green-500 animate-pulse' : 'bg-gray-500' }}"></span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Contenedor principal del chat -->
    <div class="flex flex-col h-[80vh] bg-gray-900 rounded-xl shadow-2xl overflow-hidden border-2 border-indigo-500/20">
        <!-- Encabezado del chat -->
        <div class="bg-gradient-to-r from-indigo-900 to-purple-900 text-white p-4 flex items-center border-b-2 border-indigo-500/30">
            <div class="flex-shrink-0 relative">
                <img src="{{ $liga->logo_url ?? asset('images/default-liga.png') }}" 
                     alt="Logo de {{ $liga->nombre }}" 
                     class="h-12 w-12 rounded-full object-cover border-2 border-indigo-400 shadow-glow">
                <div class="absolute -bottom-1 -right-1 h-4 w-4 bg-green-500 rounded-full border-2 border-white shadow-pulse"></div>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-bold text-white font-orbitron tracking-wide">CHAT: {{ strtoupper($liga->nombre) }}</h2>
                <p class="text-indigo-300 text-xs font-exo">{{ $liga->descripcion }}</p>
            </div>
            <div class="ml-auto flex space-x-2">
                <!-- Botón de configuración -->
                <button id="config-btn" class="p-2 text-indigo-300 hover:text-white hover:bg-indigo-700/50 rounded-lg transition-all relative group">
                    <i class="fas fa-cog"></i>
                    <span class="tooltip-text">Configuración</span>
                </button>
                
                <!-- Botón de usuarios -->
                <button id="users-btn" class="p-2 text-indigo-300 hover:text-white hover:bg-indigo-700/50 rounded-lg transition-all relative group">
                    <i class="fas fa-users"></i>
                    <span class="absolute -bottom-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                        Participantes
                    </span>
                </button>
            </div>
        </div>

        <!-- Área de mensajes -->
        <div id="mensajes-container" class="flex-1 p-4 overflow-y-auto bg-gray-900/80 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre-v2.png')] space-y-4 scrollbar-gaming">
            @foreach($mensajes as $mensaje)
                <div class="flex {{ $mensaje->usuario_id == auth()->id() ? 'justify-end' : 'justify-start' }} animate-fade-in">
                    <div class="flex max-w-xs lg:max-w-md xl:max-w-lg {{ $mensaje->usuario_id == auth()->id() ? 'flex-row-reverse' : '' }}">
                        <!-- Avatar del usuario -->
                        <div class="flex-shrink-0 h-12 w-12 relative group">
                            <div class="absolute inset-0 bg-indigo-500/20 rounded-full blur-sm group-hover:blur-md transition-all duration-300"></div>
                            <img src="{{ $mensaje->usuario->foto_url ?? asset('images/default-user.png') }}" 
                                 alt="{{ $mensaje->usuario->nombre }}" 
                                 class="relative h-12 w-12 rounded-full border-2 border-indigo-400 object-cover z-10 transform group-hover:scale-110 transition-transform">
                            <div class="absolute -bottom-1 -right-1 h-4 w-4 {{ $mensaje->usuario->is_online ? 'bg-green-500 shadow-pulse' : 'bg-gray-500' }} rounded-full border-2 border-gray-900 z-20"></div>
                        </div>
                        
                        <!-- Contenedor del mensaje -->
                        <div class="ml-3 mr-3 {{ $mensaje->usuario_id == auth()->id() ? 'bg-gradient-to-br from-indigo-600/90 to-indigo-800/90' : 'bg-gray-800/90' }} 
                                    rounded-xl p-3 shadow-lg border {{ $mensaje->usuario_id == auth()->id() ? 'border-indigo-500/50' : 'border-gray-700' }} hover:shadow-glow transition-all">
                            <!-- Nombre y hora -->
                            <div class="flex items-center {{ $mensaje->usuario_id == auth()->id() ? 'justify-end' : 'justify-start' }} 
                                        space-x-2 mb-1">
                                <span class="font-bold text-sm {{ $mensaje->usuario_id == auth()->id() ? 'text-indigo-300' : 'text-gray-300' }} font-exo tracking-wide">
                                    {{ $mensaje->usuario->nombre }}
                                </span>
                                <span class="text-xs {{ $mensaje->usuario_id == auth()->id() ? 'text-indigo-400' : 'text-gray-500' }} font-mono">
                                    [{{ $mensaje->created_at->format('H:i') }}]
                                </span>
                            </div>
                            
                            <!-- Contenido del mensaje -->
                            @if($mensaje->tipo === 'imagen' && $mensaje->imagen_url)
                                <div class="mb-2 rounded-lg overflow-hidden border-2 border-gray-700/50 hover:border-indigo-400/50 transition-all cursor-zoom-in" 
                                     onclick="openImageModal('{{ $mensaje->imagen_url }}')">
                                    <img src="{{ $mensaje->imagen_url }}" alt="Imagen del chat" 
                                         class="max-w-full max-h-64 object-cover hover:scale-[1.02] transition-transform" />
                                </div>
                            @endif
                            @if($mensaje->mensaje)
                                <p class="text-sm {{ $mensaje->usuario_id == auth()->id() ? 'text-indigo-100' : 'text-gray-200' }} font-exo leading-relaxed">
                                    {{ $mensaje->mensaje }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Formulario para enviar mensajes -->
        <div class="bg-gray-800/90 p-4 border-t-2 border-indigo-500/20 backdrop-blur-sm">
            <form id="form-mensaje" action="{{ route('chat.enviar', $liga) }}" method="POST" class="flex items-center space-x-2" enctype="multipart/form-data">
                @csrf
                
                <!-- Botón para adjuntar archivos -->
                <label class="cursor-pointer bg-gray-700 hover:bg-indigo-600 rounded-lg p-3 border-2 border-gray-600 hover:border-indigo-400 transition-all group">
                    <input type="file" name="imagen" accept="image/*" class="hidden">
                    <i class="fa-solid fa-image text-gray-400 group-hover:text-white transition-colors"></i>
                    
                </label>
                
                <!-- Input de texto -->
                <input type="text" name="mensaje" id="input-mensaje" 
                    class="flex-1 bg-gray-700/80 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 border-2 border-gray-600 hover:border-indigo-400/50 font-exo placeholder-gray-400 transition-all"
                    placeholder="Escribe tu mensaje...">
                
                <!-- Botón de enviar -->
                <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white px-5 py-3 rounded-lg border-2 border-indigo-400/30 hover:border-indigo-300/50 shadow-lg hover:shadow-indigo-500/20 transition-all transform hover:scale-105 active:scale-95">
                    <i class="fas fa-paper-plane"></i>
                    <span class="ml-1 font-exo text-sm">ENVIAR</span>
                </button>
            </form>
            
            <!-- Vista previa de imagen seleccionada -->
            <div id="image-preview" class="mt-3 hidden">
                <div class="relative inline-block">
                    <img id="preview-image" class="max-h-32 rounded-lg border-2 border-indigo-400/50">
                    <button onclick="clearImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center border-2 border-white shadow-lg hover:bg-red-600 transition-all">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para las nuevas funcionalidades -->
<script>
    // Función para abrir imagen en modal
    function openImageModal(imageUrl) {
        document.getElementById('modal-image').src = imageUrl;
        document.getElementById('image-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Función para cerrar modal
    function closeModal() {
        document.getElementById('image-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Cerrar modal al hacer clic fuera de la imagen
    document.getElementById('image-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Mostrar/ocultar menú de configuración
    document.getElementById('config-btn').addEventListener('click', function(e) {
        e.stopPropagation();
        const configMenu = document.getElementById('config-menu');
        const usersMenu = document.getElementById('users-menu');
        
        usersMenu.classList.add('hidden');
        configMenu.classList.toggle('hidden');
    });

    // Mostrar/ocultar menú de usuarios
    document.getElementById('users-btn').addEventListener('click', function(e) {
        e.stopPropagation();
        const configMenu = document.getElementById('config-menu');
        const usersMenu = document.getElementById('users-menu');
        
        configMenu.classList.add('hidden');
        usersMenu.classList.toggle('hidden');
    });

    // Ocultar menús al hacer clic fuera
    document.addEventListener('click', function() {
        document.getElementById('config-menu').classList.add('hidden');
        document.getElementById('users-menu').classList.add('hidden');
    });

    // Evitar que los clics dentro de los menús los cierren
    document.getElementById('config-menu').addEventListener('click', function(e) {
        e.stopPropagation();
    });

    document.getElementById('users-menu').addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Función para confirmar borrado del chat
    function confirmClearChat() {
        if (confirm('¿Estás seguro de que quieres borrar todo el historial del chat? Esta acción no se puede deshacer.')) {
            fetch('{{ route("chat.borrar", $liga) }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al borrar el chat');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }

    // Vista previa de imagen
    document.querySelector('input[name="imagen"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview-image').src = event.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    function clearImage() {
        document.querySelector('input[name="imagen"]').value = '';
        document.getElementById('image-preview').classList.add('hidden');
    }

    // Auto-scroll al final de los mensajes
    const mensajesContainer = document.getElementById('mensajes-container');
    mensajesContainer.scrollTop = mensajesContainer.scrollHeight;
</script>

<!-- Estilos adicionales -->
<style>
    .font-orbitron {
        font-family: 'Orbitron', sans-serif;
    }
    .font-exo {
        font-family: 'Exo 2', sans-serif;
    }
    .shadow-glow {
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.5);
    }
    .shadow-pulse {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(74, 222, 128, 0); }
        100% { box-shadow: 0 0 0 0 rgba(74, 222, 128, 0); }
    }
    .scrollbar-gaming::-webkit-scrollbar {
        width: 8px;
    }
    .scrollbar-gaming::-webkit-scrollbar-track {
        background: rgba(31, 41, 55, 0.5);
        border-radius: 10px;
    }
    .scrollbar-gaming::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #6366F1, #8B5CF6);
        border-radius: 10px;
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
    #image-modal {
        backdrop-filter: blur(5px);
    }
    #modal-image {
        animation: zoomIn 0.3s ease-out;
    }
    @keyframes zoomIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .tooltip-text {
        visibility: hidden;
        width: 120px;
        background-color: #1F2937;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s;
    }
    .group:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }
</style>

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
    document.querySelector('input[name="imagen"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('preview-image').src = event.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    function clearImage() {
        document.querySelector('input[name="imagen"]').value = '';
        document.getElementById('image-preview').classList.add('hidden');
    }

    // Efecto de tecleo en el input
    const inputMensaje = document.getElementById('input-mensaje');
    inputMensaje.addEventListener('focus', function() {
        this.parentElement.classList.add('ring-2', 'ring-indigo-500/50');
    });
    inputMensaje.addEventListener('blur', function() {
        this.parentElement.classList.remove('ring-2', 'ring-indigo-500/50');
    });

    // Auto-scroll al final de los mensajes
    const mensajesContainer = document.getElementById('mensajes-container');
    mensajesContainer.scrollTop = mensajesContainer.scrollHeight;
</script>
@endsection