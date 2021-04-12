<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;//Incluir el método categoria Controller

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('contenido');
});

// Route::get('/prueba', function () {
//     return view('principal');
// });

Route::get('/categoria', [CategoriaController::class,'index']);
Route::post('/categoria/registrar', [CategoriaController::class,'store']);//Registrar categoria
Route::put('/categoria/actualizar', [CategoriaController::class,'update']);//actualizar categoria
Route::put('/categoria/desactivar', [CategoriaController::class,'desactivar']);//desactivar categoria
Route::put('/categoria/activar', [CategoriaController::class,'activar']);//activar categoria

