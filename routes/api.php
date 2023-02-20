<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('ApiDoc')->group(function () {
    //Prefijo ApiDoc, todo lo que este dentro de este grupo se accedera escribiendo ApiDoc en el navegador, es decir /api/ApiDoc/*
    Route::post('login', [AuthController::class, 'login']);
    Route::group(['middleware' => ['jwt.verify']], function() {
        //Todo lo que este dentro de este grupo requiere verificación de usuario.
        Route::post('register',           [AuthController::class,'register']);
        Route::post('logout',             [AuthController::class,'logout']);
        Route::post('refresh',            [AuthController::class,'refresh']);
        Route::post('ListFile',           [FilesController::class,'ListFile']);
        Route::post('SaveFile',           [FilesController::class,'SaveFile']);
        Route::post('GetByName',          [FilesController::class,'GetByName']);
        Route::post('DeleteFile',         [FilesController::class,'DeleteFile']);
    });
});









