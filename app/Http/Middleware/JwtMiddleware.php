<?php 
 
namespace App\Http\Middleware; 

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                "error" => "Token no proporcionado"
            ], 401);
        }

        try {
            $secret = env("JWT_SECRET");

            // Verificar firma y decodificar token
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));

            // Validar expiración si existe
            if (isset($decoded->exp) && time() > $decoded->exp) {
                return response()->json([
                    "error"   => "Token expirado",
                    "message" => "El token ya no es válido"
                ], 401);
            }

            // Adjuntar data del token al request
            $request->attributes->add(['jwt_user' => (array) $decoded]);

        } catch (Exception $e) {
            return response()->json([
                "error"   => "Token inválido",
                "message" => $e->getMessage()
            ], 401);
        }

        return $next($request);
    }
}
