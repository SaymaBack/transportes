<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'ape_pat',
        'ape_mat',
        'fecha_nac',
        'rfc',
        'curp',
        'imss',
        'num_empleado',
        'departamento_id',
        'puesto_id',
        'tipo_nomina_id',
        'centro_costo_id',
        'sueldo_diario',
        'integrado',
        'clabe',
        'banco',
        'foto',
        'alta',
        'activo'
    ];

    public function documentos(){
        return $this->hasMany(EmpleadoDocumento::class);
    }
}
