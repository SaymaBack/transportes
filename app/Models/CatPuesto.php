<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatPuesto extends Model
{
    protected $table = 'cat_puestos';

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public $timestamps = false;
}
