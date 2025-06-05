<x-app-layout>
    <x-slot name="header">
        <div class="text-center mb-12 px-4 sm:px-0">
            <h2 class="text-4xl font-bold tracking-tight dark:text-gray-100 text-gray-800 mb-4">
               
                Terminos y Condiciones
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 px-4 bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
            <article class="prose dark:prose-invert max-w-none">
                <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mb-4">1. Aceptación de los Términos</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Al acceder y utilizar  LECFantasy, aceptas cumplir con estos Términos y Condiciones, nuestra Política de Privacidad
                    y todas las leyes y regulaciones aplicables.
                </p>

                <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mb-4">2. Uso de la Plataforma</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    La plataforma  LECFantasy está diseñada para:
                </p>
                <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300 space-y-2 mb-6">
                    <li>Crear y gestionar ligas de fantasía deportiva</li>
                    <li>Participar en competiciones con otros usuarios</li>
                    <li>Disfrutar de una experiencia de juego justa y entretenida</li>
                </ul>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    No está permitido usar la plataforma para actividades ilegales, fraudulentas o que infrinjan derechos de terceros.
                </p>

                <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mb-4">3. Conducta del Usuario</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Los usuarios deben comportarse de manera respetuosa y deportiva. Prohibimos:
                </p>
                <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300 space-y-2 mb-8">
                    <li>Lenguaje ofensivo, discriminatorio o inapropiado</li>
                    <li>Hacking, cheating o cualquier forma de trampa</li>
                    <li>Spam o publicidad no solicitada</li>
                    <li>Suplantación de identidad</li>
                </ul>

                <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mb-4">4. Modificaciones</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Nos reservamos el derecho de modificar estos términos en cualquier momento. Las actualizaciones serán notificadas
                    a los usuarios y entrarán en vigor tras su publicación.
                </p>

                <div class="bg-emerald-50 dark:bg-emerald-900/20 border-l-4 border-emerald-500 dark:border-emerald-400 p-4 rounded-r-lg">
                    <p class="text-emerald-800 dark:text-emerald-200">
                        <strong>Vigencia:</strong> Estos términos están vigentes desde {{ now()->subDays(30)->format('d/m/Y') }}
                    </p>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>