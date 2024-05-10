<?php

use App\Http\Controllers\Auth\Login;
use Illuminate\Support\Facades\Route;

Route::post('/', [Login::class, 'auth']);
