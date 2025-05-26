@extends('layouts.ligaMenu')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 min-h-[80vh]" x-data="{ 
    editMode: false,
    ligaTipo: '{{ old('tipo', $liga->tipo ?? 'publica') }}',
    clearPasswordIfPublic() {
        if (this.ligaTipo === 'publica') {
            this.$refs.passwordInput.value = '';
        }
    }
}" x-effect="clearPasswordIfPublic()">

@php
    $admin = null;
@endphp

@foreach($liga->usuarios as $usuario)
    @if($usuario->id == $liga->usuario_id)
        @php
            $admin = $usuario->nombre;
        @endphp
    @endif
@endforeach

    <!-- Notificaciones estilo gaming -->
    <div class="space-y-4 mb-6">
        @if (session('status'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="p-4 bg-gradient-to-r from-green-900/20 to-green-800/20 border-l-4 border-green-500 rounded-lg text-green-300 shadow-md">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-gradient-to-r from-red-900/20 to-red-800/20 border-l-4 border-red-500 rounded-lg text-red-300 shadow-md">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="font-medium">{{ __('¡Error en la operación!') }}</p>
                </div>
                <ul class="mt-2 ml-8 list-disc text-sm text-red-300">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg dark:shadow-gray-900/50 border-2 border-blue-200 dark:border-blue-700 overflow-hidden relative">
        <!-- Efectos de esquina -->
        <div class="absolute top-0 left-0 w-12 h-12 border-t-4 border-l-4 border-blue-400 dark:border-blue-500 rounded-tl-xl"></div>
        <div class="absolute bottom-0 right-0 w-12 h-12 border-b-4 border-r-4 border-blue-400 dark:border-blue-500 rounded-br-xl"></div>
        
        <!-- Encabezado con logo -->
        <div class="p-8 flex flex-col sm:flex-row items-start gap-6 bg-gradient-to-r from-blue-100 dark:from-blue-900/30 to-blue-50 dark:to-blue-800/30" x-show="!editMode">
            <div class="relative flex-shrink-0">
                <div class="relative h-24 w-24 rounded-full p-1 bg-gradient-to-br from-blue-300 dark:from-blue-600 to-blue-500 dark:to-blue-700 shadow-lg">
                    <img class="w-full h-full rounded-full object-cover border-2 border-white dark:border-gray-800"
                         src="{{ $liga->logo_url }}"
                         alt="Logo de {{ $liga->nombre }}">
                </div>
                @if($liga->usuario_id == auth()->id())
                    <div class="absolute bottom-0 right-0 h-7 w-7 bg-green-500 rounded-full border-2 border-white dark:border-gray-800 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-blue-800 dark:text-blue-300 tracking-wide">{{ $liga->nombre }}</h1>
                <p class="text-blue-600 dark:text-blue-400 mt-1">@lang('messages.creada_el') {{ $liga->created_at->format('d/m/Y') }}</p>
                <p class="text-blue-700 dark:text-blue-300 mt-2">
                    {{ $liga->descripcion ?: __('messages.no_desc') }}
                </p>

            </div>
        </div>

        <!-- Formulario de edición -->
        <div x-show="editMode" class="p-8">
            <form method="POST" action="{{ route('actualizar-liga', $liga) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1"> @lang('messages.nombre-liga') *</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $liga->nombre) }}" required
                               class="w-full px-4 py-2 border-2 border-blue-200 dark:border-blue-700 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition duration-300 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">@lang('messages.descripcion')</label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                                  class="w-full px-4 py-2 border-2 border-blue-200 dark:border-blue-700 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition duration-300 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">{{ old('descripcion', $liga->descripcion) }}</textarea>
                    </div>

                    <!-- Tipo de Liga -->
                    <div>
                        <label for="tipo" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">@lang('messages.tipo_liga') *</label>
                        <select name="tipo" id="tipo" x-model="ligaTipo"
                                class="w-full px-4 py-2 border-2 border-blue-200 dark:border-blue-700 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition duration-300 appearance-none bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 bg-[url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233b82f6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e")] dark:bg-[url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2360a5fa' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e")] bg-no-repeat bg-[length:1.5rem] bg-[right_0.5rem_center]">
                            <option value="publica">@lang('messages.publica')</option>
                            <option value="privada">@lang('messages.privada')</option>
                        </select>
                    </div>

                    <!-- Contraseña (solo si es privada) -->
                    <div x-show="ligaTipo === 'privada'" x-transition class="mt-4">
                        <label for="password" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">@lang('messages.contraseña') *</label>
                        <input type="password" name="contrasena" id="password" x-ref="passwordInput"
                            class="w-full px-4 py-2 border-2 border-blue-200 dark:border-blue-700 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-blue-400 dark:focus:ring-blue-500 dark:focus:border-blue-500 transition duration-300 bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"
                            placeholder="Contraseña para unirse a la liga">
                        <p class="mt-1 text-sm text-blue-500 dark:text-blue-400">@lang('messages.obligatorio_para')</p>
                    </div>

                    <!-- Logo -->
                    <div>
                        <label for="logo_url" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">@lang('messages.logo_liga')</label>
                        <div class="flex items-center space-x-4">
                            <div class="shrink-0">
                                <div class="relative h-16 w-16 rounded-full p-1 bg-gradient-to-br from-blue-300 dark:from-blue-600 to-blue-500 dark:to-blue-700">
                                    <img id="logo_preview" class="w-full h-full rounded-full object-cover border-2 border-white dark:border-gray-800" 
                                         src="{{ $liga->logo_url }}" 
                                         alt="Logo actual">
                                </div>
                            </div>
                            <label class="block">
                                <span class="sr-only">@lang('messages.elegir_logo')</span>
                                <input type="file" name="logo_url" id="logo_url" accept="image/*" 
                                       class="block w-full text-sm text-blue-700 dark:text-blue-300
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-lg file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-blue-100 dark:file:bg-blue-900/50 file:text-blue-700 dark:file:text-blue-300
                                              hover:file:bg-blue-200 dark:hover:file:bg-blue-800/50">
                            </label>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-4 pt-4">
                        <button type="button" @click="editMode = false"
                                class="px-6 py-2 border-2 border-blue-200 dark:border-blue-700 rounded-lg text-blue-700 dark:text-blue-300 bg-white dark:bg-gray-700 hover:bg-blue-50 dark:hover:bg-gray-600 transition duration-300 hover:shadow-md">
                            @lang('messages.cancelar')
                        </button>
                        <button type="submit"
                                class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 dark:hover:from-blue-700 dark:hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-400 dark:focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition duration-300 shadow-md hover:shadow-lg">
                            @lang('messages.guardar_cambios')
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Contenido principal (modo visualización) -->
        <div class="p-8" x-show="!editMode">
            <!-- Estadísticas - Estilo cartas gaming -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-700 p-5 rounded-lg border-2 border-blue-200 dark:border-blue-600 shadow-md hover:shadow-lg dark:hover:shadow-gray-900/50 transition-all transform hover:-translate-y-1">
                    <h3 class="text-xs text-center font-bold text-blue-500 dark:text-blue-400 uppercase tracking-wider">  @lang('messages.tipo_liga_may')</h3>
                    <p class="text-xl text-center font-bold text-blue-800 dark:text-blue-300 mt-2 uppercase">
                        {{ ucfirst($liga->tipo) }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-700 p-5 rounded-lg border-2 border-green-200 dark:border-green-600 shadow-md hover:shadow-lg dark:hover:shadow-gray-900/50 transition-all transform hover:-translate-y-1">
                    <h3 class="text-xs font-bold text-green-500 dark:text-green-400 uppercase text-center tracking-wider">  @lang('messages.miembros_may')</h3>
                    <p class="text-2xl text-center font-bold text-green-800 dark:text-green-300 mt-2">
                        {{ $liga->usuarios->count() }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-700 p-5 rounded-lg border-2 border-yellow-200 dark:border-yellow-600 shadow-md hover:shadow-lg dark:hover:shadow-gray-900/50 transition-all transform hover:-translate-y-1">
                    <h3 class="text-xs font-bold text-yellow-500 dark:text-yellow-400 text-center uppercase tracking-wider">  @lang('messages.admin_may')</h3>
                    <p class="text-xl text-center font-bold text-yellow-800 dark:text-yellow-300 mt-2">
                        {{ $admin }}
                    </p>
                </div>
            </div>

            <!-- Botones de acción - Estilo gaming -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-blue-100 dark:border-blue-700">
                <button @click="editMode = true" 
                        class="flex-1 flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 dark:hover:from-blue-700 dark:hover:to-blue-800 transition duration-300 shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                      @lang('messages.editar_liga')
                </button>
                
                @if(auth()->id() == $liga->usuario_id)
                    <div x-data="{ openModal: false }" class="flex-1">
                        <button @click="openModal = true"
                                type="button"
                                class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 dark:from-red-600 dark:to-red-700 text-white rounded-lg hover:from-red-600 hover:to-red-700 dark:hover:from-red-700 dark:hover:to-red-800 transition duration-300 shadow-md hover:shadow-lg transform hover:scale-[1.02]">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                             @lang('messages.eliminar_liga')
                        </button>

                        <!-- Modal de confirmación estilo gaming -->
                        <div x-show="openModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div class="bg-white dark:bg-gray-800 rounded-xl border-2 border-red-200 dark:border-red-700 shadow-xl p-6 w-full max-w-md relative">
                                <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-red-400 dark:border-red-500 rounded-tl-xl"></div>
                                <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-red-400 dark:border-red-500 rounded-br-xl"></div>
                                
                                <h2 class="text-lg font-bold text-red-600 dark:text-red-400 mb-4">  @lang('messages.seguro_liga')</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">  @lang('messages.no_recuperar')</p>
                                <div class="flex justify-end space-x-4">
                                    <button @click="openModal = false"
                                            class="px-4 py-2 text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 border-2 border-gray-200 dark:border-gray-600">
                                          @lang('messages.cancelar')
                                    </button>
                                    <form action="{{ route('eliminar-liga', $liga) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 dark:from-red-600 dark:to-red-700 text-white rounded-lg hover:from-red-600 hover:to-red-700 dark:hover:from-red-700 dark:hover:to-red-800 border-2 border-red-200 dark:border-red-700">
                                              @lang('messages.si_eliminar')
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Lista de participantes - Estilo gaming -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl border-2 border-blue-200 dark:border-blue-700 shadow-lg dark:shadow-gray-900/50 overflow-hidden relative">
        <!-- Efectos de esquina -->
        <div class="absolute top-0 left-0 w-8 h-8 border-t-2 border-l-2 border-blue-400 dark:border-blue-500 rounded-tl-xl"></div>
        <div class="absolute bottom-0 right-0 w-8 h-8 border-b-2 border-r-2 border-blue-400 dark:border-blue-500 rounded-br-xl"></div>
        
        <div class="px-8 py-6 border-b border-blue-100 dark:border-blue-700">
            <h2 class="text-2xl font-bold text-blue-800 dark:text-blue-300 tracking-wide">
                <span class="text-blue-500 dark:text-blue-400">[</span>   @lang('messages.participates_may')<span class="text-blue-500 dark:text-blue-400">]</span>
            </h2>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                @foreach($liga->usuarios as $usuario)
                    <div class="flex flex-col items-center group transform hover:scale-105 transition-transform">
                        <div class="relative mb-3">
                            <!-- Marco de avatar estilo gaming -->
                            <div class="relative w-16 h-16 rounded-full p-1 bg-gradient-to-br from-blue-300 dark:from-blue-600 to-blue-500 dark:to-blue-700 group-hover:from-blue-400 group-hover:to-blue-600 dark:group-hover:from-blue-500 dark:group-hover:to-blue-800 transition-all">
                                <img src="{{ $usuario->foto_url }}" 
                                     alt="{{ $usuario->nombre }}" 
                                     class="w-full h-full rounded-full object-cover border-2 border-white dark:border-gray-800">
                            </div>
                            
                            @if($usuario->id == $liga->usuario_id)
                                <div class="absolute -top-2 -right-2 bg-yellow-400 dark:bg-yellow-500 text-gray-900 text-xs font-bold px-2 py-1 rounded-full shadow-md border-2 border-yellow-300 dark:border-yellow-400">
                                      @lang('messages.admin1_may')
                                </div>
                            @endif
                        </div>
                        <span class="text-sm font-bold text-blue-800 dark:text-blue-300 text-center">{{ $usuario->nombre }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Script para previsualizar el logo seleccionado -->
<script>
    document.getElementById('logo_url').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('logo_preview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection