<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RegistroForoMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $this->data['qr'] = QrCode::format('png')
            ->size(260)
            ->margin(1)
            ->generate(
                'https://tesoreriavirtual.nl.gob.mx/jornada-auditoria-contabilidad-gubernamental/acceso/' . $this->data['id']
            );

        return $this
            ->from(
                env('MAIL_TALLER_FROM'),
                env('MAIL_TALLER_NAME')
            )
            ->subject('Registro - Jornada de Auditoría y Contabilidad Gubernamental')
            ->view('correo.foro')
            ->attachData($this->data['qr'], 'QR-Acceso.png', [
                'mime' => 'image/png',
            ])
            ->with($this->data);
    }
}
