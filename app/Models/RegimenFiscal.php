<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegimenFiscal extends Model
{
    protected $connection = 'sayma_db';

    protected $table = 'c_regimenfiscal';

    protected $fillable = [
        'c_RegimenFiscal',
        'descripcion'
    ];

    public $timestamps = false;
}
