<x-app-layout>
    <x-slot name="header">
        <div class="text-center mb-12 px-4 sm:px-0">
            <h2 class="text-4xl font-bold tracking-tight dark:text-gray-100 text-gray-800 mb-4">
                Contacto
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
                    <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mb-6">Envianos un mensaje</h3>
                    
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
                            <label for="subject" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Asunto</label>
                            <select id="subject" name="subject" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:focus:ring-amber-600 dark:focus:border-amber-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                <option value="support">Soporte Técnico</option>
                                <option value="suggestions">Sugerencia</option>
                                <option value="business">Asuntos Comerciales</option>
                                <option value="other">Otro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="message" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Mensaje</label>
                            <textarea id="message" name="message" rows="5" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 dark:focus:ring-amber-600 dark:focus:border-amber-600 outline-none transition bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200"></textarea>
                        </div>
                        
                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-500 dark:from-amber-600 dark:to-orange-600 text-white font-bold rounded-lg hover:from-amber-600 hover:to-orange-600 dark:hover:from-amber-700 dark:hover:to-orange-700 transition-all transform hover:scale-[1.02] shadow-lg shadow-amber-300/40 dark:shadow-amber-500/30">
                            Enviar mensaje
                        </button>
                    </form>
                </div>
                
                <!-- Información de contacto -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
    <h3 class="text-2xl font-bold text-amber-600 dark:text-amber-400 mb-6">Información contacto</h3>
    
    <div class="space-y-6">
        <div class="flex items-start">
            <div class="bg-amber-100 dark:bg-amber-900/30 p-3 rounded-full mr-4">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 dark:text-gray-200">Email</h4>
                <p class="text-gray-600 dark:text-gray-400">contacto@LECFantasy.com</p>
            </div>
        </div>
        
        <div class="flex items-start">
            <div class="bg-amber-100 dark:bg-amber-900/30 p-3 rounded-full mr-4">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-800 dark:text-gray-200">Teléfono</h4>
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
                <h4 class="font-bold text-gray-800 dark:text-gray-200">Dirección</h4>
                <p class="text-gray-600 dark:text-gray-400">C. de Jarque de Moncayo, 10<br>50012 Zaragoza, España</p>
            </div>
        </div>

        <!-- Mapa de Google Maps -->
        <div class="mt-6 rounded-xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2980.895533261635!2d-0.8917884237390013!3d41.64873097126196!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5914d5e618c7a9%3A0x3a0d4f0a8c6b8b1e!2sC.%20de%20Jarque%20de%20Moncayo%2C%2010%2C%2050012%20Zaragoza%2C%20Espa%C3%B1a!5e0!3m2!1ses!2sus!4v1712345678901!5m2!1ses!2sus" 
                width="100%" 
                height="300" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                class="dark:grayscale-[50%] dark:opacity-90">
            </iframe>
        </div>
    </div>
    
    
</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>