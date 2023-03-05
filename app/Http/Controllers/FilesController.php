<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;
use League\Flysystem\Ftp\FtpAdapter;


class FilesController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SaveFile(Request $request) {
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $ruta = $request->ROUTE;
            $fileContents = request()->file('FILE');
            $obj = new stdClass();

            if (!$ruta) {
                return response()->json([
                    'NUMCODE' => 1,
                    'STRMESSAGE' => 'No se proporcionó una ruta válida',
                    'SUCCESS' => false
                ]);
            }

            if (!$fileContents) {
                return response()->json([
                    'NUMCODE' => 1,
                    'STRMESSAGE' => 'No se proporcionó un archivo válido',
                    'SUCCESS' => false
                ]);
            }

            $prexi = Carbon::now();
            $nombre = $prexi.$fileContents->getClientOriginalName();
            $filePath = $ruta.$nombre;
            $disk = Storage::disk('ftp');
            $disk->put($filePath, $fileContents);

            $obj->RUTA = $disk->url($filePath);
            $obj->NOMBREIDENTIFICADOR = $nombre;
            $obj->NOMBREARCHIVO = $fileContents->getClientOriginalName();
            $response = $obj;
        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
        }

        return response()->json([
            'NUMCODE' => $NUMCODE,
            'STRMESSAGE' => $STRMESSAGE,
            'RESPONSE' => $response,
            'SUCCESS' => $NUMCODE === 0
        ]);
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
    public function ListFile(Request $request){
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

    try {


        $ruta = $request->ROUTE;
        $existe = Storage::exists($ruta);
        if ($existe){
        if($ruta != null){
            $response = Storage::files($ruta);
        }
       }else{
        $response = "No Existe la Ruta Indicada";
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
            'SUCCESS' => $SUCCESS
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
        $nombre =   $request->NOMBRE;
        $ruta   =   $request->ROUTE;
        if($nombre != null){
            Storage::delete($ruta.$nombre);
        }


    } catch (\Exception $e) {
        $response ="Error al Eliminar Archivo" ;
        $NUMCODE = 1;
        $STRMESSAGE = $e->getMessage();
        $SUCCESS = false;
    }

   return response()->json(
        [
            'NUMCODE' => $NUMCODE,
            'STRMESSAGE' => $STRMESSAGE,
            'RESPONSE' => $response,
            'SUCCESS' => $SUCCESS
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
        $nombre =   $request->NOMBRE;
        $ruta   =   $request->ROUTE;
        if($nombre != null){
            $obj = new stdClass();
            $atachment = Storage::disk('ftp')->get($ruta.$nombre);
            $obj->NOMBRE=$nombre;
            $obj->TIPO = Storage::mimeType($ruta.$nombre);
            $obj->SIZE = Storage::size($ruta.$nombre);
            $obj->FILE = base64_encode($atachment);
        }

        $response  = $obj;

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
            'SUCCESS' => $SUCCESS
        ]
    );
    }


}
