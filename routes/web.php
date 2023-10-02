<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
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
    return view('auth.login'); //envia directo al login
});


Route::get('/empleado', function () {
    return view('empleado.index');
});

//Route::get('/empleado/create',[EmpleadoController::class,'create']);

Route::resource('empleado', EmpleadoController::class)->middleware('auth'); //middleware('auth') lo utilizo para que respete la autentificacion
Auth::routes(['register'=>false,'reset'=>false]); //saco las opciones de registro y de resetear contraseña

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware'=>'auth'],function(){
    Route::get('/', [EmpleadoController::class, 'index'])->name('home'); //cuando se loggea va directo al index
});
