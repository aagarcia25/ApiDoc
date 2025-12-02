<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\EnviaPassMail;
use Illuminate\Support\Facades\Mail;


class CorreoController extends Controller
{
    public function index(Request $request)
    {

        $jwtUser = $request->attributes->get('jwt_user');

        $userInfo = [
            'IdUsuario'     => $jwtUser['IdUsuario'] ?? null,
            'NombreUsuario' => $jwtUser['NombreUsuario'] ?? null,
            'Correo'        => $jwtUser['datosCompletos']->CorreoElectronico ?? null,
        ];

        return response()->json([
            'ok' => true,
            'mensaje' => 'Acceso autorizado a '.$userInfo['NombreUsuario'],
            'usuario' => $userInfo
        ]);
    }

    public function enviaPass(Request $request)
    {
        $jwtUser = $request->attributes->get('jwt_user');

        $userInfo = [
            'IdUsuario'     => $jwtUser['IdUsuario'] ?? null,
            'NombreUsuario' => $jwtUser['NombreUsuario'] ?? null,
            'Correo'        => $request->input('correo'),
            'Password'      => $request->input('password') ?? '********', 
            'Tipo'          => $request->input('tipo') ?? 'bienvenido', 
        ];

        // Enviar correo
        Mail::to($userInfo['Correo'])->send(
            new EnviaPassMail(
                $userInfo['NombreUsuario'],
                $userInfo['Correo'],
                $userInfo['Password'],
                $userInfo['Tipo'],
                $userInfo['Tipo'] == 'bienvenido' ? 'Bienvenido' : 'Hola'
            )
        );

        return response()->json([
            'ok' => true,
            'mensaje' => 'Correo enviado correctamente',
            'desde_usuario' => $userInfo['Correo'],
            'payload' => $request->all()
        ]);
    }
}
