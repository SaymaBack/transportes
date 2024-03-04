<?php

namespace App\Http\Implementation;

use App\Http\interfaces\Authentication;
use App\Http\interfaces\JWT;
use App\Http\interfaces\Validation;
use App\Models\Usuario;
use Firebase\JWT\JWT as JWTauth;
use Firebase\JWT\Key;

class UserAuthjwt implements JWT
{

    public function generarToke(string $usuario, int $id_user): array
    {

        try {
            $payload = [
                'iss' => $usuario,
                'iduser' => $id_user,
                'iat' => time(),
                'exp' => time() + 60 * 60 * 24,
            ];
        } catch (\Throwable $th) {
            return ["success" => false, "message" => "Ocurrio un problema al generar tu credencial para le acceder al sistema", "status" => 409];
        }


        return ["success" => true, "message" => "Usuario valido", "token" => JWTauth::encode($payload, env("JWT_KEY_TRANSPORTE"), 'HS256'), "status" => 200];
    }
    public function validarToken($request): array
    {



        $dataresponse = [];
        $responsetoken = $this->existeToken($request);
        $request->headers->set('Accept', '*/*');
        $request->headers->set('Content-Type', '*/*');



        if ($responsetoken["success"]) {

            try {
                $decoded = JWTauth::decode($responsetoken["token"], new Key(env("JWT_KEY_TRANSPORTE"), 'HS256'));
            } catch (\Exception $e) {
                return ['success' => false, 'message' => 'Token invalido', 'status' => 401];
            }

            array_push($dataresponse, array(
                "nombreUsuario" => $decoded->iss,
                "id_usuario" => $decoded->iduser,
            ));




            return ['success' => true, 'message' => 'Token valido', 'data' => $dataresponse[0], 'status' => 200];
        }
        return ['success' => false, 'message' => 'Token invalido', 'status' => 403];
    }
    public function existeToken($request): array
    {

        $token = "";
        if (empty($request->header('Authkey'))) {
            return array("success" => false);
        }
        try {
            $token = $request->header('Authkey');
        } catch (\Exception $e) {
            return array("success" => false);
        }


        return array("success" => true, "token" => $token);
    }
}
