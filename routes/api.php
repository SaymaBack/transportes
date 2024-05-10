<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function(){
    Route::prefix('login')->group(__DIR__ . '/login/api.php');

    Route::withoutMiddleware(["throttle:api"])->middleware(["throttle:240:1", "auth"])->group(function (){
        Route::prefix('clientes')->group(__DIR__ . '/clientes/api.php');
        Route::prefix('catalogos')->group(__DIR__ . '/catalogos/api.php');
    });
});
