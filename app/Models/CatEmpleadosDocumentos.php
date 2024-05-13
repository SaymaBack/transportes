<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatEmpleadosDocumentos extends Model
{
    protected $table = 'cat_empleados_documentos';

    protected $fillable = [
        'nombre',
        'aplica_puestos',
        'activo'
    ];

    protected $casts = [
        'aplica_puestos' => 'array'
    ];
}
