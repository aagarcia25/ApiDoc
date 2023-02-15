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



Route::group([
    'middleware' => 'api',
    'prefix' => 'ApiDoc'

], function ($router) {
    Route::post('login', [AuthController::class, 'login']);

});

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'ApiDoc'
// ], function () {
//     Route::post('login',              [AuthController::class,'login']);
  
//       Route::group([
//       'middleware' => 'auth:api'
//     ], function() {
//         Route::post('register',           [AuthController::class,'register']);
//         Route::post('logout',             [AuthController::class,'logout']);
//         Route::post('refresh',            [AuthController::class,'refresh']);
//         Route::post('ListFile',           [FilesController::class,'ListFile']);
//         Route::post('SaveFile',           [FilesController::class,'SaveFile']);
//         Route::post('GetByName',          [FilesController::class,'GetByName']);
//         Route::post('DeleteFile',         [FilesController::class,'DeleteFile']);
    
//     });
// });



