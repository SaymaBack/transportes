<?php

namespace App\Http\Implementation;

use App\Http\interfaces\Authentication;
use App\Http\interfaces\Validation;
use App\Models\Usuario;

class UserAuth implements Authentication
{




    public function authenticate(array $datauser): array
    {
        // Comprueba si el usuario existe
        try {
            $user = Usuario::select("*")->where("usuario", $datauser["usuario"])->where("eliminado", 0)->first();
        } catch (\Throwable $th) {
            return ["success" => false, "message" => "ocurrio un problema, intenta más tarde FAUT-GU-TC", "status" => 409];
        }

        if ($user == null) {
            return ["success" => false, "message" => "Usuario invalido", 404];
        }


        if (!password_verify($datauser["password"], $user->password)) {
            return ["success" => false, "message" => "Contraseña invalida", 404];
        }


        return ["success" => true, "message" => "Usuario valido", 200,"data"=>$user];
    }
}
