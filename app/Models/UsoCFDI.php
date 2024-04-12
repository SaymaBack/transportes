<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsoCFDI extends Model
{
    protected $connection = 'sayma_db';

    protected $table = 'c_usocfdi';

    protected $fillable = [
        'c_UsoCFDI',
        'descripcion'
    ];

    public $timestamps = false;
}
