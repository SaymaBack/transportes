<?php

use App\Http\Controllers\Files\FileDownloadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
}); */
Route::prefix('files')->group(function(){
    Route::get('/clientes/{cliente}/{documento?}', [FileDownloadController::class, 'descargarArchivosClientes'])->name('files.download');
    Route::get('/empleados/{empleado}/{documento?}', [FileDownloadController::class, 'descargarArchivosEmpleados'])->name('ch.files.download');
});


