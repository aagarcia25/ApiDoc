<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use stdClass;

class FilesController extends Controller
{
     /**
     * @OA\Post(
     *     path="/index",
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
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="foto.png", summary="Introduce el nombre del archivo")
     *     ),
     *        @OA\Parameter(
     *         description="Parámetro que indica la aplicacion de donde se manda a llamar",
     *         in="path",
     *         name="APP",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="string", value="PDRMYE", summary="Introduce el identificador de la APP")
     *     ),
     *       @OA\Parameter(
     *         description="Parámetro que indica el archivo a guardar",
     *         in="path",
     *         name="FILE",
     *         required=true,
     *         @OA\Schema(type="file")
     *     ),
     *     @OA\Response(response="200", description="Display a listing of projects.")
     * )
     */
    public function index()
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            
        $fileContents = request()->file('FILE');
        $ruta = request()->file('ROUTE');
        if($fileContents != null){
            Storage::disk('ftp')->put( $ruta, $fileContents);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

        try {
            
        $fileContents = request()->file('FILE');
        $ruta =   $request->ROUTE;
        if($fileContents != null){
            $nombre = $fileContents->getClientOriginalName();
           // $fileContents->storeAs($ruta, $nombre);
            $obj = new stdClass();
            $obj->RUTA = Storage::disk('ftp')->path($ruta.$nombre);
           
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

   /**
     * @OA\Post(
     *     path="/show",
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
    public function show(Request $request)
    {
        $SUCCESS = true;
        $NUMCODE = 0;
        $STRMESSAGE = 'Exito';
        $response = "";

    try {
            
        $ruta = $request->ROUTE;
      
        if($ruta != null){
            $response = Storage::files($ruta);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getByName(Request $request)
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
            return Storage::get($ruta.$nombre);
           
           
        }
      
       // $response  = $obj;

    } catch (\Exception $e) {
        $NUMCODE = 1;
        $STRMESSAGE = $e->getMessage();
        $SUCCESS = false;
    }
/*
   return response()->json(
        [
            'NUMCODE' => $NUMCODE,
            'STRMESSAGE' => $STRMESSAGE,
            'RESPONSE' => $response,
            'SUCCESS' => $SUCCESS
        ]
    );*/
    }


}
