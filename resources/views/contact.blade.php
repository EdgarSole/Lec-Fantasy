<x-app-layout>
    <x-slot name="header">
        <div class="text-center mb-12 px-4 sm:px-0">
            <h2 class="text-4xl font-bold tracking-tight dark:text-gray-100 text-gray-800 mb-4">
                @lang('messages.contacto')
            </h2>
            
            <div class="relative max-w-md mx-auto h-1.5 rounded-full overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-amber-500 via-cyan-400 to-purple-600 dark:from-amber-400 dark:via-cyan-300 dark:to-purple-500 animate-[rgbFlow_3s_linear_infinite]"></div>
            </div>
            
            <div class="mt-3 flex justify-center space-x-2">
                <span class="inline-block w-2 h-2 rounded-full bg-cyan-400 dark:bg-cyan-300 animate-pulse"></span>
                <span class="inline-block w-2 h-2 rounded-full bg-purple-600 dark:bg-purple-400 animate-pulse delay-100"></span>
                <span class="inline-block w-2 h-2 rounded-full bg-amber-500 dark:bg-amber-400 animate-pulse delay-200"></span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen border-t border-[#3b82f6] shadow-[0_0_10px_#3b82f6] dark:border-t-1 dark:border-[#39ff14] dark:shadow-[0_0_10px_#39ff14]">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Formulario de contacto -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mb-6">@lang('messages.envianos-mensaje')</h3>
                    
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">@lang('messages.nombre')</label>
                            <input type="text" id="name" name="name" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:focus:ring-amber-600 dark:focus:border-amber-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        </div>
                        
                        <div>
                            <label for="email" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Email</label>
                            <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:focus:ring-amber-600 dark:focus:border-amber-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        </div>
                        
                        <div>
                            <label for="subject" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">@lang('messages.asunto')</label>
                            <select id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:focus:ring-amber-600 dark:focus:border-amber-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <option value="support">@lang('messages.soporte-tecnico')</option>
                                <option value="suggestions">@lang('messages.sugerencias')</option>
                                <option value="business">@lang('messages.asuntos-comerciales')</option>
                                <option value="other">@lang('messages.otro')</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">@lang('messages.mensaje')</label>
                            <textarea id="message" name="message" rows="5" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:focus:ring-amber-600 dark:focus:border-amber-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 dark:from-amber-600 dark:to-orange-600 text-white font-bold rounded-lg hover:from-amber-600 hover:to-orange-600 dark:hover:from-amber-700 dark:hover:to-orange-700 transition-all transform hover:scale-[1.02] shadow-lg shadow-amber-300/40 dark:shadow-amber-500/30">
                            @lang('messages.enviar-mensaje')
                        </button>
                    </form>
                </div>
                
                <!-- Información de contacto -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mb-6">@lang('messages.informacion-contacto')</h3>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="bg-amber-100 dark:bg-amber-900/30 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-gray-200">Email</h4>
                                <p class="text-gray-600 dark:text-gray-400">contacto@ LECFantasy.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-amber-100 dark:bg-amber-900/30 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-gray-200">@lang('messages.telefono')</h4>
                                <p class="text-gray-600 dark:text-gray-400">+34 123 456 789</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-amber-100 dark:bg-amber-900/30 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 dark:text-gray-200">@lang('messages.direccion')</h4>
                                <p class="text-gray-600 dark:text-gray-400">Calle Fantasía, 123<br>28000 Madrid, España</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-4">@lang('messages.redes-sociales')</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="bg-gray-100 dark:bg-gray-700 p-3 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                </svg>
                            </a>
                            <a href="#" class="bg-gray-100 dark:bg-gray-700 p-3 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                <svg class="w-5 h-5 text-blue-400 dark:text-blue-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                                </svg>
                            </a>
                            <a href="#" class="bg-gray-100 dark:bg-gray-700 p-3 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                                <svg class="w-5 h-5 text-pink-600 dark:text-pink-400" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>