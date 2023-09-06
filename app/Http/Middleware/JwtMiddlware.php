<?php
namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;

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

        try {

            // attempt to verify the credentials and create a token for the user
            $token = $request->header('Authorization');
            $res = $this->validatoken($token);
            if ($res === 200) {
                return $next($request);
            } else {
                return response()->json([
                    'NUMCODE' => -1,
                    'STRMESSAGE' => 'Token Invalido',
                    'RESPONSE' => [],
                    'SUCCESS' => false,
                ], 401);
            }

        } catch (\Exception $e) {
            return response()->json([
                'NUMCODE' => -1,
                'STRMESSAGE' => $e->getMessage(),
                'RESPONSE' => [],
                'SUCCESS' => false,
            ], 401);
        }

    }

    public function validatoken(String $token)
    {
        try {
            $body = '{}';
            $client = new Client();
            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => $token,
            ];
            $req = new Psr7Request('POST', env('APP_LOGIN_URL') . '/api/verify', $headers, $body);
            $res = $client->sendAsync($req)->wait();
            //$data = json_decode($res->getBody()->getContents());
            $data = $res->getStatusCode();
            return $data;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

}
