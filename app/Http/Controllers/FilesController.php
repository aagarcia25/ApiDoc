<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

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
                    $nombre = "";
                    if (strtoupper($request->CN) === 'TRUE') {
                        $nombre = $fileContents->getClientOriginalName();
                    } else {
                        $prexi = Carbon::now();
                        $nombre = $prexi . $fileContents->getClientOriginalName();
                    }

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

    public function ListFile(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $responseData = [];

        try {

            $ruta = $request->ROUTE;
            $existe = Storage::exists($ruta);
            if ($existe) {
                if ($ruta != null) {
                    $response = Storage::files($ruta);

                    foreach ($response as $file) {
                        $cadena = $file;
                        $partes = explode('/', $cadena);

                        $obj = new stdClass();
                        $name = end($partes);
                        $atachment = Storage::disk('sftp')->get($ruta . $name);
                        $obj->NOMBRE = $name;
                        $obj->NOMBREFORMATEADO = substr($name, 19);
                        $obj->TIPO = Storage::mimeType($ruta . $name);
                        $obj->SIZE = Storage::size($ruta . $name);
                        $obj->FILE = base64_encode($atachment);

                        $responseData[] = $obj;
                    }
                }
            } else {
                $response = "No Existe la Ruta Indicada";
                throw new Exception($response);
            }
            $response = $responseData;
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

            if ($nombre !== null && $ruta !== null) {
                $archivoParaEliminar = $ruta . $nombre;

                if (file_exists($archivoParaEliminar)) {
                    Storage::delete($archivoParaEliminar);
                    // Puedes agregar lógica adicional después de eliminar el archivo si es necesario
                } else {
                    $response = "Archivo no existe";
                }
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
            $obj = new stdClass();

            if ($nombre != null) {

                $atachment = Storage::disk('sftp')->get($ruta . $nombre);
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
            $atachment = Storage::disk('sftp')->get($ruta);
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

    public function DeleteDirectorio(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "Archivo Eliminado";

        try {
            $ruta = $request->ROUTE;

            if ($ruta !== null) {

                if (Storage::exists($ruta)) {
                    Storage::deleteDirectory($ruta);
                } else {
                    $response = "Archivo no existe";
                }
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

    public function CreateDirectorio(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $ruta = $request->ROUTE;

            if ($ruta !== null) {
                $existe = Storage::exists($ruta);
                if (!$existe) {
                    Storage::makeDirectory($ruta);
                    $response = Storage::path($ruta);
                }
            } else {
                throw new Exception("Falta el Parametro de ROUTE");
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

    public function ListFileSimple(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";
        $responseData = [];

        try {

            $ruta = $request->ROUTE;
            $existe = Storage::exists($ruta);

            if (!$existe) {
                Storage::makeDirectory($ruta);
            }
            $existe = Storage::exists($ruta);
            if ($existe) {
                if ($ruta != null) {

                    // Obtener carpetas
                    $directories = Storage::directories($ruta);
                    foreach ($directories as $directory) {
                        $obj = new stdClass();
                        $name = basename($directory);
                        $obj->id = Str::uuid();
                        $obj->NOMBRE = $name;
                        $obj->NOMBREFORMATEADO = substr($name, 19);
                        $obj->ESCARPETA = true;
                        $obj->RUTA = $ruta . '/' . $name;
                        $responseData[] = $obj;
                    }



                    $response = Storage::files($ruta);
                    foreach ($response as $file) {
                        $cadena = $file;
                        $partes = explode('/', $cadena);
                        $obj = new stdClass();
                        $obj->id = Str::uuid();
                        $name = end($partes);
                        $obj->NOMBRE = $name;
                        $obj->NOMBREFORMATEADO = substr($name, 19);
                        $obj->ESCARPETA = false;
                        $obj->RUTA = $ruta  . '/' . $name;
                        $responseData[] = $obj;
                    }
                }
            } else {
                $response = "No Existe la Ruta Indicada";
                throw new Exception($response);
            }
            $response = $responseData;
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

    public function deleteFileSimple(Request $request)
    {
        $success = true;
        $numCode = 0;
        $strMessage = 'Éxito';
        $response = "Archivo eliminado";

        try {
            $ruta = $request->ROUTE;
            $ruta = urldecode($ruta);
            if ($ruta !== null) {
                // Eliminar el archivo
                Storage::disk('sftp')->delete($ruta);
            } else {
                $response = "Ruta de archivo no proporcionada";
                $numCode = 2;
                $success = false;
            }
        } catch (\Exception $e) {
            $response = "Error al eliminar archivo";
            $numCode = 1;
            $strMessage = $e->getMessage();
            $success = false;
        }

        return response()->json([
            'NUMCODE' => $numCode,
            'STRMESSAGE' => $strMessage,
            'RESPONSE' => $response,
            'SUCCESS' => $success,
        ]);
    }



    public function moverArchivos(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            $rutaOrigen = trim($request->input('ORIGEN'));
            $rutaDestino = trim($request->input('DESTINO'));

            $existeOrigen = Storage::exists($rutaOrigen);
            $existeDestino = Storage::exists($rutaDestino);

            Log::info("Ruta Origen: " . trim(env('APP_DOC_ROUTE') . $rutaOrigen));
            Log::info("Ruta DESTINO: " . trim(env('APP_DOC_ROUTE') . $rutaDestino));
            if (!$existeOrigen) {
                throw new \Exception("La ruta de origen no existe.");
            }

            if (!$existeDestino) {
                Storage::makeDirectory($rutaDestino);
            }

            $this->copiarDirectorio($rutaOrigen, $rutaDestino);

            $response = "Archivos y carpetas copiados/movidos correctamente.";
        } catch (\Exception $e) {
            $NUMCODE = 1;
            $STRMESSAGE = $e->getMessage();
            $SUCCESS = false;
        }

        return response()->json([
            'NUMCODE' => $NUMCODE,
            'STRMESSAGE' => $STRMESSAGE,
            'RESPONSE' => $response,
            'SUCCESS' => $SUCCESS,
        ]);
    }

    private function copiarDirectorio($directorioOrigen, $directorioDestino)
    {


        $directorios = Storage::directories($directorioOrigen);
        foreach ($directorios as $directorio) {
            $nombreDirectorio = pathinfo($directorio);
            $rutaDestinoDirectorio = $directorioDestino . '/' . $nombreDirectorio;

            // Verifica si el directorio ya existe en la carpeta de destino
            if (!Storage::exists($rutaDestinoDirectorio)) {
                Storage::makeDirectory($rutaDestinoDirectorio);
                $this->copiarDirectorio($directorio, $rutaDestinoDirectorio); // Llamada recursiva para copiar subdirectorios
            }
        }

        $archivos = Storage::allFiles($directorioOrigen);
        foreach ($archivos as $archivo) {
            $nombreArchivo = pathinfo($archivo);
            $rutaDestinoArchivo = $directorioDestino . '/' . $nombreArchivo;

            // Verifica si el archivo ya existe en la carpeta de destino
            if (!Storage::exists($rutaDestinoArchivo)) {
                Storage::copy($archivo, $rutaDestinoArchivo);
            }
        }
    }
}
