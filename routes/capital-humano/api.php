<?php

use App\Http\Controllers\Capitalhumano\EmpleadoController;
use App\Http\Controllers\Capitalhumano\EmpleadoDocumentoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('empleados', EmpleadoController::class)->except('update');
Route::prefix('empleados')->group(function(){
    Route::post('/{empleado}', [EmpleadoController::class, 'update'])->name('update');
    Route::patch('/baja/{empleado}', [EmpleadoController::class, 'bajaEmpleado']);
});

Route::get('catalogos', [EmpleadoController::class, 'catalogos']);

Route::apiResource('colaboradores/{empleado}/documentos', EmpleadoDocumentoController::class)->except('update');
