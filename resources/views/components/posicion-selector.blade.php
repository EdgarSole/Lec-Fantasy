<div class="text-center">
    <div class="relative">
        @if($jugadorActual)
            <!-- Jugador titular -->
            <div class="group relative w-20 h-20 mx-auto">
                <div class="relative w-full h-full rounded-full border-4 border-white shadow-xl overflow-hidden bg-white/90">
                    <img src="{{ $jugadorActual->imagen_url }}" 
                         class="w-full h-full object-cover">
                </div>
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 text-xs font-bold text-white bg-black/80 px-2 py-0.5 rounded-full whitespace-nowrap">
                    {{ $jugadorActual->nombre }}
                </div>
                
            </div>
        @else
            <!-- Posición vacía -->
            <div class="relative w-20 h-20 mx-auto rounded-full border-4 border-white shadow-xl bg-white/90 p-1">
                <img src="{{ $icono }}" 
                     class="w-full h-full object-contain p-2">
                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 text-xs font-bold text-white bg-black/80 px-2 py-0.5 rounded-full whitespace-nowrap">
                    {{ $posicion }}
                </span>
            </div>
        @endif
    </div>
</div>