<?php

use App\Http\Controllers\FormaPagoController;
use App\Http\Controllers\RegimenFiscalController;
use App\Http\Controllers\UsoCFDIController;
use Illuminate\Support\Facades\Route;

Route::get('formaspago', [FormaPagoController::class, 'index']);
Route::get('usocfdi', [UsoCFDIController::class, 'index']);
Route::get('regimenfiscal', [RegimenFiscalController::class, 'index']);
