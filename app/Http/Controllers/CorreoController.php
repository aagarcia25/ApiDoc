<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\EnviaPassMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\RegistroTallerMail;



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

        $validator = Validator::make($request->all(), [
            'usuario' => 'required|string',
            'correo'  => 'required|email',
            'password' => 'required|string',
            'tipo'    => 'required|in:bienvenido,restablecido',
        ]);

        if ($validator->fails()) {
            $detalles = collect($validator->errors()->messages())->map(function($msgs, $field){
                switch($field){
                    case 'correo':
                        return ['Correo inválido'];
                    case 'tipo':
                        return ['Tipo inválido'];
                    case 'usuario':
                        return ['Usuario inválido'];
                    case 'password':
                        return ['Password requerido'];
                    default: 
                        return [$msgs[0]]; 
                } 
            }); 

            return response()->json([ 
                'error' => 'Datos inválidos', 
                'detalles' => $detalles 
            ], 418); 
        } 

        $userInfo = [ 
            'IdUsuario'     => $jwtUser['IdUsuario'] ?? null, 
            'NombreUsuario' => $request->input('usuario'), 
            'Correo'        => $request->input('correo'), 
            'Password'      => $request->input('password') ?? '********',  
            'Tipo'          => $request->input('tipo') ?? 'bienvenido',  
        ]; 

        try {
            Mail::to($userInfo['Correo'])->send( 
                new EnviaPassMail( 
                    $userInfo['NombreUsuario'], 
                    $userInfo['Correo'], 
                    $userInfo['Password'], 
                    $userInfo['Tipo'], 
                    $userInfo['Tipo'] == 'bienvenido' ? 'Bienvenido' : 'Hola' 
                ) 
            );

            // Log de envío exitoso
            \Log::channel('correos')->info('Correo enviado', [
                'usuario' => $userInfo['NombreUsuario'],
                'correo'  => $userInfo['Correo'],
                'tipo'    => $userInfo['Tipo'],
                'status'  => 'ok'
            ]);

            return response()->json([ 
                'ok' => true, 
                'mensaje' => 'Correo enviado correctamente', 
                'desde_usuario' => $jwtUser['NombreUsuario'] ?? null, 
                'payload' => $request->all() 
            ]); 

        } catch (\Exception $e) {
            // Log de error
            \Log::channel('correos')->error('Error al enviar correo', [
                'usuario' => $userInfo['NombreUsuario'],
                'correo'  => $userInfo['Correo'],
                'tipo'    => $userInfo['Tipo'],
                'error'   => $e->getMessage()
            ]);

            return response()->json([
                'ok' => false,
                'mensaje' => 'Error al enviar correo',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function registroTaller(Request $request)
    {
        $data = $request->validate([
            'nombre'     => 'required|string',
            'aPaterno'   => 'required|string',
            'aMaterno'   => 'required|string',
            'cargo'      => 'required|string',
            'ente'       => 'required|string',
            'correo'     => 'required|email',
            'telefono'   => 'required|string',
            'captchaToken' => 'nullable|string',
        ]);

        // Enviar correo usando mailer "talleres"
        Mail::mailer('talleres')
            ->to($data['correo'])
            ->send(new RegistroTallerMail($data));

        return response()->json([
            'ok' => true,
            'mensaje' => 'Registro enviado correctamente'
        ]);
    }

}
