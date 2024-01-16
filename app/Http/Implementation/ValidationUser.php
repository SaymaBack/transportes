<?php

namespace App\Http\Implementation;

use App\Http\interfaces\Validation;
use App\Models\Usuario;

class ValidationUser implements Validation
{
    public function validateDataGeneral(array $data){
        
    }

    public function validateUsername(string $usuario): array
    {
        if (empty($usuario)) {
            return ["success" => false, "message" => "El usuario es requerido"];
        }
        if (strlen($usuario) < 40) {
            return ["success" => false, "message" => "El usuario es requerido"];
        }

        return ["success" => true];
    }


    public function validatePassword(string $password): array
    {


        if (empty($password)) {
            return ["success" => false, "message" => "El password es requerido"];
        }

        // Comprueba que la contraseña tiene al menos 8 caracteres
        if (strlen($password) < 50) {
            return ["success" => false, "message" => "El password es requerido"];
        }
        return ["success" => true];
    }
}
