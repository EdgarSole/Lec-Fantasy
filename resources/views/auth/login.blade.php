<x-guest-layout>
    
        <div class="w-full max-w-md px-6 py-6 bg-white rounded-2xl shadow-xl">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800"> @lang('messages.bienvenido_a')<span class="text-blue-600">LEC Fantasy</span></h2>
                <p class="mt-2 text-gray-600">@lang('messages.incia_sesion_gestiona')</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Campo login -->
                <div>
                    <label for="login" class="block text-sm font-medium text-gray-700 mb-1"> @lang('messages.email_o_nombre')</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                            placeholder="usuario@ejemplo.com">
                    </div>
                    @error('login')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">@lang('messages.contraseña')</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Recordarme y Olvidé contraseña -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">@lang('messages.recordarme')</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500 transition duration-150">
                             @lang('messages.olvide_contra')
                        </a>
                    @endif
                </div>

                <!-- Botón de Inicio de Sesión -->
                <div>
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 transform hover:scale-105">
                         @lang('messages.login')
                    </button>
                </div>

                <!-- Registro -->
                <div class="text-center text-sm text-gray-600">
                    <p> @lang('messages.no_cuenta')
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 transition duration-150">
                             @lang('messages.registrate_aqui')
                        </a>
                    </p>
                </div>
            </form>

            <!-- O separador para redes sociales si las añades luego -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500"> @lang('messages.continua_con')</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-3">
                    <div>
                        <a href="{{ route('login.google') }}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition duration-150">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.545 10.239v3.821h5.445c-0.712 2.315-2.647 3.972-5.445 3.972-3.332 0-6.033-2.701-6.033-6.032s2.701-6.032 6.033-6.032c1.498 0 2.866 0.549 3.921 1.453l2.814-2.814c-1.784-1.664-4.153-2.675-6.735-2.675-5.522 0-10 4.477-10 10s4.478 10 10 10c8.396 0 10-7.524 10-10 0-0.61-0.056-1.207-0.156-1.781h-9.844z"/>
                            </svg>
                        </a>
                    </div>

                </div>
            </div>
        </div>
  
</x-guest-layout>