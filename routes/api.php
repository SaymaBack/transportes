<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function(){
    Route::prefix('login')->group(__DIR__ . '/login/api.php');

    Route::withoutMiddleware(["throttle:api"])->middleware(["throttle:240:1", "auth"])->group(function (){
        Route::prefix('operaciones')->group(__DIR__ . '/operaciones/api.php');

        Route::prefix('capital-humano')->group(__DIR__ . '/capital-humano/api.php');

        Route::prefix('catalogos')->group(__DIR__ . '/catalogos/api.php');
    });
});
