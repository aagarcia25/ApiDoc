<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviaPassMail extends Mailable
{
    use Queueable, SerializesModels;

    public $usuario;
    public $correo;
    public $password;
    public $tipo;
    public $mensaje;

    /**
     * Create a new message instance.
     */
    public function __construct($usuario, $correo, $password, $tipo, $mensaje)
    {
        $this->usuario  = $usuario;
        $this->correo   = $correo;
        $this->password = $password;
        $this->tipo     = $tipo;
        $this->mensaje  = $mensaje;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->tipo === 'bienvenido' ? 'Bienvenido a la plataforma' : 'Restablecimiento de contraseña')
                    ->view('correo.usuario');
    }
}
