<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;
use League\Flysystem\Ftp\FtpAdapter;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;



class FilesController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function saveFile(Request $request)
    {
        try {
            $messages = [
                'required' => 'El campo :attribute es requerido.',
                'file' => 'El campo :attribute debe ser un archivo.',
            ];

            // Valida los datos del request con los mensajes personalizados
            $validator = Validator::make($request->all(), [
                'ROUTE' => 'required',
                'FILE' => 'required|file',
            ], $messages);

            if ($validator->fails()) {
                // Obtiene los mensajes de error
                $errors = $validator->errors();

                // Puedes retornar los mensajes de error en la respuesta JSON
                return response()->json([
                    'NUMCODE' => 1,
                    'STRMESSAGE' => 'Error en la validación',
                    'ERRORS' => $errors->all(),
                    'SUCCESS' => false,
                ], 422); // Código de estado HTTP 422 Unprocessable Entity

                // También puedes lanzar una excepción para que Laravel maneje automáticamente los errores
                // throw new \Illuminate\Validation\ValidationException($validator);
            }

            $ruta = $request->ROUTE;
            $file = $request->file('FILE');
            //$prexi = Carbon::now()->format('YmdHis');
            $nombre = $file->getClientOriginalName();
            $filePath = $ruta . $nombre;

            $disk = Storage::disk('ftp');
            $disk->put($filePath, file_get_contents($file));

            $obj = new stdClass();
            $obj->RUTA = $disk->url($filePath);
            $obj->NOMBREIDENTIFICADOR = $nombre;
            $obj->NOMBREARCHIVO = $file->getClientOriginalName();

            return response()->json([
                'NUMCODE' => 0,
                'STRMESSAGE' => 'Éxito',
                'RESPONSE' => $obj,
                'SUCCESS' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'NUMCODE' => 1,
                'STRMESSAGE' => $e->getMessage(),
                'SUCCESS' => false,
            ]);
        }
    }

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

    public function listAll(Request $request) {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Success';
        $response = [];

        try {
            $route = $request->route;
            $path = public_path($route);

            if (is_dir($path)) {
                $files = scandir($path);
                $response = array_diff($files, array('.', '..'));
            } else {
                $response = 'The specified route does not exist';
            }
        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json([
            'NUMCODE' => $NUMCODE,
            'STRMESSAGE' => $STRMESSAGE,
            'RESPONSE' => $response,
            'SUCCESS' => $SUCCESS
        ]);
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
        try {
            $ruta = $request->input('ruta');
            $nombre = $request->input('nombre');

            if (!$ruta || !$nombre) {
                return response()->json([
                    'NUMCODE' => 1,
                    'STRMESSAGE' => 'Datos de entrada incompletos',
                    'SUCCESS' => false,
                ]);
            }

            $disk = Storage::disk('ftp');
            $filePath = $ruta . $nombre;

            // Verificar si el archivo existe en el servidor FTP
            if (!$disk->exists($filePath)) {
                return response()->json([
                    'NUMCODE' => 1,
                    'STRMESSAGE' => 'El archivo no existe en el servidor FTP',
                    'SUCCESS' => false,
                ]);
            }

            // Devolver el archivo para su descarga
            return Storage::disk('ftp')->download($filePath, null, [
                'Content-Type' => 'application/pdf', // Tipo MIME para un archivo PDF
                'Content-Disposition' => 'inline', // Visualizar el PDF en el navegador
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'NUMCODE' => 1,
                'STRMESSAGE' => $e->getMessage(),
                'SUCCESS' => false,
            ]);
        }
    }




}
