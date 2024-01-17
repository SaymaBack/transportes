<?php

namespace App\Http\Implementation;

use App\Http\interfaces\Validation;
use App\Models\Usuario;

class ValidationUser implements Validation
{


    public function validateExistUsername(array $data): array
    {
        if (!$data["usuario"]) {
            return ["success" => false, "message" => "El usuario es requerido"];
        }

        if (!array_key_exists('usuario', $data)) {
            return ["success" => false, "message" => "El usuario es requerido"];
        }
        return ["success" => true];
    }


    /////////////////////////////////////////////////////////////////////////////



    public function validateExistPassword(array $data): array
    {
        if (!$data["password"]) {
            return ["success" => false, "message" => "El password es requerido"];
        }

        if (!array_key_exists('password', $data)) {
            return ["success" => false, "message" => "El password es requerido"];
        }
        return ["success" => true];
    }
}
