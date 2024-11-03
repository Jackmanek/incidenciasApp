<?php

use App\Http\Controllers\AuthApiControllerr;
use App\Http\Controllers\IncidenciaApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthApiControllerr::class, 'register']);
Route::post('login',[AuthApiControllerr::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('logout', [AuthApiControllerr::class, 'logout']);
    Route::get('incidencias',[IncidenciaApiController::class,'listIncidencias']);
});
