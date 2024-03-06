<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Documentacion Api TRATA (Sayma) ",
 *    version="1.0.0",
 * )
 * @OA\SecurityScheme(
 *     type="apiKey",
 *     securityScheme="ApiKeyAuth",
 *     in="header",
 *     name="AuthKey"
 * )
*/

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
