<?php
namespace App\Http\Middleware;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class JwtMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


            // attempt to verify the credentials and create a token for the user
            $token = $request->header('Authorization');
            if($token){
                $decoded = (json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1])))));
                $decoded_array = (array) $decoded;
                //$nombreUsuario= ($decoded_array['NombreUsuario']);
               // $idusuario=     (trim($decoded_array['IdUsuario']));
                $iat=           ($decoded_array['iat']);
                $exp =          ($decoded_array['exp']);
                $date = time();
                $f1=date("Y-m-d (H:i:s)", $date);
                $f2=date("Y-m-d (H:i:s)", $exp);
                $tokenvalido=$f1 > $f2;

                if(!$tokenvalido){
                 //   if($this->checkUser($idusuario)){
                        return $next($request);
                 //   }else{
                 //       return response()->json(['status' => 'Usuario no Existe'], 401);
                 //   }

                }else{
                    return response()->json(['status' => 'Token Expirado'], 401);
                }


    /*
                print_r($decoded_array['NombreUsuario']);
                print_r($decoded_array['IdUsuario']);
                print_r($decoded_array['iat']);
                print_r($decoded_array['exp']);*/


               //  $TokenValido= ((( number_format($decoded_array['exp'])  - (Carbon::now() / 1000)) / 60)) ;




            }else{
                return response()->json(['status' => 'Authorization Token not found'], 401);
            }






    }

    public function checkUser($id){
        $response = "";
        try{
            $response = DB::select(DB::raw(" SELECT  u.Id   FROM      TiCentral.Usuarios u   WHERE  u.Id='".$id."'"));
            $response[0]->Id;
            $response = true;
        } catch (\Exception $e) {
            $response = false;
        }

        return  $response;
     }


}
