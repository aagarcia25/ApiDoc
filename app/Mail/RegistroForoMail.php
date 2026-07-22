<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

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
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data('https://tesoreriavirtual.nl.gob.mx/jornada-auditoria-contabilidad-gubernamental/acceso/' . $this->data['id'])
            ->size(260)
            ->margin(1)
            ->build();

        $png = $result->getString();

        return $this
            ->from(
                env('MAIL_TALLER_FROM'),
                env('MAIL_TALLER_NAME')
            )
            ->subject('Registro - Jornada de Auditoría y Contabilidad Gubernamental')
            ->attachData($png, 'QR-Acceso.png', [
                'mime' => 'image/png',
            ])
            ->with([
                ...$this->data,
                'qr' => $png,
            ])
            ->view('correo.foro');
    }
}
