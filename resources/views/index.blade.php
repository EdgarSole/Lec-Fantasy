@php
    use App\Models\User;
    use App\Models\Equipo;

    $totalUsuarios = User::count();
    $totalEquipos = Equipo::count();
@endphp  
<x-app-layout>
  
<div class="relative overflow-hidden bg-gray-50 dark:bg-gray-900 transition-colors">
    <div x-data="{
            currentSlide: 0,
            slides: [
                '{{ asset('imagenes/fondo.jpg') }}',
                '{{ asset('imagenes/fondo2-estadio.jpg') }}',
                '{{ asset('imagenes/fondo3-estadio.jpg') }}',
                '{{ asset('imagenes/fondo2-arena.jpg') }}',
                '{{ asset('imagenes/fondo5-estadio.jpg') }}'
            ],
            interval: null,
            init() {
                this.startAutoPlay();
            },
            startAutoPlay() {
                this.stopAutoPlay(); // Limpia el intervalo anterior
                this.interval = setInterval(() => {
                    this.next(false); // Automático, no reinicia
                }, 5000);
            },
            stopAutoPlay() {
                if (this.interval) {
                    clearInterval(this.interval);
                    this.interval = null;
                }
            },
            next(manual = true) {
                this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                if (manual) this.startAutoPlay(); // Solo reinicia si fue clic manual
            },
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                this.startAutoPlay(); // Reinicia al hacer clic
            },
            goTo(index) {
                this.currentSlide = index;
                this.startAutoPlay(); // Reinicia al seleccionar índice
            }
        }"
        x-init="init()"
        @mouseenter="stopAutoPlay()"
        @mouseleave="startAutoPlay()"
        class="relative h-screen max-h-[800px]">

        <!-- Imágenes del carrusel -->
        <template x-for="(slide, index) in slides" :key="index">
            <div 
                x-show="currentSlide === index"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-1000"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0">
                <img 
                    :src="slide" 
                    :alt="'LEC Image ' + (index + 1)" 
                    class="w-full h-full object-cover object-center">
                <div class="absolute inset-0 bg-black bg-opacity-30"></div>
            </div>
        </template>


            <!-- Contenido sobre las imágenes -->
            <div class="relative z-10 h-full flex items-center">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                    <div class="lg:w-1/2">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <b><span class="block">@lang('messages.crea-equipo')</span>
                            <span class="block text-blue-300">LEC Fantasy</span></b>
                        </h1>
                        <p class="mt-3 text-base text-gray-200 sm:mt-5 sm:text-lg sm:max-w-xl md:mt-5 md:text-xl">
                            @lang('messages.texto-construye')
                        </p>
                        <div class="mt-8 sm:mt-10 sm:flex space-y-4 sm:space-y-0 sm:space-x-4">
                            <div class="rounded-md shadow-lg">
                                <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10 transition-all duration-300 hover:scale-105 transform">
                                    @lang('messages.empezar-ahora')
                                </a>
                            </div>  
                            <div x-data="{ open: false }" class="rounded-md shadow-lg">
                                <button 
                                    @click="open = true" 
                                    class="w-full flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-white bg-gray-800 hover:bg-gray-700 md:py-4 md:text-lg md:px-10 transition-all duration-300 hover:scale-105 transform">                                   
                                    @lang('messages.ver-tutorial')
                                </button>
                                <div 
                                    x-show="open"
                                    x-transition.opacity
                                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                                    @keydown.escape.window="open = false"
                                    style="display: none;"
                                >
                                    <div 
                                        @click.away="open = false" 
                                        x-show="open"
                                        x-transition
                                        class="bg-white p-4 rounded-lg shadow-xl max-w-3xl w-full relative mx-4"
                                    >
                                        <button 
                                            @click="open = false" 
                                            class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-2xl font-bold"
                                        >
                                            &times;
                                        </button>
                                        <div class="relative" style="padding-bottom: 56.25%; height: 0;">
                                            <iframe 
                                                class="absolute top-0 left-0 w-full h-full" 
                                                src="https://www.youtube.com/embed/-GLtM7Ur6qw" 
                                                frameborder="0" 
                                                allowfullscreen>
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flechas de navegación -->
            <button 
                @click="prev(); stopAutoPlay(); startAutoPlay();" 
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button 
                @click="next(); stopAutoPlay(); startAutoPlay();" 
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 bg-black bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Indicadores de posición -->
            <div class="absolute bottom-8 left-0 right-0 z-20 flex justify-center space-x-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button 
                        @click="goTo(index); stopAutoPlay(); startAutoPlay();" 
                        class="w-3 h-3 rounded-full transition"
                        :class="{
                            'bg-white': currentSlide === index,
                            'bg-gray-400': currentSlide !== index
                        }">
                        <span class="sr-only">Ir a slide <span x-text="index + 1"></span></span>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Features Grid -->
    <<!-- Features Grid -->
