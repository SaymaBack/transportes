<?php

namespace App\Http\interfaces;

use App\Models\Usuario;

interface Validation
{
    // public function validateUsername(string $username): array;
    // public function validatePassword(string $password): array;
    public function validateExistUsername(array $data): array;
    public function validateExistPassword(array $data): array;
}
