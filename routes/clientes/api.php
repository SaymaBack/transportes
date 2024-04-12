<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;


Route::apiResource('clientes', ClienteController::class);

Route::get('tipos', [ClienteController::class, 'tiposClientes']);
