<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{ asset('Imagenes/LecFantasyLogoV2.webp') }}" type="image/x-icon">

         <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <!-- Fonts -->
        <script defer src="https://unpkg.com/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        

        <!-- Scripts -->
         @stack('styles')

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="shadow bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300 overflow-auto">
                @stack('scripts')
                {{ $slot }}
            </main>

            <!-- Footer  -->
            <footer class="min-h-32 bg-gray-200 dark:bg-gray-700 text-black dark:text-white py-6">
                <div class="container mx-auto px-4">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <!-- Enlaces legales -->
                        <div class="flex flex-wrap gap-4 justify-center md:justify-start mb-4 md:mb-0">
                            <a href="{{ route('privacy') }}" class="hover:text-blue-300 transition">Política de Privacidad</a>
                            <a href="{{ route('terms') }}" class="hover:text-blue-300 transition">Términos y Condiciones</a>
                            <a href="{{ route('cookies') }}" class="hover:text-blue-300 transition">Política de Cookies</a>
                            <a href="{{ route('contact') }}" class="hover:text-blue-300 transition">Contacto</a>
                        </div>
                        
                        <!-- Redes sociales -->
                        <div class="flex gap-4">
                            <a href="https://www.facebook.com/" target="_blank" class="hover:text-blue-300 transition">
                                <i class="fab fa-facebook text-blue-600 dark:text-blue-400"></i> 
                            </a>
                            <a href="https://x.com/" target="_blank" class="hover:text-blue-300 transition">
                                <i class="fab fa-twitter text-blue-400 dark:text-blue-300"></i>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" class="hover:text-blue-300 transition">
                                <i class="fab fa-instagram text-pink-600 dark:text-pink-400"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Copyright -->
                    <div class="text-center mt-6 pt-4 border-t border-gray-700 dark:border-gray-300">
                        <p>&copy; {{ date('Y') }} <span class="font-bold">LECFantasy</span>. Todos los derechos reservados.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
