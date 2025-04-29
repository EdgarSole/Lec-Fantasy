<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <!-- Menú de navegación principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('Imagenes/LecFantasyLogoV2.jpg') }}" alt="Logo" class="h-14 w-auto">
                </a>
            </div>
            <!-- Menú central - Desktop -->
            <div class="hidden sm:flex sm:items-center sm:space-x-3 mx-4">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                    class="px-5 py-2 font-medium text-sm transition-all duration-200 
                    {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                    border border-gray-300 rounded-none shadow-sm">
                    {{ __('Inicio') }}
                </x-nav-link>

                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                    class="px-5 py-2 font-medium text-sm transition-all duration-200 
                    {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                    border border-gray-300 rounded-none shadow-sm">
                    {{ __('Jugadores') }}
                </x-nav-link>

                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                    class="px-5 py-2 font-medium text-sm transition-all duration-200 
                    {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                    border border-gray-300 rounded-none shadow-sm">
                    {{ __('Reglas') }}
                </x-nav-link>
            </div>

            <!-- Lado derecho - Desktop -->
            <div class="hidden sm:flex sm:items-center space-x-3">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 focus:outline-none">
                                <!-- Foto de perfil -->
                                <img src="{{ asset(Auth::user()->foto_url) }}" alt="Foto de perfil" class="h-9 w-9 rounded-full object-cover">


                                <span class="text-gray-700 font-medium">{{ Auth::user()->nombre }}</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')" class="px-4 py-2 hover:bg-gray-100 text-gray-700 transition-colors border-b border-gray-100">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>{{ __('Perfil') }}</span>
                                </div>
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="px-4 py-2 hover:bg-gray-100 text-gray-700 transition-colors">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span>{{ __('Cerrar sesión') }}</span>
                                    </div>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')" 
                        class="px-5 py-2 font-medium text-sm transition-all duration-200 
                        {{ request()->routeIs('login') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                        border border-gray-300 rounded-none shadow-sm">
                        {{ __('Iniciar sesión') }}
                    </x-nav-link>
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')" 
                        class="px-5 py-2 font-medium text-sm transition-all duration-200 
                        {{ request()->routeIs('register') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                        border border-gray-300 rounded-none shadow-sm">
                        {{ __('Registrarse') }}
                    </x-nav-link>
                @endauth
            </div>

            <!-- Menú hamburguesa - Mobile -->
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" :class="{ 'hidden': open, 'block': !open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="h-6 w-6" :class="{ 'hidden': !open, 'block': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Menú responsivo - Mobile -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="sm:hidden absolute w-full bg-white shadow-lg z-50">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="block px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                border border-gray-300 rounded-none my-1">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="block px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                border border-gray-300 rounded-none my-1">
                {{ __('Jugadores') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                class="block px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                border border-gray-300 rounded-none my-1">
                {{ __('Reglas') }}
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pt-4 pb-2 border-t border-gray-200 px-4">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <!-- Foto de perfil redonda -->
                        <img src="{{ asset('Foto_Perfil/' . Auth::user()->foto_url) }}" alt="Foto de perfil"
                            class="h-10 w-10 rounded-full object-cover">
                    </div>
                    <div>
                        <div class="font-medium text-gray-800">{{ Auth::user()->nombre }}</div>
                        <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <div class="pb-2 space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')" 
                    class="block px-4 py-3 bg-gray-100 text-gray-800 hover:bg-gray-200 border border-gray-300 rounded-none my-1">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" 
                        class="block px-4 py-3 bg-gray-100 text-gray-800 hover:bg-gray-200 border border-gray-300 rounded-none my-1">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        @else
            <div class="pt-2 pb-4 space-y-1 px-4 border-t border-gray-200">
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')" 
                    class="block px-4 py-3 {{ request()->routeIs('login') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                    border border-gray-300 rounded-none my-1">
                    {{ __('Iniciar sesión') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')" 
                    class="block px-4 py-3 {{ request()->routeIs('register') ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                    border border-gray-300 rounded-none my-1">
                    {{ __('Registrarse') }}
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>
