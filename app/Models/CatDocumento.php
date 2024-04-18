<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatDocumento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'require_token',
        'active',
        'tipos_clientes'
    ];

    protected $casts = [
        'tipos_clientes' => 'array'
    ];
}
