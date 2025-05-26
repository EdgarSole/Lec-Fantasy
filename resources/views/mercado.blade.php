@extends('layouts.ligaMenu')

@section('content')
<div class="dark:bg-gray-900 min-h-screen">
    <div class="container mx-auto px-4 py-6">
        <!-- Header con presupuesto y contador - Modo oscuro -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white dark:bg-gray-800 rounded-lg shadow-md dark:shadow-lg dark:shadow-gray-700/50 p-4 mb-6 gap-4">
            <div class="flex items-center flex-wrap gap-2">
                <span class="font-bold text-lg text-gray-800 dark:text-gray-200">@lang('messages.presupuesto'):</span>
                <span class="text-green-600 dark:text-green-400 font-bold text-lg">{{ number_format($equipo->presupuesto, 0, ',', '.') }} €</span>
                @if($pujasUsuario->sum('cantidad') > 0)
                    <span class="text-red-500 dark:text-red-400 font-medium">-{{ number_format($pujasUsuario->sum('cantidad'), 0, ',', '.') }} €</span>
                @endif
            </div>
            <div class="flex items-center gap-4">                
                <div class="bg-white/60 dark:bg-gray-700/80 backdrop-blur-sm border border-blue-200 dark:border-blue-600 px-5 py-2 rounded-full font-bold text-blue-700 dark:text-blue-300 shadow-inner">
                    ⏳ @lang('messages.proxima_actualizacion'): 
                    <span id="contador" class="font-mono text-pink-600 dark:text-pink-400">
                        {{ str_pad(intval($tiempoRestante['horas']), 2, '0', STR_PAD_LEFT) }}h
                        {{ str_pad(intval($tiempoRestante['minutos']), 2, '0', STR_PAD_LEFT) }}m
                        {{ str_pad(intval($tiempoRestante['segundos']), 2, '0', STR_PAD_LEFT) }}s
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de jugadores -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 px-4 pb-6">
        @foreach($mercadoActual as $item)
        <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-md hover:shadow-lg dark:hover:shadow-gray-700/50 transition-all duration-300 border-2 border-gray-200 dark:border-gray-700 flex flex-col h-full transform hover:-translate-y-1">
            <!-- Imagen del jugador con overlay -->
            <div class="h-48 overflow-hidden relative">
                <img src="{{ $item->jugador->imagen_url }}" alt="{{ $item->jugador->nombre }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-3">
                    <h3 class="font-bold text-xl text-white">{{ $item->jugador->nombre }}</h3>
                    <p class="text-gray-200 text-sm">{{ $item->jugador->posicion }} • {{ $item->jugador->equipo_real }}</p>
                </div>
            </div>
            @php
                $kills = $item->jugador->estadisticas->kills ?? 0;
                $muertes = $item->jugador->estadisticas->muertes ?? 0;
                $asistencias = $item->jugador->estadisticas->asistencias ?? 0;
                $kda = number_format(($kills + $asistencias) / ($muertes ?: 1), 2);
                
            @endphp
            <!-- Información del jugador -->
            <div class="p-4 flex-grow">
                <!-- Estadísticas rápidas -->
                <div class="flex justify-between mb-3">
                    <div class="text-center">
                        <span class="block text-xs text-gray-500 dark:text-gray-400">@lang('messages.puntos_min')</span>
                        <span class="text-blue-500 dark:text-blue-400 font-bold">{{ $item->jugador->puntos }} pts</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-xs text-gray-500 dark:text-gray-400">@lang('messages.valor')</span>
                        <span class="text-green-600 dark:text-green-400 font-bold">{{ number_format($item->jugador->valor, 0, ',', '.') }} €</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-xs text-gray-500 dark:text-gray-400">KDA</span>
                        <span class="text-purple-500 dark:text-purple-400 font-bold">{{ $kda }}</span>
                    </div>
                </div>
                
                <!-- Tabla de pujas mejorada -->
                <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">@lang('messages.historial_pujas')</h4>
                    <div class="overflow-auto max-h-40 scrollbar-thin">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">@lang('messages.equipo_min')</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">@lang('messages.puja_min')</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="pujas-body-{{ $item->id }}">
                                @foreach($item->pujas as $index => $puja)
                                <tr class="{{ $index % 2 === 0 ? 'bg-gray-50 dark:bg-gray-700/50' : 'bg-white dark:bg-gray-800' }}">
                                    <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">{{ $index + 1 }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $puja->equipo->usuario->nombre }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200 font-semibold">{{ number_format($puja->cantidad, 0, ',', '.') }} €</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Botón de puja  -->
            <button class="mt-auto w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 dark:from-blue-600 dark:to-purple-700 text-white font-bold hover:from-blue-600 hover:to-purple-700 dark:hover:from-blue-700 dark:hover:to-purple-800 transition-all duration-300 flex items-center justify-center gap-2"
                onclick="abrirModalPuja(
                    '{{ $item->id }}',
                    '{{ addslashes($item->jugador->nombre) }}',
                    '{{ $item->jugador->valor }}',
                    '{{ $equipo->presupuesto - $pujasUsuario->sum('cantidad') + ($pujasUsuario[$item->id]->cantidad ?? 0) }}',
                    '{{ $pujasUsuario[$item->id]->cantidad ?? 0 }}'
                )">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                {{ isset($pujasUsuario[$item->id]) ? __('messages.modificar-puja') : __('messages.pujar') }}
            </button>
        </div>
        @endforeach
    </div>

    <!-- Modal de Puja mejorado -->
    <div class="fixed inset-0 bg-black bg-opacity-50 dark:bg-opacity-70 flex items-center justify-center z-50 hidden" id="pujaModal">
        <div class="bg-white dark:bg-gray-800 rounded-lg w-full max-w-md mx-4 shadow-xl">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white"> @lang('messages.pujar_por') <span id="jugadorNombreModal" class="text-blue-600 dark:text-blue-400"></span></h3>
            </div>
            
            <form id="pujaForm" method="POST" action="{{ route('mercado.pujar', $liga) }}" class="p-4">
                @csrf
                <input type="hidden" name="mercado_id" id="mercadoIdModal">
                
                <div class="mb-4">
                    <label for="cantidadModal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"> @lang('messages.cantidad') (€)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 dark:text-gray-400">€</span>
                        </div>
                        <input type="number" id="cantidadModal" name="cantidad"     
                               class="focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-600 dark:focus:border-blue-600 block w-full pl-10 pr-12 py-2 border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-white" 
                               required min="0" step="1">
                    </div>
                    
                    <div class="mt-4">
                        <input type="range" id="cantidadRangeModal" min="0" step="1" 
                               class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-lg appearance-none cursor-pointer accent-blue-600 dark:accent-blue-500">
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <span id="minValueModal">0 €</span>
                            <span id="maxPresupuestoModal">0 €</span>
                        </div>
                    </div>
                    
                    <p id="errorPresupuestoModal" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden">No puedes superar tu presupuesto disponible </p>
                    <p id="errorMinimoModal" class="mt-2 text-sm text-red-600 dark:text-red-400 hidden">La puja mínima es <span id="valorMinimo"></span> €</p>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                         @lang('messages.cancelar')
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        {{ isset($pujasUsuario[$item->id]) ? __('messages.modificar-puja') : __('messages.pujar') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Función para abrir el modal de puja
    function abrirModalPuja(mercadoId, jugador, valorJugador, maxPresupuesto, pujaActual) {
        // Configurar valores mínimos y máximos
        const valorMinimo = parseFloat(valorJugador);
        const actual = pujaActual ? parseFloat(pujaActual) : valorMinimo;
        const max = parseFloat(maxPresupuesto);

        // Actualizar elementos del modal
        document.getElementById('jugadorNombreModal').textContent = jugador;
        document.getElementById('mercadoIdModal').value = mercadoId;
        document.getElementById('cantidadModal').value = actual;
        document.getElementById('cantidadRangeModal').value = actual;
        document.getElementById('cantidadRangeModal').min = valorMinimo;
        document.getElementById('cantidadModal').min = valorMinimo;
        document.getElementById('minValueModal').textContent = valorMinimo.toLocaleString('es-ES') + ' €';
        document.getElementById('maxPresupuestoModal').textContent = max.toLocaleString('es-ES') + ' €';
        document.getElementById('cantidadRangeModal').max = max;
        document.getElementById('valorMinimo').textContent = valorMinimo.toLocaleString('es-ES');
        
        // Mostrar modal
        document.getElementById('pujaModal').classList.remove('hidden');
        
        // Configurar eventos para sincronización
        document.getElementById('cantidadModal').addEventListener('input', actualizarBarra);
        document.getElementById('cantidadRangeModal').addEventListener('input', actualizarInput);
    }
    
    function actualizarBarra() {
        const input = document.getElementById('cantidadModal');
        const range = document.getElementById('cantidadRangeModal');
        const value = parseFloat(input.value) || 0;
        
        range.value = value;
        validarPuja();
    }
    
    function actualizarInput() {
        const input = document.getElementById('cantidadModal');
        const range = document.getElementById('cantidadRangeModal');
        
        input.value = range.value;
        validarPuja();
    }
    
    function validarPuja() {
        const input = document.getElementById('cantidadModal');
        const range = document.getElementById('cantidadRangeModal');
        const errorPresupuesto = document.getElementById('errorPresupuestoModal');
        const errorMinimo = document.getElementById('errorMinimoModal');
        
        const value = parseFloat(input.value) || 0;
        const min = parseFloat(range.min);
        const max = parseFloat(range.max);
        
        // Validar mínimo
        if (value < min) {
            errorMinimo.classList.remove('hidden');
        } else {
            errorMinimo.classList.add('hidden');
        }
        
        // Validar máximo
        if (value > max) {
            errorPresupuesto.classList.remove('hidden');
        } else {
            errorPresupuesto.classList.add('hidden');
        }
    }
    
    // Función para cerrar el modal
    function cerrarModal() {
        document.getElementById('pujaModal').classList.add('hidden');
        // Limpiar event listeners
        document.getElementById('cantidadModal').removeEventListener('input', actualizarBarra);
        document.getElementById('cantidadRangeModal').removeEventListener('input', actualizarInput);
    }
    
    // Validación del formulario de puja
    document.getElementById('pujaForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const cantidad = parseFloat(document.getElementById('cantidadModal').value) || 0;
        const min = parseFloat(document.getElementById('cantidadRangeModal').min);
        const max = parseFloat(document.getElementById('cantidadRangeModal').max);
        
        if (cantidad < min || cantidad > max) {
            validarPuja();
            return false;
        }
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar la interfaz con los nuevos datos
                actualizarInterfaz(data);
                cerrarModal();
                
                // Mostrar notificación de éxito
                mostrarNotificacion('success', data.message || 'Puja realizada con éxito');
            } else {
                mostrarNotificacion('error', data.message || 'Error al realizar la puja');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarNotificacion('error', 'Error de conexión');
        });
    });

    // Función para actualizar la interfaz con los nuevos datos
    function actualizarInterfaz(data) {
        // Actualizar presupuesto
        const presupuestoElement = document.querySelector('.text-green-600.font-bold.text-lg');
        const pujasTotalesElement = document.querySelector('.text-red-500.font-medium');
        
        if (presupuestoElement) {
            presupuestoElement.textContent = data.presupuesto_restante.toLocaleString('es-ES') + ' €';
        }
        
        // Actualizar total de pujas
        if (data.pujas_totales !== undefined && data.pujas_totales > 0) {
            const formattedPujas = data.pujas_totales.toLocaleString('es-ES') + ' €';
            
            if (!pujasTotalesElement) {
                // Crear elemento si no existe
                const container = document.querySelector('.flex.items-center.flex-wrap.gap-2');
                if (container) {
                    const newElement = document.createElement('span');
                    newElement.className = 'text-red-500 dark:text-red-400 font-medium';
                    newElement.textContent = '-' + formattedPujas;
                    container.appendChild(newElement);
                }
            } else {
                // Actualizar elemento existente
                pujasTotalesElement.textContent = '-' + formattedPujas;
            }
        } else if (pujasTotalesElement) {
            // Eliminar si no hay pujas
            pujasTotalesElement.remove();
        }

        // Actualizar tabla de pujas
        const pujasBody = document.querySelector(`#pujas-body-${data.mercado_id}`);
        if (pujasBody && data.pujas_mercado) {
            pujasBody.innerHTML = '';
            
            data.pujas_mercado.forEach((puja, index) => {
                const row = document.createElement('tr');
                row.className = index % 2 === 0 ? 'bg-gray-50 dark:bg-gray-700/50' : 'bg-white dark:bg-gray-800';
                
                row.innerHTML = `
                    <td class="px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">${index + 1}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${puja.equipo_nombre}</td>
                    <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200 font-semibold">${puja.cantidad.toLocaleString('es-ES')} €</td>
                `;
                
                pujasBody.appendChild(row);
            });
        }
        
        // Actualizar botón de puja para este jugador
        const botonPuja = document.querySelector(`button[onclick*="${data.mercado_id}"]`);
        if (botonPuja) {
            botonPuja.textContent = data.cantidad_pujada > 0 ? 'Modificar Puja' : 'Pujar';
            // Actualizar el onclick con los nuevos datos
            const nuevoMaxPresupuesto = data.presupuesto_restante + (data.cantidad_pujada || 0);
            botonPuja.setAttribute('onclick', 
                `abrirModalPuja('${data.mercado_id}', '${data.jugador_nombre.replace(/'/g, "\\'")}', 
                '${data.jugador_valor}', '${nuevoMaxPresupuesto}', '${data.cantidad_pujada || 0}')`);
        }
    }

    // Función para mostrar notificaciones
    function mostrarNotificacion(tipo, mensaje) {
        const notificacion = document.createElement('div');
        notificacion.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg text-white ${
            tipo === 'success' ? 'bg-green-500' : 'bg-red-500'
        } z-50 flex items-center gap-2`;
        notificacion.innerHTML = `
            ${tipo === 'success' ? 
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>' : 
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>'}
            <span>${mensaje}</span>
        `;
        document.body.appendChild(notificacion);
        
        setTimeout(() => {
            notificacion.classList.add('opacity-0', 'transition-opacity', 'duration-500');
            setTimeout(() => notificacion.remove(), 500);
        }, 3000);
    }
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('pujaModal').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModal();
        }
    });
    
    // Contador de actualización
    function iniciarContador() {
        const contador = document.getElementById('contador');
        if (!contador) return;

        let segundos = Math.floor({{ $tiempoRestante['total_segundos'] }});
        
        function actualizar() {
            const horas = Math.floor(segundos / 3600);
            const minutos = Math.floor((segundos % 3600) / 60);
            const segs = segundos % 60;
            
            contador.textContent = 
                `${String(horas).padStart(2, '0')}h ${String(minutos).padStart(2, '0')}m ${String(segs).padStart(2, '0')}s`;
            
            if (segundos <= 0) {
                contador.textContent = "Procesando pujas...";
                
                fetch('{{ route("mercado.procesar", $liga) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        mostrarNotificacion('success', data.message);
                        if (data.shouldReload) {
                            setTimeout(() => location.reload(), 1500);
                        }
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    contador.textContent = "Error procesando pujas";
                    mostrarNotificacion('error', error.message);
                });
                
                return;
            }
            
            segundos--;
            setTimeout(actualizar, 1000);
        }
        
        actualizar();
    }
    
    
    
    // Iniciar contador cuando la página cargue
    document.addEventListener('DOMContentLoaded', function() {
        iniciarContador();
        
     
        
        // También puedes inicializar otros elementos aquí si es necesario
        if (document.getElementById('pujaForm')) {
            document.getElementById('pujaForm').addEventListener('submit', function(e) {
                e.preventDefault();
                // El handler de submit ya está definido arriba
            });
        }
    });
</script>

<style>
    .scrollbar-thin::-webkit-scrollbar {
        width: 5px;
        height: 5px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-track {
        background: rgba(209, 213, 219, 0.3);
        border-radius: 10px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 10px;
    }
    
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: rgba(107, 114, 128, 0.6);
    }
    
    /* Transiciones suaves para el modo oscuro */
    html {
        transition: color 200ms, background-color 200ms;
    }
</style>
@endsection