<?php

use App\Http\Controllers\Empresa\EmpresaController;
use App\Http\Controllers\Service\FielController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\Service\SolicitudController;
use App\Http\Controllers\Users\AbilitiesController;
use App\Http\Controllers\Users\PermissionController;
use App\Http\Controllers\Users\RolController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('empresa', EmpresaController::class);
Route::post('/empresa/fiel/{empresa}', [FielController::class, 'createFiel']);

Route::post('/procesamiento/consultation/{empresa}', [ServiceController::class, 'getConsultation']);
Route::post('/procesamiento/{empresa}/verification/{requestId}', [ServiceController::class, 'getVerification']);
Route::post('/procesamiento/{empresa}/downloadLink/{packagesIds}', [ServiceController::class, 'getDownloadLink']);

Route::apiResource('permission', PermissionController::class);
Route::apiResource('role', RolController::class);
Route::apiResource('user', UsersController::class);

Route::apiResource('ability', AbilitiesController::class);