<!-- Features Grid -->
<div class="py-12 bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:text-center">
            <h2 class="text-base text-[rgb(50,155,137)] font-semibold tracking-wide uppercase">LEC Fantasy</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">                 
                 @lang('messages.como-funciona')
            </p>
            <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-300 lg:mx-auto">
                @lang('messages.necesitas-saber')      
            </p>
        </div>

        <div class="mt-10">
            <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
            <!-- Feature 1 - Cómo jugar -->
            <div class="relative bg-[#fff2ec] dark:bg-gray-800 p-6 rounded-lg shadow-md dark:shadow-lg transition-all duration-300 transform hover:scale-105 
            border-t-2 border-l-2 border-r-4 border-b-4 border-black dark:border-cyan-400">
                <div class="absolute -top-6 left-6 bg-red-600 dark:bg-red-500 text-white rounded-full p-3 shadow-md dark:shadow-cyan-400/20">
                    <span class="text-xl">🏆</span>
                </div>
                <h3 class="mt-8 text-lg font-medium text-gray-900 dark:text-gray-100">@lang('messages.como-jugar')</h3>
                <ul class="mt-4 space-y-2 text-gray-600 dark:text-gray-300">
                    <li class="flex items-start">
                        <span class="mr-2">✨</span>
                        <span>@lang('messages.selecciona-jugadores')</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">📊</span>
                        <span>@lang('messages.gana-puntos')</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">🎮</span>
                        <span>@lang('messages.gestiona-transpasos')</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">🏅</span>
                        <span>@lang('messages.compite-ligas')</span>
                    </li>
                </ul>
            </div>

            <!-- Feature 2 - Puntuación -->
            <div class="relative bg-[#fff2ec] dark:bg-gray-800 p-6 rounded-lg shadow-md dark:shadow-lg transition-all duration-300 transform hover:scale-105 
            border-t-2 border-l-2 border-r-4 border-b-4 border-black dark:border-cyan-400">
                <div class="absolute -top-6 left-6 bg-blue-600 dark:bg-blue-500 text-white rounded-full p-3 shadow-md dark:shadow-cyan-400/20">
                    <span class="text-xl">💎</span>
                </div>
                <h3 class="mt-8 text-lg font-medium text-gray-900 dark:text-gray-100">@lang('messages.puntuacion')</h3>
                <ul class="mt-4 space-y-2 text-gray-600 dark:text-gray-300">
                    <li class="flex items-start">
                        <span class="mr-2 text-green-500 dark:text-green-400">+2</span>
                        <span>@lang('messages.cada-kill') <i class="fa-solid fa-skull"></i></span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2 text-green-500 dark:text-green-400">+1</span>
                        <span>@lang('messages.cada-asistencia') <i class="fa-solid fa-handshake-angle"></i></span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2 text-green-500 dark:text-green-400">+1</span>
                        <span>@lang('messages.cada-torre') <i class="fa-solid fa-gopuram"></i></span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2 text-green-500 dark:text-green-400">+4</span>
                        <span>@lang('messages.cada-objetivo') <i class="fa-solid fa-spaghetti-monster-flying"></i></span>
                    </li>
                </ul>
            </div>

            <!-- Feature 3 - Características -->
            <div class="relative bg-[#fff2ec] dark:bg-gray-800 p-6 rounded-lg shadow-md dark:shadow-lg transition-all duration-300 transform hover:scale-105 
            border-t-2 border-l-2 border-r-4 border-b-4 border-black dark:border-cyan-400">
                <div class="absolute -top-6 left-6 bg-purple-600 dark:bg-purple-500 text-white rounded-full p-3 shadow-md dark:shadow-cyan-400/20">
                    <span class="text-xl">🌟</span>
                </div>
                <h3 class="mt-8 text-lg font-medium text-gray-900 dark:text-gray-100">@lang('messages.caracteristicas')</h3>
                <ul class="mt-4 space-y-2 text-gray-600 dark:text-gray-300">
                    <li class="flex items-start">
                        <span class="mr-2">📱</span>
                        <span>@lang('messages.aplicacion-movil')</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">🤝</span>
                        <span>@lang('messages.compras-ventas')</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">📈</span>
                        <span>@lang('messages.estadisticas-jugadores')</span>
                    </li>
                    <li class="flex items-start">
                        <span class="mr-2">🏆</span>
                        <span>@lang('messages.premios-managers')</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Pricing/Leagues Section -->
