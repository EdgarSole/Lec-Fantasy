<x-app-layout>
    <x-slot name="header">
        <div class="text-center mb-12 px-4 sm:px-0">
            <h2 class="text-4xl font-bold tracking-tight dark:text-gray-100 text-gray-800 mb-4">
               
                Política de Privacidad
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
                <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-4">1. Información que recopilamos</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    En  LECFantasy, recopilamos información cuando te registras, creas una liga, participas en competiciones
                    o interactúas con nuestros servicios. Esta información puede incluir:
                </p>
                <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300 space-y-2 mb-8">
                    <li>Nombre de usuario y datos de contacto</li>
                    <li>Información de las ligas que creas o en las que participas</li>
                    <li>Datos de interacción con la plataforma</li>
                    <li>Información técnica como dirección IP y tipo de dispositivo</li>
                </ul>

                <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-4">2. Uso de la información</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Utilizamos la información recopilada para:
                </p>
                <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300 space-y-2 mb-8">
                    <li>Proporcionar y mejorar nuestros servicios</li>
                    <li>Personalizar tu experiencia en la plataforma</li>
                    <li>Comunicarnos contigo sobre actualizaciones y novedades</li>
                    <li>Garantizar la seguridad de nuestra plataforma</li>
                </ul>

                <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-4">3. Protección de datos</h3>
                <p class="text-gray-700 dark:text-gray-300 mb-6">
                    Implementamos medidas de seguridad técnicas y organizativas para proteger tus datos personales contra
                    accesos no autorizados, alteración, divulgación o destrucción.
                </p>

                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-4 border-blue-500 dark:border-blue-400 p-4 rounded-r-lg mb-8">
                    <p class="text-blue-800 dark:text-blue-200">
                        <strong>Última actualización:</strong> {{ now()->format('d/m/Y') }}
                    </p>
                </div>
            </article>
        </div>
    </div>
</x-app-layout>