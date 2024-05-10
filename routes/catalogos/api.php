<?php

use App\Http\Controllers\Catalogos\CatDocumentoController;
use App\Http\Controllers\Catalogos\FormaPagoController;
use App\Http\Controllers\Catalogos\RegimenFiscalController;
use App\Http\Controllers\Catalogos\UsoCFDIController;
use Illuminate\Support\Facades\Route;

Route::get('formaspago', [FormaPagoController::class, 'index']);
Route::get('usocfdi', [UsoCFDIController::class, 'index']);
Route::get('regimenfiscal', [RegimenFiscalController::class, 'index']);
Route::apiResource('catDocumentos', CatDocumentoController::class);
