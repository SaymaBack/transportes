<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatCentroCosto extends Model
{
    protected $table = 'cat_centros_costo';

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public $timestamp = false;
}
