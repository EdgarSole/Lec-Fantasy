<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8 min-h-[80vh]" x-data="{ editMode: false }">
        <!-- Notificaciones -->
        <div class="space-y-4 mb-6">
            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                    class="p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-green-700 font-medium">{{ __('Perfil actualizado correctamente') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-red-700 font-medium">{{ __('Error al actualizar el perfil') }}</p>
                    </div>
                    <ul class="mt-2 ml-8 list-disc text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Tarjeta de perfil -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Encabezado con foto -->
            <div class="p-8 flex flex-col sm:flex-row items-start gap-6 bg-gradient-to-r from-blue-50 to-white">
                <div class="relative">
                    <img class="h-32 w-32 rounded-full object-cover border-4 border-white shadow-md"
                         src="{{ asset(auth()->user()->foto_url) }}"
                         alt="Foto de perfil de {{ auth()->user()->nombre }}">
                    <div class="absolute bottom-0 right-0 h-6 w-6 bg-green-500 rounded-full border-2 border-white"></div>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-800">{{ auth()->user()->nombre }}</h1>
                    <p class="text-gray-600 mt-1">{{ auth()->user()->email }}</p>
                    <p class="text-sm text-gray-500 mt-2">Miembro desde {{ auth()->user()->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Contenido principal -->
            <div class="p-8 space-y-8" x-show="!editMode">
                <!-- Estadísticas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Ligas Activas</h3>
                        <p class="text-2xl font-bold text-gray-800 mt-2">3</p>
                        <p class="text-xs text-gray-500 mt-1">Participando actualmente</p>
                    </div>
                    <div class="bg-white p-5 rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Posición Global</h3>
                        <p class="text-2xl font-bold text-gray-800 mt-2">#245</p>
                        <p class="text-xs text-gray-500 mt-1">Top 15% de jugadores</p>
                    </div>
                </div>

                <!-- Descripción -->
                <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Sobre mí</h3>
                    <p class="text-gray-700 leading-relaxed">
                        {{ auth()->user()->descripcion ?? 'Aún no has añadido una descripción sobre ti. ¡Edita tu perfil para añadir una!' }}
                    </p>
                </div>

                <!-- Acciones -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button @click="editMode = true" 
                            class="flex-1 flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar Perfil
                    </button>

                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            class="flex-1 flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300 shadow-sm hover:shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Eliminar Cuenta
                    </button>
                </div>
            </div>

            <!-- Formulario de edición -->
            <div x-show="editMode" class="p-8">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', auth()->user()->nombre) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                                @error('nombre')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo electrónico *</label>
                                <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div>
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-300">{{ old('descripcion', auth()->user()->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Nueva contraseña</label>
                                <input type="password" name="password" id="password"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                                       placeholder="Dejar en blanco para no cambiar">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar contraseña</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-300">
                            </div>
                        </div>

                        <!-- Foto de perfil -->
                        <div>
                            <label for="foto_url" class="block text-sm font-medium text-gray-700 mb-1">Foto de perfil</label>
                            <div class="flex items-center space-x-4">
                                <div class="shrink-0">
                                    <img id="preview" class="h-16 w-16 rounded-full object-cover border border-gray-200" 
                                         src="{{ asset(auth()->user()->foto_url) }}" 
                                         alt="Foto actual">
                                </div>
                                <label class="block">
                                    <span class="sr-only">Elegir foto</span>
                                    <input type="file" name="foto_url" id="foto_url" accept="image/*" 
                                           class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-lg file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-blue-50 file:text-blue-700
                                                  hover:file:bg-blue-100">
                                </label>
                            </div>
                            @error('foto_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-end space-x-4 pt-4">
                            <button type="button" @click="editMode = false"
                                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition duration-300">
                                Cancelar
                            </button>
                            <button type="submit"
                                    class="px-6 py-2 border border-transparent rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                                Guardar cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal de confirmación para eliminar cuenta -->
        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <h2 class="text-xl font-bold text-gray-900 mt-3">¿Eliminar cuenta permanentemente?</h2>
                    <p class="mt-2 text-gray-600">
                        Todos tus datos, equipos y estadísticas se perderán. Esta acción no se puede deshacer.
                    </p>
                </div>

                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Confirma tu contraseña</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500">
                    @error('password', 'userDeletion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end space-x-4">
                    <button type="button" x-on:click="$dispatch('close')"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Eliminar cuenta
                    </button>
                </div>
            </form>
        </x-modal>
    </div>

    <!-- Script para previsualizar la imagen seleccionada -->
    <script>
        document.getElementById('foto_url').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('preview').src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>