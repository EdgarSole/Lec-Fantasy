
@component('mail::message')
# ¡Felicidades, {{ $usuarioNombre }}!

Has ganado la puja por el jugador **{{ $jugadorNombre }}** ({{ $equipoReal }}) 
por la cantidad de **{{ number_format($cantidad, 0, ',', '.') }} €**.

@component('mail::button', ['url' => $urlEquipo])
Ver mi equipo
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent