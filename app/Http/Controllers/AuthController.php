<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use App\ForoUsuario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario' => 'required|string',
            'password' => 'required|string',
        ], [
            'usuario.required' => 'El usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'ok' => false,
                'message' => 'Error de validación.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $usuario = ForoUsuario::where('usuario', $request->usuario)
            ->where('activo', true)
            ->first();

        if (!$usuario || !Hash::check($request->password, $usuario->password)) {
            return response()->json([
                'ok' => false,
                'message' => 'Credenciales incorrectas'
            ], 401);
        }

        $payload = [
            'sub' => $data['usuario'],
            'iat' => time(),
            'exp' => time() + (60 * 60 * 8), // 8 horas
        ];

        $token = JWT::encode(
            $payload,
            env('JWT_SECRET'),
            'HS256'
        );

        return response()->json([
            'ok' => true,
            'token' => $token
        ]);
    }

    public function validateToken(Request $request)
    {
        return response()->json([
            'ok' => true,
            'user' => $request->attributes->get('jwt_user')
        ]);
    }
}
