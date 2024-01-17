<?php


use App\Http\Controllers\Prueba;
use App\Http\Middleware\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;






Route::get('/', [Prueba::class, 'index'])->middleware(Auth::class);
