<?php

use App\Http\Controllers\Capitalhumano\EmpleadoController;
use App\Http\Controllers\Capitalhumano\EmpleadoDocumentoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('empleados', EmpleadoController::class)->except('update');
Route::post('empleados/{empleado}', [EmpleadoController::class, 'update'])->name('update');

Route::apiResource('colaboradores/{empleado}/documentos', EmpleadoDocumentoController::class);
