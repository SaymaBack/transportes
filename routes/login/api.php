<?php

use App\Http\Controllers\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






Route::post('/', [Login::class, 'auth']);
