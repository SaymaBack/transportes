<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpleadoDocumento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'empleado_id',
        'empleado_documento_id',
        'path',
        'expiracion',
        'excluir'
    ];

    public function empleado(){
        return $this->hasOne(Empleado::class);
    }

    public function documento(){
        return $this->hasOne(CatEmpleadosDocumentos::class, 'id', 'empleado_documento_id');
    }
}
