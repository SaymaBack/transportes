<?php

namespace App\Http\Middleware;

use App\Http\Implementation\UserAuthjwt;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $help = new UserAuthjwt();
        $responsetoken = $help->validarToken($request);

        if (!$responsetoken["success"]) {
            return response()->json(['success' => false, 'message' => $responsetoken["message"]], $responsetoken["status"]);
        }

        $request->merge([
            'usuario' => $responsetoken["data"]["nombreUsuario"],
            "id_usuario" => $responsetoken["data"]["id_usuario"]
        ]);

        return $next($request);
    }
}
