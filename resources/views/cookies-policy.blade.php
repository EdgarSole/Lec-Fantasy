<x-app-layout>
    <x-slot name="header">
        <div class="text-center mb-12 px-4 sm:px-0">
            <h2 class="text-4xl font-bold tracking-tight dark:text-gray-100 text-gray-800 mb-4">
                @lang('messages.politica-cookies')
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
                <div class="flex items-start mb-6">
                    <span class="text-4xl mr-4">🍪</span>
                    <div>
                        <h3 class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-2">Uso de Cookies en  LECFantasy</h3>
                        <p class="text-gray-700 dark:text-gray-300">
                            Utilizamos cookies para mejorar tu experiencia en nuestra plataforma. Esta política explica qué son las cookies,
                            cómo las usamos y cómo puedes gestionarlas.
                        </p>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-4">1. ¿Qué son las cookies?</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web.
                    Son ampliamente utilizadas para hacer que los sitios web funcionen de manera más eficiente.
                </p>

                <h3 class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-4">2. Cookies que utilizamos</h3>
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Propósito</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">Esenciales</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">session, XSRF-TOKEN</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">Funcionamiento básico del sitio y seguridad</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">Preferencias</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">theme_preference</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">Recordar tu preferencia de tema claro/oscuro</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">Analíticas</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">_ga, _gid</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">Medir el uso de la plataforma</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="text-2xl font-bold text-purple-600 dark:text-purple-400 mb-4">3. Control de cookies</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Puedes gestionar o eliminar las cookies según tus preferencias a través de la configuración de tu navegador.
                    Ten en cuenta que deshabilitar ciertas cookies puede afectar la funcionalidad de nuestro sitio.
                </p>

                <div class="bg-purple-50 dark:bg-purple-900/20 border-l-4 border-purple-500 dark:border-purple-400 p-4 rounded-r-lg">
                    <p class="text-purple-800 dark:text-purple-200">
                        <strong>Consentimiento:</strong> Al usar nuestro sitio, aceptas el uso de cookies según esta política.
                    </p>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>