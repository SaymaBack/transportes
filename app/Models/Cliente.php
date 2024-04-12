<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Cliente extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $fillable = [
        'nombre',
        'direccion',
        'rfc',
        'email',
        'telefono',
        'codigo_postal',
        'ciudad',
        'estado',
        'plazo',
        'regimen_fiscal',
        'contacto_administrativo',
        'contacto_operativo',
        'tipo_cliente_id',
        'forma_pago',
        'uso_cfdi',
        'estatus'
    ];

    public function tipoCliente(){
        return $this->hasOne(TipoCliente::class, 'id', 'tipo_cliente_id');
    }

    public function regimenFiscal(){
        return $this->hasOne(RegimenFiscal::class, 'c_RegimenFiscal', 'regimen_fiscal');
    }

    public function usoCFDI(){
        return $this->hasOne(RegimenFiscal::class, 'c_RegimenFiscal', 'regimen_fiscal');
    }

    public function formaPago(){
        return $this->hasOne(RegimenFiscal::class, 'c_RegimenFiscal', 'regimen_fiscal');
    }

}
