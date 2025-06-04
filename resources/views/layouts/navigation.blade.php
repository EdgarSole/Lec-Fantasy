<nav x-data="{ open: false, languageOpen: false }" class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm border-b border-gray-200 dark:border-gray-800 shadow-lg shadow-blue-100/30 dark:shadow-blue-900/20 relative z-50 transition-colors duration-300">
    <!-- Contenedor principal -->
    <div class="w-full px-4 lg:px-6 lg:px-8">
        <div class="max-w-screen-xl mx-auto relative flex items-center justify-between py-3">

            <!-- Logo -->
            <div class="flex-shrink-0">
                @auth
                    <a href="{{ route('inicio') }}" class="group block transition-all duration-300 hover:scale-[1.03]">
                @else
                    <a href="{{ route('index') }}" class="group block transition-all duration-300 hover:scale-[1.03]">
                @endauth
                    <img src="{{ asset('Imagenes/LecFantasyLogoV4-TextoNegro.png') }}" alt="Logo claro" class="h-14 block dark:hidden">
                    <img src="{{ asset('Imagenes/LecFantasyLogoV3-TextoBlanco.PNG') }}" alt="Logo oscuro" class="h-14 hidden dark:block">


                </a>
            </div>

            <!-- Menú central - Desktop -->
            <div class="hidden lg:flex absolute left-1/2 -translate-x-1/2">
                <div class="flex space-x-3 mx-auto">
                    <x-nav-link 
                        :href="auth()->check() ? route('inicio') : route('index')" 
                        :active="request()->routeIs('inicio') || request()->routeIs('index')" 
                        class="px-5 py-2 font-medium relative overflow-hidden group dark:text-gray-300">
                        <span class="relative z-10 flex items-center">
                            <span class="mr-2"><i class="fa-solid fa-house"></i></span>
                            @lang('messages.inicio')
                        </span>
                        <span class="absolute bottom-0 left-0 h-0.5 bg-blue-500 dark:bg-cyan-400 w-0 group-hover:w-full transition-all duration-500"></span>
                    </x-nav-link>

                    <x-nav-link :href="route('jugadores')" 
                    @click.prevent="window.location.href = '{{ route('jugadores') }}'"
                    :active="request()->routeIs('jugadores')" 
                        class="px-5 py-2 font-medium relative overflow-hidden group dark:text-gray-300">
                        <span class="relative z-10 flex items-center">
                            <span class="mr-2"><i class="fa-solid fa-gamepad"></i></span>
                            @lang('messages.jugadores')
                        </span>
                        <span class="absolute bottom-0 left-0 h-0.5 bg-blue-500 dark:bg-cyan-400 w-0 group-hover:w-full transition-all duration-500"></span>
                    </x-nav-link>

                    <x-nav-link :href="route('top-global')" @click.prevent="window.location.href = '{{ route('top-global') }}'"
                    :active="request()->routeIs('top-global')" 
                        class="px-5 py-2 font-medium relative overflow-hidden group dark:text-gray-300">
                        <span class="relative z-10 flex items-center">
                            <span class="mr-2"><i class="fa-solid fa-earth-americas"></i></span>
                            @lang('messages.top-global')
                        </span>
                        <span class="absolute bottom-0 left-0 h-0.5 bg-blue-500 dark:bg-cyan-400 w-0 group-hover:w-full transition-all duration-500"></span>
                    </x-nav-link>
                </div>
            </div>

            <!-- Lado derecho - Desktop -->
            <div class="hidden lg:flex items-center justify-end w-full space-x-6">
                <!-- Contenedor de elementos de usuario/login -->
                <div class="flex items-center space-x-4">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center space-x-2 focus:outline-none group">
                                    <div class="relative">
                                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-cyan-400 to-blue-500 dark:from-cyan-500 dark:to-blue-600 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                                        <img src="{{ asset(Auth::user()->foto_url) }}" alt="Foto de perfil" 
                                             class="h-10 w-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600 group-hover:border-blue-400 dark:group-hover:border-cyan-400 transition-all duration-300 shadow-sm">
                                        <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full bg-green-500 ring-2 ring-white dark:ring-gray-800 shadow-md"></span>
                                    </div>
                                    <span class="text-gray-700 dark:text-gray-300 font-medium group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition-colors duration-300">{{ Auth::user()->nombre }}</span>
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition-colors duration-300 transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content" >
                                <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                                    <x-dropdown-link :href="route('profile.edit')" class="px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-all duration-300 border-b border-gray-100 dark:border-gray-700 flex items-center space-x-2 group">
                                        <span class="p-1.5 bg-blue-100 dark:bg-gray-700 rounded-lg text-blue-600 dark:text-cyan-400 group-hover:bg-blue-600 dark:group-hover:bg-cyan-500 group-hover:text-white transition-colors duration-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </span>
                                        <span class="group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition-colors duration-300">@lang('messages.perfil')</span>
                                    </x-dropdown-link>

                                   <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" 
                                            class="px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 transition-all duration-300 flex items-center space-x-2 group">
                                            <span class="p-1.5 bg-red-100 dark:bg-gray-700 rounded-lg text-red-600 dark:text-red-400 group-hover:bg-red-600 dark:group-hover:bg-red-500 group-hover:text-white transition-colors duration-300">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                                </svg>
                                            </span>
                                            <span class="group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors duration-300">@lang('messages.cerrar-sesion')</span>
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <div class="flex space-x-3">
                            <x-nav-link :href="route('login')" :active="request()->routeIs('login')" 
                                class="px-5 py-2 font-medium relative overflow-hidden group dark:text-gray-300 text-gray-800">
                                <span class="relative z-10 flex items-center transition-colors duration-300 group-hover:text-blue-500 group-hover:dark:text-cyan-400">
                                    @lang('messages.login')
                                </span>
                                <span class="absolute bottom-0 left-0 h-0.5 bg-blue-500 dark:bg-cyan-400 w-0 group-hover:w-full transition-all duration-500"></span>
                            </x-nav-link>

                            <x-nav-link :href="route('register')" :active="request()->routeIs('register')" 
                                class="px-5 py-2 font-medium relative overflow-hidden group dark:text-gray-300 text-gray-800">
                                <span class="relative z-10 flex items-center transition-colors duration-300 group-hover:text-blue-500 group-hover:dark:text-cyan-400">
                                    @lang('messages.register')
                                </span>
                                <span class="absolute bottom-0 left-0 h-0.5 bg-blue-500 dark:bg-cyan-400 w-0 group-hover:w-full transition-all duration-500"></span>
                            </x-nav-link>
                        </div>
                    @endauth
                </div>

                 <!-- Botón de modo claro/oscuro -->
                <div class="relative " x-data="{ darkMode: false }" @click="darkMode = !darkMode; document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', darkMode);"
                    x-init="darkMode = localStorage.getItem('darkMode') === 'true'; document.documentElement.classList.toggle('dark', darkMode)">
                    <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300 group">
                        <svg x-show="!darkMode" class="w-5 h-5 text-gray-600 dark:text-gray-300 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-gray-600 dark:text-gray-300 group-hover:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Menú de idiomas -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center space-x-1 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                        <i class="fa-solid fa-language text-gray-600 dark:text-gray-400"></i>
                        <span 
                            class="text-gray-600 dark:text-gray-400 transform transition-transform duration-300"
                            :class="{ 'rotate-180': open }"
                        >
                            &#9660;
                        </span>
                    </button>
                    
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" 
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150" 
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-20 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                        <a href="{{ route('locale', ['lang' => 'es', 'liga' => $liga->id ?? null]) }}" class="block px-4 py-2 text-gray-800 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center space-x-2 transition-colors duration-300">
                            <img src="{{ asset('Imagenes/banderaEspana.jpg') }}" width="20" class="rounded-sm"> 
                            <span>ES</span>
                        </a>
                        <a href="{{ route('locale', ['lang' => 'en', 'liga' => $liga->id ?? null]) }}" class="block px-4 py-2 text-gray-800 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center space-x-2 transition-colors duration-300">
                            <img src="{{ asset('Imagenes/banderaEEUU.jpg') }}" width="20" class="rounded-sm">
                            <span>EN</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Botón menú hamburguesa -->
            <div class="lg:hidden flex items-center space-x-3">
                <!-- Botón de modo claro/oscuro -->
                <div class="relative" x-data="{ darkMode: false }" @click="darkMode = !darkMode; document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', darkMode);"
                    x-init="darkMode = localStorage.getItem('darkMode') === 'true'; document.documentElement.classList.toggle('dark', darkMode)">
                    <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300 group">
                        <svg x-show="!darkMode" class="w-5 h-5 text-gray-600 dark:text-gray-300 group-hover:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-gray-600 dark:text-gray-300 group-hover:text-cyan-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </div>
                <!-- Menú de idiomas móvil -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-300">
                        <i class="fa-solid fa-language text-gray-600 dark:text-gray-400"></i>
                    </button>
                    
                    <div x-show="open" x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-32 bg-white dark:bg-gray-800 rounded-md shadow-lg z-50 border border-gray-200 dark:border-gray-700 overflow-hidden transition-colors duration-300">
                        <a href="{{ route('locale', ['lang' => 'es', 'liga' => $liga->id ?? null]) }}" class="block px-4 py-2 text-gray-800 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center space-x-2 transition-colors duration-300">
                            <img src="{{ asset('Imagenes/banderaEspana.jpg') }}" width="20" class="rounded-sm"> 
                            <span>ES</span>
                        </a>
                        <a href="{{ route('locale', ['lang' => 'en', 'liga' => $liga->id ?? null]) }}" class="block px-4 py-2 text-gray-800 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 flex items-center space-x-2 transition-colors duration-300">
                            <img src="{{ asset('Imagenes/banderaEEUU.jpg') }}" width="20" class="rounded-sm">
                            <span>EN</span>
                        </a>
                    </div>
                </div>

                <button @click.stop="open = !open" class="inline-flex items-center justify-center p-2 rounded-xl text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-cyan-400 hover:bg-blue-50 dark:hover:bg-gray-700 focus:outline-none transition duration-300 ease-in-out transform hover:scale-110" x-bind:aria-expanded="open">
                    <svg class="h-7 w-7" :class="{ 'hidden': open, 'block': !open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="h-7 w-7" :class="{ 'hidden': !open, 'block': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menú móvil desplegable -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="lg:hidden absolute w-full bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm shadow-xl z-50 border-t border-gray-200 dark:border-gray-800 rounded-b-2xl overflow-hidden transition-colors duration-300">

        <div class="pt-2 pb-3 space-y-2 px-4">
            @auth
                <x-responsive-nav-link 
                    :href="route('inicio')" 
                    @click="open = false"                    
                    class="block px-4 py-3 text-gray-800 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center"
                >
                    <span class="mr-3"><i class="fa-solid fa-house"></i></span>
                    @lang('messages.inicio')
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link 
                    :href="route('index')" 
                    @click="open = false" 
                    class="block px-4 py-3 text-gray-800 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center"
                >
                    <span class="mr-3"><i class="fa-solid fa-house"></i></span>
                    @lang('messages.inicio')
                </x-responsive-nav-link>
            @endauth

            <x-responsive-nav-link :href="route('jugadores')" @click="open = false"  class="block px-4 py-3 text-gray-800 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center">
                <span class="mr-3"><i class="fa-solid fa-gamepad"></i></span>
                @lang('messages.jugadores')
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('top-global')" @click="open = false"  class="block px-4 py-3 text-gray-800 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center">
                <span class="mr-3"><i class="fa-solid fa-earth-americas"></i></span>
                @lang('messages.top-global')
            </x-responsive-nav-link>
        </div>

        @auth
            <div class="pb-2 space-y-2 px-4 border-t border-gray-200 dark:border-gray-700">
                <x-responsive-nav-link :href="route('profile.edit')" class="block px-4 py-3 text-gray-800 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                   <span class="group-hover:text-blue-600 dark:group-hover:text-cyan-400 transition-colors duration-300">@lang('messages.perfil')</span>
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-3 text-gray-800 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl my-1 transition-all duration-300 hover:shadow-md hover:-translate-y-0.5 transform flex items-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors duration-300">@lang('messages.cerrar-sesion')</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        @else
            <div class="pt-2 pb-4 space-y-3 px-4 border-t border-gray-200 dark:border-gray-700">
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')" class="w-full flex items-center justify-center px-4 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 dark:from-blue-600 dark:to-cyan-600 dark:hover:from-blue-700 dark:hover:to-cyan-700 transition-all duration-300 hover:scale-105 transform shadow-md hover:shadow-lg">
                    @lang('messages.login')
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')" class="w-full flex items-center justify-center px-4 py-3 border border-blue-300 dark:border-gray-600 text-base font-medium rounded-xl text-blue-600 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-300 hover:scale-105 transform shadow-md hover:shadow-lg">
                    @lang('messages.register')
                </x-responsive-nav-link>
            </div>
        @endauth
    </div>
</nav>
<style>
    .rounded-md.bg-white {
        background-color: transparent !important;
  
    }
    [x-cloak] { display: none !important; }
    
</style>
