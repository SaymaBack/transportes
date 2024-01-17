<?php

namespace App\Http\interfaces;

use App\Models\Usuario;
use Illuminate\Http\Request;

interface JWT
{
    public function generarToke(string $username, int $id_user): array;
    public function validarToken(string $username): array;
}
