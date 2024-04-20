<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ClienteDocumentoController;
use Illuminate\Support\Facades\Route;


Route::apiResource('clientes', ClienteController::class);

Route::get('tipos', [ClienteController::class, 'tiposClientes']);

Route::patch('estatus/{cliente}', [ClienteController::class, 'cambiaEstatusCliente']);

Route::name('cte_documentos.')->prefix('documentos')->controller(ClienteDocumentoController::class)->group(function(){
    Route::get('/{cliente}', 'index')->name('index');
    Route::get('/show/{clienteDocumento}', 'show')->name('show');
    Route::post('/{cliente}', 'store')->name('store');
    Route::put('/{clienteDocumento}', 'update')->name('update');
    Route::delete('/{clienteDocumento}', 'destroy')->name('destroy');
});
