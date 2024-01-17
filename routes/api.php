<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::prefix('/v1/login')->group(__DIR__ . '/login/api.php');

Route::prefix('/v1/prueba')->group(__DIR__ . '/prueba/api.php')->withoutMiddleware("throttle:api")->middleware("throttle:240:1");
