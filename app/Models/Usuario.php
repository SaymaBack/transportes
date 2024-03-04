<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';

    protected $fillable = [
            'id',
            'usuario',
            'password',
            'eliminado',
    ];

    protected $hidden = [
        'password'
    ];
    public $timestamps = false;

}
