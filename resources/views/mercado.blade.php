@extends('layouts.ligaMenu')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header con presupuesto y contador -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center bg-white rounded-lg shadow-md p-4 mb-6 gap-4">
        <div class="flex items-center flex-wrap gap-2">
            <span class="font-bold text-lg text-gray-800">Presupuesto:</span>
            <span class="text-green-600 font-bold text-lg">{{ number_format($equipo->presupuesto, 0, ',', '.') }} €</span>
            @if($pujasUsuario->sum('cantidad') > 0)
                <span class="text-red-500 font-medium">-{{ number_format($pujasUsuario->sum('cantidad'), 0, ',', '.') }} €</span>
            @endif
        </div>
        <div class="bg-white/60 backdrop-blur-sm border border-blue-200 px-5 py-2 rounded-full font-bold text-blue-700 shadow-inner">
            ⏳ Próxima actualización en: 
            <span id="contador" class="font-mono text-pink-600">
                {{ str_pad(intval($tiempoRestante['horas']), 2, '0', STR_PAD_LEFT) }}h
                {{ str_pad(intval($tiempoRestante['minutos']), 2, '0', STR_PAD_LEFT) }}m
                {{ str_pad(intval($tiempoRestante['segundos']), 2, '0', STR_PAD_LEFT) }}s
            </span>
        </div>
    </div>
