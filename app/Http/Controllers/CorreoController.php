<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\EnviaPassMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Mail\RegistroTallerMail;
use App\Mail\RegistroForoMail;
use Illuminate\Support\Facades\DB;
use App\Correos;



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
        // Validar límite
        $total = DB::table('correos')->count();

        if ($total >= 130) {
            return response()->json([
                'ok' => false,
                'message' => 'Ya no hay registros disponibles'
            ], 418);
        }

        // Validación
        $data = $request->validate([
            'nombre'       => 'required|string',
            'aPaterno'     => 'required|string',
            'aMaterno'     => 'required|string',
            'cargo'        => 'required|string',
            'ente'         => 'required|string',
            'correo'       => 'required|email',
            'telefono'     => 'required|string',
            'captchaToken' => 'nullable|string',
        ]);

        // Insertar primero
        $correoId = DB::table('correos')->insertGetId([
            'nombre'      => $data['nombre'],
            'a_paterno'   => $data['aPaterno'],
            'a_materno'   => $data['aMaterno'],
            'cargo'       => $data['cargo'],
            'ente'        => $data['ente'],
            'correo'      => $data['correo'],
            'telefono'    => $data['telefono'],
            'status_envio'=> 'OK',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Envío de correo
        try {
            Mail::mailer('talleres')
                ->to($data['correo'])
                ->bcc([
                    'jabustos@cecapmex.com',
                    'taller.integracion@nuevoleon.gob.mx',
                ])
                ->send(new RegistroTallerMail($data));
        } catch (\Throwable $e) {

            DB::table('correos')
                ->where('id', $correoId)
                ->update([
                    'status_envio' => 'ERR',
                    'updated_at' => now()
                ]);

            return response()->json([
                'ok' => false,
                'message' => 'No se pudo enviar el correo',
                'error' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'ok' => true,
            'message' => 'Registro enviado correctamente'
        ]);
    }
    public function registroForo(Request $request)
    {
        // Validar límite
        if (Correos::count() >= 1000) {
            return response()->json([
                'ok' => false,
                'message' => 'Ya no hay registros disponibles'
            ], 418);
        }

        // Validación
        $validator = Validator::make($request->all(), [
            'nombre'       => 'required|string|max:255',
            'aPaterno'     => 'required|string|max:255',
            'aMaterno'     => 'nullable|string|max:255',
            'cargo'        => 'required|string|max:255',
            'ente'         => 'required|string|max:255',
            'correo'       => 'required|email|max:255|unique:foro_registros,correo',
            'telefono'     => 'required|string|max:30',
            'captchaToken' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Datos inválidos.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Crear registro
        $registro = Correos::create([
            'nombre'             => $data['nombre'],
            'apellido_paterno'   => $data['aPaterno'],
            'apellido_materno'   => $data['aMaterno'] ?? null,
            'correo'             => $data['correo'],
            'cargo'              => $data['cargo'],
            'ente'               => $data['ente'],
            'telefono'           => $data['telefono'],
        ]);

        try {
            Mail::mailer('talleres')
                ->to($registro->correo)
                ->bcc([
                    'jabustos@cecapmex.com'
                ])
                ->send(new RegistroForoMail($registro->toArray()));

        } catch (\Throwable $e) {
            $registro->delete();
            return response()->json([
                'ok' => false,
                'message' => 'No se pudo enviar el correo',
                'error' => $e->getMessage(),
            ], 500);
        }
        return response()->json([
            'ok' => true,
            'message' => 'Registro enviado correctamente',
        ]);
    }

}
