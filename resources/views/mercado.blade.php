@extends('layouts.ligaMenu')

@section('content')
<div class="dark:bg-gray-900 min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 overflow-y-auto">
    <!-- Simplified background particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-30">
        <div class="absolute top-1/4 left-1/4 w-1 h-1 bg-yellow-400 rounded-full"></div>
        <div class="absolute top-1/3 right-1/4 w-1 h-1 bg-blue-400 rounded-full"></div>
        <div class="absolute bottom-1/4 left-1/3 w-1 h-1 bg-purple-400 rounded-full"></div>
    </div>
    
    <div class="container mx-auto px-4 py-6 relative z-10">
        <!-- Gaming Header -->
        <div class="relative mb-8 sticky top-0 z-10 bg-gradient-to-br from-purple-900/95 via-blue-900/95 to-indigo-900/95 backdrop-blur-lg pt-4 rounded-2xl">
            <!-- Glow effect -->
            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/20 to-purple-500/20 rounded-2xl blur-xl"></div>
            
            <!-- Main header -->
            <div class="relative bg-gradient-to-r from-gray-900/95 to-gray-800/95 backdrop-blur-lg border border-cyan-500/40 rounded-2xl p-6 shadow-2xl">
                <!-- Title -->
                <div class="text-center mb-6">
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent mb-2 flex items-center justify-center gap-3">
                        MERCADO DE TRANSFERENCIAS
                    </h1>
                    <p class="text-gray-300 text-lg">Compite por los mejores jugadores</p>
                </div>
                
                <!-- Stats and Timer -->
                <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                    <!-- Budget Section -->
                    <div class="flex items-center gap-6 bg-gray-800/50 rounded-xl p-4 border border-green-500/30">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-coins text-white text-xl"></i>
                            </div>
                            <div>
                                <span class="text-gray-400 text-sm block">@lang('messages.presupuesto')</span>
                                <span class="text-green-400 font-bold text-xl">{{ number_format($equipo->presupuesto, 0, ',', '.') }} €</span>
                            </div>
                        </div>
                        @if($pujasUsuario->sum('cantidad') > 0)
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-pink-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-chart-line-down text-white text-xl"></i>
                                </div>
                                <div>
                                    <span class="text-gray-400 text-sm block">En Pujas</span>
                                    <span class="text-red-400 font-bold text-xl">-{{ number_format($pujasUsuario->sum('cantidad'), 0, ',', '.') }} €</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Timer Section -->
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/30 to-purple-500/30 rounded-xl blur-lg"></div>
                        <div class="relative bg-gray-800/90 backdrop-blur-sm border-2 border-blue-400/70 px-6 py-4 rounded-xl shadow-lg">
                            <div class="text-center">
                                <span class="text-blue-300 text-sm mb-1 flex items-center justify-center gap-2">
                                    <i class="fas fa-clock"></i>
                                    @lang('messages.proxima_actualizacion')
                                </span>
                                <div id="contador" class="font-mono text-2xl font-bold bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">
                                    {{ str_pad(intval($tiempoRestante['horas']), 2, '0', STR_PAD_LEFT) }}h
                                    {{ str_pad(intval($tiempoRestante['minutos']), 2, '0', STR_PAD_LEFT) }}m
                                    {{ str_pad(intval($tiempoRestante['segundos']), 2, '0', STR_PAD_LEFT) }}s
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Market Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 w-full pb-8 mt-8">
            @foreach($mercadoActual as $item)
            <div class="gamer-card glass-card relative rounded-2xl overflow-hidden shadow-2xl group flex flex-col h-full border-2 border-cyan-500/20 hover:border-cyan-500/50 transition-all duration-300">
                <div class="absolute inset-0 bg-gradient-to-br from-gray-900/98 via-gray-800/98 to-gray-900/98 z-0"></div>
                
                <!-- Efecto de borde brillante animado -->
                <div class="absolute inset-0 opacity-20 group-hover:opacity-40 transition-opacity duration-500 bg-[radial-gradient(circle_at_50%_50%,rgba(34,211,238,0.1),transparent_50%)]"></div>
                
                <div class="relative z-10 p-6 pb-0 flex items-start gap-4">
                    <!-- Player Image Container -->
                    <div class="relative group-hover:scale-105 transition-transform duration-500 flex-shrink-0">
                        <div class="w-24 h-24 rounded-2xl overflow-hidden border-2 border-cyan-500/50 shadow-[0_0_20px_rgba(6,182,212,0.4)] group-hover:shadow-[0_0_30px_rgba(6,182,212,0.6)] transition-all duration-500 relative bg-gradient-to-br from-gray-900 to-gray-800 z-20">
                            <img src="{{ $item->jugador->imagen_url }}" 
                                 alt="{{ $item->jugador->nombre }}" 
                                 class="w-full h-full object-cover relative z-30" 
                                 style="object-position: center; background: transparent;">
                        </div>
                    </div>
                    
                    <div class="flex-grow pt-1 min-w-0">
                        <div class="flex flex-col gap-2">
                            <h3 class="text-2xl font-black text-white group-hover:text-cyan-300 transition-colors drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)]">
                                {{ $item->jugador->nombre }}
                            </h3>
                            <div class="flex items-center gap-2 bg-gray-800/90 backdrop-blur-sm px-3 py-1.5 rounded-lg border border-cyan-500/40 w-fit shadow-lg">
                                @if(isset($logosEquipos[$item->jugador->equipo_real]))
                                    <img src="{{ $logosEquipos[$item->jugador->equipo_real] }}" 
                                         alt="{{ $item->jugador->equipo_real }}" 
                                         class="w-5 h-5 object-contain rounded-full border border-white/20 bg-white dark:bg-gray-400 p-0.5">
                                @else
                                    <i class="fas fa-shield-alt text-cyan-400"></i>
                                @endif
                                <span class="text-xs font-bold text-cyan-200 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                                    {{ $item->jugador->equipo_real }}
                                </span>
                            </div>
                        </div>
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
                    <!-- Estadísticas gaming style -->
                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <div class="bg-gradient-to-br from-blue-950 to-black rounded-xl p-2 border-2 border-blue-500/60 text-center min-h-[70px] flex flex-col justify-center hover:border-blue-400 transition-colors group/stat shadow-lg shadow-blue-500/30">
                            <div class="text-blue-300 text-xs font-black uppercase tracking-wider mb-1 flex items-center justify-center gap-1 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                                <i class="fas fa-bolt text-[10px]"></i> Pts
                            </div>
                            <div class="text-white font-black text-2xl group-hover/stat:text-blue-300 transition-colors drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)]">{{ $item->jugador->puntos }}</div>
                        </div>
                        <div class="bg-gradient-to-br from-green-950 to-black rounded-xl p-2 border-2 border-green-500/60 text-center min-h-[70px] flex flex-col justify-center hover:border-green-400 transition-colors group/stat shadow-lg shadow-green-500/30">
                            <div class="text-green-300 text-xs font-black uppercase tracking-wider mb-1 flex items-center justify-center gap-1 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                                <i class="fas fa-gem text-[10px]"></i> Valor
                            </div>
                            <div class="text-white font-black text-sm group-hover/stat:text-green-300 transition-colors drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)]">{{ number_format($item->jugador->valor/1000, 0) }}K€</div>
                        </div>
                        <div class="bg-gradient-to-br from-purple-950 to-black rounded-xl p-2 border-2 border-purple-500/60 text-center min-h-[70px] flex flex-col justify-center hover:border-purple-400 transition-colors group/stat shadow-lg shadow-purple-500/30">
                            <div class="text-purple-300 text-xs font-black uppercase tracking-wider mb-1 flex items-center justify-center gap-1 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                                <i class="fas fa-crosshairs text-[10px]"></i> KDA
                            </div>
                            <div class="text-white font-black text-2xl group-hover/stat:text-purple-300 transition-colors drop-shadow-[0_2px_8px_rgba(0,0,0,0.9)]">{{ $kda }}</div>
                        </div>
                    </div>
                
                    <!-- Tabla de pujas gaming style -->
                    <div class="mt-4 pt-4 border-t border-cyan-500/30">
                        <h4 class="text-xs font-black text-cyan-300 uppercase tracking-wider mb-3 flex items-center gap-2 drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                            <i class="fas fa-trophy text-yellow-400 drop-shadow-[0_2px_8px_rgba(234,179,8,0.5)]"></i> @lang('messages.historial_pujas')
                        </h4>
                        <div class="overflow-auto max-h-32 scrollbar-thin bg-black/40 rounded-lg border border-cyan-500/30 p-1">
                            @if($item->pujas->count() > 0)
                                @foreach($item->pujas->sortByDesc('cantidad')->take(3) as $index => $puja)
                                <div class="flex justify-between items-center p-2 rounded mb-1 {{ $index === 0 ? 'bg-gradient-to-r from-yellow-500/30 to-transparent border-l-4 border-yellow-400' : 'hover:bg-white/10' }} transition-colors">
                                    <div class="flex items-center gap-2">
                                        @if($index === 0)
                                            <span class="w-5 h-5 bg-yellow-500 rounded flex items-center justify-center text-[10px] font-black text-black shadow-lg shadow-yellow-500/50">1</span>
                                        @else
                                            <span class="w-5 h-5 bg-gray-700 rounded flex items-center justify-center text-[10px] font-bold text-gray-300">{{ $index + 1 }}</span>
                                        @endif
                                        <span class="text-gray-200 text-xs font-bold truncate max-w-[100px] drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">{{ $puja->equipo->usuario->nombre }}</span>
                                    </div>
                                    <span class="{{ $index === 0 ? 'text-yellow-300 font-black' : 'text-gray-300 font-bold' }} text-xs drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">{{ number_format($puja->cantidad, 0, ',', '.') }}€</span>
                                </div>
                                @endforeach
                            @else
                                <div class="text-gray-400 text-xs text-center py-4 italic font-semibold drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                                    @lang('messages.sin_pujas')
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Botón de puja gaming style -->
                    <div class="mt-4 pt-0">
                        <button class="group w-full py-3 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white font-black uppercase tracking-wider rounded-xl transition-all duration-300 flex items-center justify-center gap-3 shadow-lg shadow-cyan-500/20 hover:shadow-cyan-500/40 transform hover:translate-y-[-2px] border border-cyan-400/30 relative overflow-hidden"
                    onclick="abrirModalPuja(
                        '{{ $item->id }}',
                        '{{ addslashes($item->jugador->nombre) }}',
                        '{{ $item->jugador->valor }}',
                        '{{ $equipo->presupuesto - $pujasUsuario->sum('cantidad') + ($pujasUsuario[$item->id]->cantidad ?? 0) }}',
                        '{{ $pujasUsuario[$item->id]->cantidad ?? 0 }}'
                    )">
                            <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                            <i class="fas fa-gavel text-lg group-hover:rotate-12 transition-transform duration-300"></i>
                            <span class="text-sm">{{ isset($pujasUsuario[$item->id]) ? __('messages.modificar-puja') : __('messages.pujar') }}</span>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    <!-- Modal de Puja Gaming Style -->
    <div class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-[9999999] hidden" id="pujaModal">
        <div class="relative">
            <!-- Glow effect -->
            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/30 to-purple-500/30 rounded-2xl blur-xl"></div>
            
            <!-- Modal content -->
            <div class="relative bg-gradient-to-br from-gray-900/95 to-gray-800/95 backdrop-blur-lg rounded-2xl w-full max-w-md mx-4 shadow-2xl border border-cyan-500/30">
                <!-- Header -->
                <div class="p-6 border-b border-gray-600/50">
                    <h3 class="text-2xl font-bold text-center">
                        <span class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent flex items-center justify-center gap-2">
                            <i class="fas fa-gavel"></i> @lang('messages.pujar_por')
                        </span>
                        <br>
                        <span id="jugadorNombreModal" class="text-white text-xl"></span>
                    </h3>
                </div>
            
                <!-- Form -->
                <form id="pujaForm" method="POST" action="{{ route('mercado.pujar', $liga) }}" class="p-6">
                    @csrf
                    <input type="hidden" name="mercado_id" id="mercadoIdModal">
                    
                    <div class="mb-6">
                        <label for="cantidadModal" class="flex items-center gap-2 text-sm font-bold text-cyan-300 mb-3">
                            <i class="fas fa-coins"></i> @lang('messages.cantidad') (€)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-green-400 font-bold text-lg">€</span>
                            </div>
                            <input type="number" id="cantidadModal" name="cantidad"     
                                   class="w-full pl-12 pr-4 py-4 bg-gray-800/50 border border-cyan-500/30 rounded-xl text-white text-lg font-bold focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 transition-all" 
                                   required min="0" step="1" placeholder="0">
                        </div>
                    
                        <!-- Gaming Range Slider -->
                        <div class="mt-6">
                            <input type="range" id="cantidadRangeModal" min="0" step="1" 
                                   class="w-full h-3 bg-gray-700 rounded-lg appearance-none cursor-pointer slider-thumb">
                            <div class="flex justify-between text-sm text-gray-400 mt-2">
                                <span id="minValueModal" class="text-green-400 font-bold">0 €</span>
                                <span id="maxPresupuestoModal" class="text-cyan-400 font-bold">0 €</span>
                            </div>
                        </div>
                        
                        <!-- Error Messages -->
                        <div class="mt-4 space-y-2 relative z-50">
                            <p id="errorPresupuestoModal" class="text-sm text-red-400 font-bold bg-red-500/10 border border-red-500/30 rounded-lg p-2 items-center gap-2" style="display: none;">
                                <i class="fas fa-times-circle"></i> No puedes superar tu presupuesto disponible
                            </p>
                            <p id="errorMinimoModal" class="text-sm text-yellow-400 font-bold bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-2 items-center gap-2" style="display: none;">
                                <i class="fas fa-exclamation-triangle"></i> La puja mínima es <span id="valorMinimo"></span> €
                            </p>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-4 pt-6 border-t border-gray-600/50">
                        <button type="button" onclick="cerrarModal()" class="flex-1 py-3 bg-gray-700 hover:bg-gray-600 text-white font-bold rounded-xl transition-all duration-300 border border-gray-600 flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i> @lang('messages.cancelar')
                        </button>
                        <button type="submit" class="flex-1 py-3 bg-gradient-to-r from-cyan-500 to-purple-600 hover:from-cyan-400 hover:to-purple-500 text-white font-bold rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-cyan-500/25">
                            <i class="fas fa-gavel"></i>
                            <span>{{ isset($pujasUsuario[$item->id]) ? __('messages.modificar-puja') : __('messages.pujar') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
            errorMinimo.style.display = 'flex';
        } else {
            errorMinimo.style.display = 'none';
        }
        
        // Validar máximo
        if (value > max) {
            errorPresupuesto.style.display = 'flex';
        } else {
            errorPresupuesto.style.display = 'none';
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
                // Mostrar notificación de éxito flotante
                mostrarNotificacion('success', data.message || '¡Puja realizada con éxito! 🎉');
                
                // Actualizar la interfaz con los nuevos datos
                actualizarInterfaz(data);
                cerrarModal();
                
                // Recargar después de 2 segundos
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
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
        notificacion.className = `fixed top-4 left-1/2 transform -translate-x-1/2 px-6 py-4 rounded-xl shadow-2xl text-white ${
            tipo === 'success' ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-red-500 to-pink-600'
        } z-[9999999] flex items-center gap-3 border-2 ${
            tipo === 'success' ? 'border-green-400' : 'border-red-400'
        } backdrop-blur-lg w-fit max-w-2xl`;
        notificacion.innerHTML = `
            ${tipo === 'success' ? 
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>' : 
                '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>'}
            <span class="font-bold text-base">${mensaje}</span>
        `;
        document.body.appendChild(notificacion);
        
        // Añadir animación de entrada
        notificacion.style.opacity = '0';
        setTimeout(() => {
            notificacion.style.opacity = '1';
            notificacion.style.transition = 'opacity 0.3s ease-out';
        }, 100);
        
        setTimeout(() => {
            notificacion.style.opacity = '0';
            setTimeout(() => notificacion.remove(), 300);
        }, 5000);
    }
    
    // Cerrar modal al hacer clic fuera
    document.getElementById('pujaModal').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModal();
            

        }
    });
    
    // Contador de actualización progresivo
    function iniciarContador() {
        const contador = document.getElementById('contador');
        if (!contador) return;

        // Obtener tiempo restante del servidor (en segundos)
        let segundosRestantes = Math.floor({{ $tiempoRestante['total_segundos'] ?? 0 }});
        let mercadoFinalizado = false;
        
        // Si ya no hay tiempo desde el inicio, no iniciar el contador
        if (segundosRestantes <= 0) {
            contador.textContent = "🎯 Creando nuevo mercado...";
            setTimeout(() => {
                window.location.reload();
            }, 2000);
            return;
        }
        
        function actualizar() {
            if (mercadoFinalizado) return;
            
            // Si no hay tiempo restante, mostrar que está procesando
            if (segundosRestantes <= 0) {
                if (!mercadoFinalizado) {
                    mercadoFinalizado = true;
                    contador.textContent = "🎯 Procesando...";
                    mostrarNotificacion('success', '¡El mercado ha finalizado! Procesando pujas...');
                    
                    // Recargar después de 3 segundos
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                }
                return;
            }
            
            const horas = Math.floor(segundosRestantes / 3600);
            const minutos = Math.floor((segundosRestantes % 3600) / 60);
            const segs = Math.floor(segundosRestantes % 60);
            
            contador.textContent = 
                `${String(horas).padStart(2, '0')}h ${String(minutos).padStart(2, '0')}m ${String(segs).padStart(2, '0')}s`;
            
            segundosRestantes--;
            
            // Continuar actualizando cada segundo
            setTimeout(actualizar, 1000);
        }
        
        actualizar();
    }

    
    
    
    // Iniciar contador cuando la página cargue
    document.addEventListener('DOMContentLoaded', function() {
        // Solicitar permisos de notificación
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission().then(function(permission) {
                if (permission === 'granted') {
                    mostrarNotificacion('success', '🔔 Notificaciones activadas para el mercado');
                }
            });
        }
        
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
    /* Custom Scrollbar */
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: rgba(31, 41, 55, 0.5);
        border-radius: 4px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: rgba(34, 211, 238, 0.5);
        border-radius: 4px;
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: rgba(34, 211, 238, 0.8);
    }

    /* Custom Range Slider */
    input[type=range] {
        -webkit-appearance: none; 
        background: transparent; 
    }
    
    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 24px;
        width: 24px;
        border-radius: 50%;
        background: #22d3ee;
        cursor: pointer;
        margin-top: -10px; 
        box-shadow: 0 0 10px rgba(34, 211, 238, 0.5);
        border: 2px solid #fff;
    }
    
    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 4px;
        cursor: pointer;
        background: #374151;
        border-radius: 2px;
    }

    /* Card Hover Effects */
    .gamer-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .gamer-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -5px rgba(34, 211, 238, 0.15);
    }
    .gamer-card::before {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 1rem;
        padding: 2px;
        background: linear-gradient(45deg, transparent, rgba(34, 211, 238, 0.3), transparent);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0.5;
        transition: opacity 0.3s ease;
    }
    .gamer-card:hover::before {
        opacity: 1;
        background: linear-gradient(45deg, #22d3ee, #a855f7, #22d3ee);
    }
    /* Animations */
    @keyframes glow {
        0%, 100% { box-shadow: 0 0 5px rgba(6, 182, 212, 0.5); }
        50% { box-shadow: 0 0 20px rgba(6, 182, 212, 0.8), 0 0 30px rgba(139, 92, 246, 0.5); }
    }
    
    .animate-glow {
        animation: glow 2s ease-in-out infinite;
    }
    
    /* Neon text effect */
    .text-neon {
        text-shadow: 0 0 5px rgba(34, 211, 238, 0.5), 
                     0 0 10px rgba(34, 211, 238, 0.3);
    }
    
    /* Glass morphism enhancement */
    .glass-card {
        background: rgba(17, 24, 39, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Smooth transitions - solo para elementos específicos */
    .transition-smooth {
        transition: all 0.3s ease;
    }
    
    /* Reducir animaciones para mejor rendimiento */
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.05);
    }
</style>
@endsection