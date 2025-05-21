<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-sm border-b border-gray-200 shadow-lg shadow-blue-100/30 relative z-50">
    <!-- Contenedor principal -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-3">

            <!-- Logo -->
            <div class="flex-shrink-0">
                @auth
                    <a href="{{ route('inicio') }}" class="group block transition-all duration-300 hover:scale-[1.03]">
                @else
                    <a href="{{ route('index') }}" class="group block transition-all duration-300 hover:scale-[1.03]">
                @endauth
                    <img src="{{ asset('Imagenes/LecFantasyLogoV2.jpg') }}" alt="Logo" class="h-14 w-auto transform group-hover:rotate-1 transition-transform duration-300">
                </a>
            </div>

            <!-- Menú central - Desktop -->
            <div class="hidden sm:flex sm:items-center sm:space-x-3 mx-4">
                <x-nav-link 
                    :href="auth()->check() ? route('inicio') : route('index')" 
                    :active="request()->routeIs('inicio') || request()->routeIs('index')" 
                    class="px-5 py-2 font-medium relative overflow-hidden group">
                    <span class="relative z-10 flex items-center">
                        <span class="mr-2"><i class="fa-solid fa-house"></i></span>
                        @lang('messages.inicio')
                    </span>
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-500 w-0 group-hover:w-full transition-all duration-500"></span>
                </x-nav-link>

                <x-nav-link :href="route('jugadores')" :active="request()->routeIs('jugadores')" 
                    class="px-5 py-2 font-medium relative overflow-hidden group">
                    <span class="relative z-10 flex items-center">
                        <span class="mr-2"><i class="fa-solid fa-gamepad"></i></span>
                        @lang('messages.jugadores')
                    </span>
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-500 w-0 group-hover:w-full transition-all duration-500"></span>
                </x-nav-link>

                <x-nav-link :href="route('top-global')" :active="request()->routeIs('top-global')" 
                    class="px-5 py-2 font-medium relative overflow-hidden group">
                    <span class="relative z-10 flex items-center">
                        <span class="mr-2"><i class="fa-solid fa-earth-americas"></i></span>
                        @lang('messages.top-global')
                    </span>
                    <span class="absolute bottom-0 left-0 h-0.5 bg-blue-500 w-0 group-hover:w-full transition-all duration-500"></span>
                </x-nav-link>
            </div>

            <!-- Lado derecho - Desktop -->
            <div class="hidden sm:flex sm:items-center space-x-3">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center space-x-2 focus:outline-none group">
                                <div class="relative">
                                    <div class="absolute inset-0 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                                    <img src="{{ asset(Auth::user()->foto_url) }}" alt="Foto de perfil" 
                                         class="h-10 w-10 rounded-full object-cover border-2 border-gray-300 group-hover:border-blue-400 transition-all duration-300 shadow-sm">
                                    <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full bg-green-500 ring-2 ring-white shadow-md"></span>
                                </div>
                                <span class="text-gray-700 font-medium group-hover:text-blue-600 transition-colors duration-300">{{ Auth::user()->nombre }}</span>
                                <svg class="w-4 h-4 text-gray-500 group-hover:text-blue-600 transition-colors duration-300 transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-xl border border-gray-200 overflow-hidden">
                                <x-dropdown-link :href="route('profile.edit')" class="px-4 py-3 hover:bg-blue-50 text-gray-700 transition-all duration-300 border-b border-gray-100 flex items-center space-x-2 group">
                                    <span class="p-1.5 bg-blue-100 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </span>
                                    <span class="group-hover:text-blue-600 transition-colors duration-300">@lang('messages.perfil')</span>
                                </x-dropdown-link>

                               <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" 
                                        class="px-4 py-3 hover:bg-blue-50 text-gray-700 transition-all duration-300 flex items-center space-x-2 group">
                                        <span class="p-1.5 bg-red-100 rounded-lg text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                        </span>
                                        <span class="group-hover:text-red-600 transition-colors duration-300">@lang('messages.cerrar-sesion')</span>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex space-x-3">
                        <x-nav-link :href="route('login')" :active="request()->routeIs('login')" class="px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 hover:scale-105 transform shadow-md hover:shadow-lg flex items-center">
                            @lang('messages.login')
                        </x-nav-link>
                        
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')" class="px-5 py-2.5 border border-blue-300 text-sm font-medium rounded-xl text-blue-600 bg-white hover:bg-blue-50 transition-all duration-300 hover:scale-105 transform shadow-md hover:shadow-lg flex items-center">
                            @lang('messages.register')
                        </x-nav-link>
                    </div>
                @endauth
            </div>

            <!-- Botón menú hamburguesa -->
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-600 hover:text-blue-600 hover:bg-blue-50 focus:outline-none transition duration-300 ease-in-out transform hover:scale-110">
                    <svg class="h-7 w-7" :class="{ 'hidden': open, 'block': !open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="h-7 w-7" :class="{ 'hidden': !open, 'block': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="language-dropdown">
                <input type="checkbox" id="toggle-language" class="toggle-language">
                <label for="toggle-language">
                        <i class="fa-solid fa-language"></i>
                    <span class="dropdown-arrow">&#9660;</span> <!-- Icono de flecha hacia abajo -->
                </label>
                <div class="dropdown-options">
                <a href="locale/es" class="dropdown-item">
                    <img src="{{ asset('Imagenes/banderaEspana.jpg') }}" width="20">   ES
                </a>
                <a href="locale/en" class="dropdown-item">
                    <img src="{{ asset('Imagenes/banderaEEUU.jpg') }}" width="20">   EN
                </a>

                </div>
            </div>   
        </div>
    </div>

    <!-- Menú móvil desplegable -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="sm:hidden absolute w-full bg-white/95 backdrop-blur-sm shadow-xl z-50 border-t border-gray-200 rounded-b-2xl overflow-hidden">

        <div class="pt-2 pb-3 space-y-2 px-4">
            <x-responsive-nav-link :href="route('inicio')" :active="request()->routeIs('inicio')" class="block px-4 py-3 text-gray-800 hover:bg-blue-50 border border-gray-200 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center">
                <span class="mr-3"><i class="fa-solid fa-house"></i></span>
                @lang('messages.inicio')
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('jugadores')" :active="request()->routeIs('jugadores')" class="block px-4 py-3 text-gray-800 hover:bg-blue-50 border border-gray-200 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center">
                <span class="mr-3">👾</span>
                @lang('messages.jugadores')
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('top-global')" :active="request()->routeIs('top-global')" class="block px-4 py-3 text-gray-800 hover:bg-blue-50 border border-gray-200 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center">
                <span class="mr-3"><i class="fa-solid fa-earth-americas"></i></span>
                @lang('messages.top-global')
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pb-2 space-y-2 px-4 border-t border-gray-200">
                <x-responsive-nav-link :href="route('profile.edit')" class="block px-4 py-3 text-gray-800 hover:bg-blue-50 border border-gray-200 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center">
                    <span class="mr-3">👤</span>
                    @lang('messages.perfil')
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-3 text-gray-800 hover:bg-red-50 border border-gray-200 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center">
                        <span class="mr-3">🚪</span>
                        @lang('messages.cerrar-sesion')
                    </x-responsive-nav-link>
                </form>
            </div>
        @else
            <div class="pt-2 pb-4 space-y-3 px-4 border-t border-gray-200">
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')" class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 hover:scale-105 transform shadow-md hover:shadow-lg">
                    @lang('messages.login')
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')" class="w-full flex items-center justify-center px-4 py-3 border border-blue-300 text-base font-medium rounded-xl text-blue-600 bg-white hover:bg-blue-50 transition-all duration-300 hover:scale-105 transform shadow-md hover:shadow-lg">
                    @lang('messages.register')
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>
<style>
    .language-dropdown {
    position: relative;
    left: 200px;
}

.toggle-language {
    position: absolute;
    opacity: 0;
    pointer-events: none; 
}

.toggle-language:focus {
    outline: none; 
}
.language-dropdown label {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: transparent;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.language-dropdown label:hover {
    background: #f5f5f5;
}

.language-dropdown label:active {
    transform: scale(0.95);
}

.dropdown-arrow {
    font-size: 12px;
    transition: transform 0.3s ease;
}

.toggle-language:checked + label .dropdown-arrow {
    transform: rotate(180deg); /* Gira la flecha cuando se abre */
}

.dropdown-options {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #fff;
    border: 1px solid #ccc;
    z-index: 10;
    width: max-content;
    min-width: 100%;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px; /* Bordes redondeados */
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
    visibility: hidden; /* Evita que bloquee clics cuando está cerrado */
}

.toggle-language:checked + label + .dropdown-options {
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
}

.dropdown-item {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    text-decoration: none;
    color: black;
    font-optical-sizing: auto;
    width: 100%;
    box-sizing: border-box;
    gap: 10px; /* Espacio entre texto e imagen */
    transition: background-color 0.3s ease, transform 0.2s ease;
    border-radius: 6px;
}

.dropdown-item:hover {
    background-color: #f0f0f0;
    transform: scale(1.05);
}

.dropdown-item img {
    width: 25px;
    height: auto;
}

</style>