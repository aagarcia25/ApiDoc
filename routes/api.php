<?php

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

Route::group([
    'prefix' => 'ApiDoc'
], function () {
     
      Route::post('show',              [FilesController::class,'show']);
      Route::post('create',            [FilesController::class,'create']);
      Route::post('getByName',         [FilesController::class,'getByName']);
      
     /*   Route::prefix('files')->group(function () {
            Route::post('/', [FilesController::class,'index']);
            Route::post('store',[FilesController::class,'store']);
            Route::post('update',[FilesController::class,'update']);
            Route::post('show',[FilesController::class,'show']);
            Route::post('destroy',[FilesController::class,'destroy']);
        });*/

});
