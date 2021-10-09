<?php

use App\Http\Controllers\AccionController;
use Illuminate\Support\Facades\Route;
//Controladores
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\EmpresaController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('blog', BlogController::class);
    Route::resource('home', HomeController::class);
    Route::resource('empresa', EmpresaController::class);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/consultas', [AccionController::class, 'index'])->name('consulta.index');
    Route::post('/consultas/sat', [AccionController::class, 'getConsulta'])->name('consulta.sat');
    Route::get('/consultas/Verificar/{requestId}', [AccionController::class, 'getVerificar'])->name('consulta.verificar');
    Route::get('/consultas/descargar/{packagesIds}', [AccionController::class, 'getPaquetes'])->name('consulta.descargar');
});
