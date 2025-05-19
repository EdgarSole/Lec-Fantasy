<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PujaGanadoraNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $jugadorNombre;
    public $cantidad;
    public $equipoReal;
    public $usuarioNombre;
    public $urlEquipo;

    public function __construct($usuarioNombre, $jugadorNombre, $cantidad, $equipoReal, $ligaId)
    {
        $this->jugadorNombre = $jugadorNombre;
        $this->cantidad = $cantidad;
        $this->equipoReal = $equipoReal;
        $this->usuarioNombre = $usuarioNombre;
        $this->urlEquipo = route('mi-equipo', ['liga' => $ligaId]);
    }

    public function build()
    {
        return $this->markdown('emails.puja_ganadora')
            ->subject('¡Has ganado una puja en el mercado!');
    }
}