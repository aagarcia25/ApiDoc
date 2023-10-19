<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;

class FilesController extends Controller
{

    public function validacion(Request $request)
    {

        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $response = "Servicios Funcionando";
        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SaveFile(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $ruta = $request->ROUTE;

            if (strtoupper($request->ADDROUTE) === 'TRUE') {
                $existe = Storage::exists($ruta);
                if (!$existe) {
                    Storage::makeDirectory($ruta);
                }

            }

            $existe = Storage::exists($ruta);

            $obj = new stdClass();
            if ($existe) {

                $fileContents = request()->file('FILE');

                if ($fileContents != null) {
                    $prexi = Carbon::now();
                    $nombre = $prexi . $fileContents->getClientOriginalName();

                    $path = $fileContents->storeAs($ruta, $nombre);
                    $obj->RUTA = $path; //Storage::disk('ftp')->path($ruta.$nombre);
                    $obj->NOMBREIDENTIFICADOR = $nombre;
                    $obj->NOMBREARCHIVO = $fileContents->getClientOriginalName();
                    //  var_dump($obj);
                }

                $response = $obj;
            } else {
                $response = "No Existe la Ruta Indicada";
                throw new Exception($response);
            }

        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }

    /**
     * @OA\Post(
     *     path="/ListFile",
     *     tags={"FilesController"},
     *     description="Operaciones",
     *      @OA\Parameter(
     *         description="Parámetro que indica la ruta donde se almacenara el archivo",
     *         in="path",
     *         name="ROUTE",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="/", summary="Introduce la Ruta para almacenar el archivo")
     *     ),
     *       @OA\Parameter(
     *         description="Parámetro que indica el nombre del archivo",
     *         in="path",
     *         name="Nombre",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="foto.png", summary="Introduce el nombre del archivo")
     *     ),
     *        @OA\Parameter(
     *         description="Parámetro que indica la aplicacion de donde se manda a llamar",
     *         in="path",
     *         name="APP",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="PDRMYE", summary="Introduce el identificador de la APP")
     *     ),
     *     @OA\Response(response="200", description="Display a listing of projects.")
     * )
     */
    public function ListFile(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {

            $ruta = $request->ROUTE;
            $existe = Storage::exists($ruta);
            if ($existe) {
                if ($ruta != null) {
                    $response = Storage::files($ruta);
                }
            } else {
                $response = "No Existe la Ruta Indicada";
                throw new Exception($response);
            }

        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );

    }

    public function DeleteFile(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "Archivo Eliminado";

        try {
            $nombre = $request->NOMBRE;
            $ruta = $request->ROUTE;
            if ($nombre != null) {
                Storage::delete($ruta . $nombre);
            }

        } catch (\Exception $e) {
            $response = "Error al Eliminar Archivo";
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }

    public function GetByName(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $nombre = $request->NOMBRE;
            $ruta = $request->ROUTE;
            if ($nombre != null) {
                $obj = new stdClass();
                $atachment = Storage::disk('ftp')->get($ruta . $nombre);
                $obj->NOMBRE = $nombre;
                $obj->TIPO = Storage::mimeType($ruta . $nombre);
                $obj->SIZE = Storage::size($ruta . $nombre);
                $obj->FILE = base64_encode($atachment);
            }

            $response = $obj;

        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }

    public function GetByRoute(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {

            $ruta = $request->ROUTE;

            $obj = new stdClass();
            $atachment = Storage::disk('ftp')->get($ruta);
            $obj->TIPO = Storage::mimeType($ruta);
            $obj->SIZE = Storage::size($ruta);
            $obj->FILE = base64_encode($atachment);
            $response = $obj;

        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }

    public function DeleteFileByRoute(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "Archivo Eliminado";

        try {
            $ruta = $request->ROUTE;
            if ($ruta != null) {
                Storage::delete($ruta);
            }

        } catch (\Exception $e) {
            $response = "Error al Eliminar Archivo";
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json(
            [
                'NUMCODE' => $NUMCODE,
                'STRMESSAGE' => $STRMESSAGE,
                'RESPONSE' => $response,
                'SUCCESS' => $SUCCESS,
            ]
        );
    }

}
