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

Route::get('/files/clientes/{cliente}/{documento?}', [FileDownloadController::class, 'descargarArchivosClientes'])->name('files.download');

