<?php

use App\Http\Controllers\Capitalhumano\EmpleadoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('empleados', EmpleadoController::class)->except('update');
Route::post('empleados/{empleado}', [EmpleadoController::class, 'update'])->name('update');

