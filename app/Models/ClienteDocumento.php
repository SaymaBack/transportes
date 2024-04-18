<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteDocumento extends Model
{
    use SoftDeletes;

    protected $table = 'clientes_documentos';

    protected $fillable = [
        'cliente_id',
        'documento_id',
        'path',
        'file_name',
        'expiracion',
        'excluir'
    ];

    public function cliente(){
        return $this->hasOne(Cliente::class);
    }
}