</div>

    <!-- Grid de jugadores -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @foreach($mercadoActual as $item)
        <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-shadow duration-300 border-2 border-gray-200 flex flex-col h-full">
            <!-- Imagen del jugador -->
            <div class="h-48 overflow-hidden">
                <img src="{{ $item->jugador->imagen_url }}" alt="{{ $item->jugador->nombre }}" class="w-full h-full object-cover">
            </div>
            
            <!-- Información del jugador -->
            <div class="p-4 flex-grow">
                <h3 class="font-bold text-lg text-gray-800">{{ $item->jugador->nombre }}</h3>
                <p class="text-gray-600 text-sm">{{ $item->jugador->posicion }} • {{ $item->jugador->equipo_real }}</p>
                
                <div class="flex justify-between mt-3">
                    <span class="text-blue-500 font-bold">{{ $item->jugador->puntos }} pts</span>
                    <span class="text-green-600 font-bold">{{ number_format($item->jugador->valor, 0, ',', '.') }} €</span>
                </div>
                
                <!-- Tabla de pujas (NUEVO) -->
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <div class="overflow-auto max-h-40">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase">Equipo</th>
                                    <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase">Puja</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="pujas-body-{{ $item->id }}">
                                @foreach($item->pujas as $index => $puja)
                                <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="px-2 py-1 whitespace-nowrap text-xs text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-2 py-1 whitespace-nowrap text-xs text-gray-500">{{ $puja->equipo->usuario->nombre }}</td>
                                    <td class="px-2 py-1 whitespace-nowrap text-xs text-gray-500">{{ number_format($puja->cantidad, 0, ',', '.') }} €</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Botón de puja -->
            <button class="mt-auto w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold hover:from-blue-600 hover:to-purple-700 transition-colors"
                onclick="abrirModalPuja(
                    '{{ $item->id }}',
                    '{{ addslashes($item->jugador->nombre) }}',
                    '{{ $item->jugador->valor }}',
                    '{{ $equipo->presupuesto - $pujasUsuario->sum('cantidad') }}',
                    '{{ $pujasUsuario[$item->id]->cantidad ?? 0 }}'
                )">
                {{ isset($pujasUsuario[$item->id]) ? 'Modificar Puja' : 'Pujar' }}
            </button>
        </div>
        @endforeach
    </div>

    <!-- Modal de Puja -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden" id="pujaModal">
        <div class="bg-white rounded-lg w-full max-w-md mx-4">
            <div class="p-4 border-b">
                <h3 class="text-xl font-bold text-gray-800">Pujar por <span id="jugadorNombreModal"></span></h3>
            </div>
            
            <form id="pujaForm" method="POST" action="{{ route('mercado.pujar', $liga) }}" class="p-4">
                @csrf
                <input type="hidden" name="mercado_id" id="mercadoIdModal">
                
                <div class="mb-4">
                    <label for="cantidadModal" class="block text-sm font-medium text-gray-700 mb-1">Cantidad (€)</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">€</span>
                        </div>
                        <input type="number" id="cantidadModal" name="cantidad"     
                               class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-12 py-2 border-gray-300 rounded-md" 
                               required min="0" step="1">
                    </div>
                    
                    <div class="mt-4">
                        <input type="range" id="cantidadRangeModal" min="0" step="1" 
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span id="minValueModal">0 €</span>
                            <span id="maxPresupuestoModal">0 €</span>
                        </div>
                    </div>
                    
                    <p id="errorPresupuestoModal" class="mt-2 text-sm text-red-600 hidden">No puedes superar tu presupuesto disponible</p>
                    <p id="errorMinimoModal" class="mt-2 text-sm text-red-600 hidden">La puja mínima es <span id="valorMinimo"></span> €</p>
                </div>
                
                <!-- En mercado.blade.php, dentro del modal -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    
                    <button type="button" onclick="cerrarModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        {{ isset($pujasUsuario[$item->id]) ? 'Modificar' : 'Pujar' }}
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
        const max = parseFloat(maxPresupuesto) + (pujaActual ? parseFloat(pujaActual) : 0);

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
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
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
                mostrarNotificacion('success', 'Puja realizada con éxito');
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
    if (data.pujas_totales !== undefined) {
        const formattedPujas = data.pujas_totales.toLocaleString('es-ES') + ' € en pujas';
        
        if (!pujasTotalesElement) {
            const newElement = document.createElement('span');
            newElement.className = 'text-red-500 font-medium ml-2';
            newElement.textContent = `(${formattedPujas})`;
            presupuestoElement.parentNode.appendChild(newElement);
        } else {
            pujasTotalesElement.textContent = `(${formattedPujas})`;
        }
    } else if (pujasTotalesElement) {
        pujasTotalesElement.remove();
    }

    // Actualizar tabla de pujas
    const pujasBody = document.querySelector(`#pujas-body-${data.mercado_id}`);
    if (pujasBody && data.pujas_mercado) {
        pujasBody.innerHTML = '';
        
        data.pujas_mercado.forEach((puja, index) => {
            const row = document.createElement('tr');
            row.className = index % 2 === 0 ? 'bg-gray-50' : 'bg-white';
            
            row.innerHTML = `
                <td class="px-2 py-1 whitespace-nowrap text-xs text-gray-900">${index + 1}</td>
                <td class="px-2 py-1 whitespace-nowrap text-xs text-gray-500">${puja.equipo_nombre}</td>
                <td class="px-2 py-1 whitespace-nowrap text-xs text-gray-500">${puja.cantidad.toLocaleString('es-ES')} €</td>
            `;
            
            pujasBody.appendChild(row);
        });
    }
    
    // Actualizar botón de puja
    const botonPuja = document.querySelector(`button[onclick*="${data.mercado_id}"]`);
    if (botonPuja) {
        botonPuja.textContent = data.cantidad_pujada > 0 ? 'Modificar Puja' : 'Pujar';
        botonPuja.setAttribute('onclick', 
            `abrirModalPuja('${data.mercado_id}', '${data.jugador_nombre.replace(/'/g, "\\'")}', 
            '${data.jugador_valor}', '${data.presupuesto_restante}', '${data.cantidad_pujada}')`);
    }
}

    // Función para mostrar notificaciones
    function mostrarNotificacion(tipo, mensaje) {
        const notificacion = document.createElement('div');
        notificacion.className = `fixed top-4 right-4 px-4 py-2 rounded-md shadow-lg text-white ${
            tipo === 'success' ? 'bg-green-500' : 'bg-red-500'
        }`;
        notificacion.textContent = mensaje;
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
@endsection