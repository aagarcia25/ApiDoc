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
     
      Route::post('ListFile',              [FilesController::class,'ListFile']);
      Route::post('SaveFile',            [FilesController::class,'SaveFile']);
      Route::post('GetByName',         [FilesController::class,'GetByName']);
      Route::post('DeleteFile',            [FilesController::class,'DeleteFile']);
      
     
});
