<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatTipoNomina extends Model
{
    protected $table = 'cat_tipos_nomina';

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public $timestamp = false;
}