<div class="bg-gray-100 dark:bg-gray-900 py-16 sm:py-24 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:flex-col sm:align-center">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100 sm:text-4xl text-center">
                @lang('messages.ligas-publicas')
            </h2>
            <p class="mt-5 text-xl text-gray-600 dark:text-gray-300 text-center max-w-3xl mx-auto">
                @lang('messages.participa-liga')
            </p>
            <div class="relative mt-12 bg-white dark:bg-gray-800 shadow-md dark:shadow-xl rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 transition-colors duration-300">
                <!-- Leagues Grid -->
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- League Card 1 -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow dark:shadow-lg overflow-hidden border border-gray-200 dark:border-gray-600 hover:border-red-300 dark:hover:border-cyan-400 transition-colors duration-300">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-red-500 dark:bg-red-600 rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">@lang('messages.clasificacion-global')</h3>
                                    </div>
                                </div>
                            
                                <div class="mt-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('messages.usuarios')</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalUsuarios, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="mt-2 flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('messages.equipos')</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ number_format($totalEquipos, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="mt-4">
                                        <a href="{{ route('top-global') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-red-600 dark:bg-red-500 hover:bg-red-700 dark:hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105">
                                            @lang('messages.ver-clasificacion')
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- League Card 2 -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow dark:shadow-lg overflow-hidden border border-gray-200 dark:border-gray-600 hover:border-blue-300 dark:hover:border-cyan-400 transition-colors duration-300">
                            <div class="px-4 py-5 sm:p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-500 dark:bg-blue-600 rounded-md p-3">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Liga THunders</h3>
                                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">@lang('messages.liga-publica')</p>
                                    </div>
                                </div>
                                <div class="mt-6">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('messages.participantes')</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-gray-100">8/10</span>
                                    </div>
                                    <div class="mt-2 flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">@lang('messages.posicion')</span>
                                        <span class="text-sm font-bold text-gray-900 dark:text-gray-100">#2</span>
                                    </div>
                                    <div class="mt-4">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-blue-600 dark:bg-blue-500 hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105">
                                            @lang('messages.ver-liga')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Create League Card -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg shadow dark:shadow-lg overflow-hidden border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-green-300 dark:hover:border-cyan-400 transition-colors duration-300">
                            <div class="px-4 py-5 sm:p-6 h-full flex flex-col justify-center items-center text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900 dark:text-gray-100">@lang('messages.crear-nueva-liga')</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">@lang('messages.invita-amigos')</p>
                                <div class="mt-4">
                                    <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-green-500 dark:bg-green-600 hover:bg-green-600 dark:hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105">
                                        @lang('messages.crear-liga')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-[rgb(51,175,154)] dark:bg-gray-800 transition-colors duration-300">
    <div class="max-w-2xl mx-auto text-center py-16 px-4 sm:py-20 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
            <span class="block">@lang('messages.listo-competir')</span>
            <span class="block">@lang('messages.crea-equipo-ahora')</span>
        </h2>
        <p class="mt-4 text-lg leading-6 text-red-100 dark:text-cyan-100">
            @lang('messages.proxima-jornada')
        </p>
        <a href="{{ route('login') }}" class="mt-8 w-full inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-[rgb(50,155,137)] dark:text-gray-800 bg-white hover:bg-red-50 dark:hover:bg-cyan-100 sm:w-auto transition-all duration-300 transform hover:scale-105">
            @lang('messages.seleccionar-jugadores')
        </a>
    </div>
</div>
</x-app-layout>
<script>
function carousel() {   
    return {
        currentSlide: 0,
        slides: [
            '{{ asset('imagenes/fondo.jpg') }}',
            '{{ asset('imagenes/fondo2-estadio.jpg') }}',
            '{{ asset('imagenes/fondo3-estadio.jpg') }}',
            '{{ asset('imagenes/fondo2-arena.jpg') }}',
            '{{ asset('imagenes/fondo5-estadio.jpg') }}'
        ],
        interval: null,

        init() {
            this.startAutoPlay();
        },

        startAutoPlay() {
            this.stopAutoPlay(); // Asegura que no haya múltiples intervalos activos
            this.interval = setInterval(() => {
                this.next(false);
            }, 5000);
        },

        stopAutoPlay() {
            if (this.interval) {
                clearInterval(this.interval);
                this.interval = null;
            }
        },

        next(manual = true) {
            this.currentSlide = (this.currentSlide + 1) % this.slides.length;
            if (manual) this.startAutoPlay(); // Reinicia el intervalo si fue una acción manual
        },

        prev() {
            this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            this.startAutoPlay(); // También reinicia el temporizador
        },

        goTo(index) {
            this.currentSlide = index;
            this.startAutoPlay(); // Reinicia al seleccionar manualmente
        }
    }
}
</script>