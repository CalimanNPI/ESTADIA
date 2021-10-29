<?php

use App\Http\Controllers\AccionController;
use Illuminate\Support\Facades\Route;
//Controladores
use App\Http\Controllers\Users\RolController;
use App\Http\Controllers\Users\UsersController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RolController::class);
    Route::resource('user', UsersController::class);
});

Route::view('/{any}', 'dashboard')
    ->middleware('auth')
    ->where('any', '.*');
