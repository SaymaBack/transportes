<?php
namespace App\Http\interfaces;

use App\Models\Usuario;

interface Authentication
{
    public function authenticate(array $data): array;
    
}