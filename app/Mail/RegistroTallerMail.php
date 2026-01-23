<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroTallerMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this
            ->from(
                env('MAIL_TALLER_FROM'),
                env('MAIL_TALLER_NAME')
            )
            ->subject('Registro - Taller de Integración')
            ->view('correo.taller')
            ->with($this->data);
    }
}
