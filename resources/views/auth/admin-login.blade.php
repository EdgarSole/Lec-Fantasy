<x-guest-layout>
        <div class="w-full max-w-md px-6 py-6 bg-white dark:bg-gray-900/90 rounded-2xl shadow-xl border border-gray-200/70 dark:border-gray-800/70 ring-1 ring-white/10 backdrop-blur-sm">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Panel <span class="text-red-600">Administrador</span></h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Inicia sesión como administrador para gestionar la plataforma.</p>
            </div>

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="login" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email o nombre de admin</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-600 focus:border-red-500 dark:focus:border-red-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition duration-150"
                            placeholder="admin@ejemplo.com">
                    </div>
                    @error('login')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña de administrador</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" name="password" type="password" required
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 dark:border-gray-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 dark:focus:ring-red-600 focus:border-red-500 dark:focus:border-red-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 transition duration-150"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" 
                            class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">Recordarme</label>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                        Acceder al panel de administrador
                    </button>
                </div>
            </form>
        </div>
</x-guest-layout>
