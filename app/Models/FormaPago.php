<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $connection = 'sayma_db';

    protected $table = 'c_formapago';

    protected $fillable = [
        'c_FormaPago',
        'descripcion'
    ];

    public $timestamps = false;
}
