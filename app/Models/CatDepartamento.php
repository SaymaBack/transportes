<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatDepartamento extends Model
{
    protected $table = 'cat_departamentos';

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public $timestamps = false;
}
