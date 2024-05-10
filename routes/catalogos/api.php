<?php

use App\Http\Controllers\Catalogos\CatCentroCostoController;
use App\Http\Controllers\Catalogos\CatDepartamentoController;
use App\Http\Controllers\Catalogos\CatDocumentoController;
use App\Http\Controllers\Catalogos\CatPuestoController;
use App\Http\Controllers\Catalogos\CatTipoNominaController;
use App\Http\Controllers\Catalogos\FormaPagoController;
use App\Http\Controllers\Catalogos\RegimenFiscalController;
use App\Http\Controllers\Catalogos\UsoCFDIController;
use Illuminate\Support\Facades\Route;

Route::get('formaspago', [FormaPagoController::class, 'index']);
Route::get('usocfdi', [UsoCFDIController::class, 'index']);
Route::get('regimenfiscal', [RegimenFiscalController::class, 'index']);
Route::apiResource('catDocumentos', CatDocumentoController::class);

/** Capital Humano Catalogos */
Route::apiResource('catDepartamentos', CatDepartamentoController::class)->except('destroy');
Route::apiResource('catPuestos', CatPuestoController::class)->except('destroy');
Route::apiResource('catTipoNominas', CatTipoNominaController::class)->except('destroy');
Route::apiResource('catCentroCostos', CatCentroCostoController::class)->except('destroy');
Route::apiResource('catEmpleadosDocumentos', CatDepartamentoController::class)->except('destroy');
