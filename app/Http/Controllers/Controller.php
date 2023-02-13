<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="ApiDoc", version="1.0.0")
 */

 /**
 * @OA\Info(
 *     title="API Documentacion",
 *     version="1.0.0",
 *      @OA\Contact(
 *          email="aagarcia@cecapmex.com"
 *      ),
 * ),
 *  @OA\Server(
 *      description="Learning env",
 *      url="http://10.200.4.96:81/api/ApiDoc"
 *  ),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
