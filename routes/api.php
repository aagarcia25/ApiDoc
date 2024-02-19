<?php

use App\Http\Controllers\FilesController;
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
    Route::get('validacion', [FilesController::class, 'validacion']);

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::post('ListFileSimple', [FilesController::class, 'ListFileSimple']);
        Route::post('DeleteFileSimple', [FilesController::class, 'DeleteFileSimple']);
        Route::post('ListFile', [FilesController::class, 'ListFile']);
        Route::post('SaveFile', [FilesController::class, 'SaveFile']);
        Route::post('GetByName', [FilesController::class, 'GetByName']);
        Route::post('DeleteFile', [FilesController::class, 'DeleteFile']);
        Route::post('DeleteFileByRoute', [FilesController::class, 'DeleteFileByRoute']);
        Route::post('GetByRoute', [FilesController::class, 'GetByRoute']);
        Route::post('DeleteDirectorio', [FilesController::class, 'DeleteDirectorio']);
        Route::post('CreateDirectorio', [FilesController::class, 'CreateDirectorio']);
    });
});
