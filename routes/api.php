<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(\App\Http\Controllers\LoginController::class)->group(function (){
    Route::prefix('login')->group(function () {
        Route::post('/process','process');
    });
});

Route::apiResource('organizations', \App\Http\Controllers\OrganizationController::class);



Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [\App\Http\Controllers\API\AuthController::class, 'logout']);

Route::get('/list_part', [\App\Http\Controllers\PartController::class, 'getPart']);


Route::get('/get-data', [\App\Http\Controllers\API\SocketController::class, 'getData']);
Route::post('/update-running-status', [\App\Http\Controllers\API\SocketController::class, 'updateRunningStatus']);

Route::get('/socket/{id}/error', [\App\Http\Controllers\RestController::class, 'store'])->name('socket.error');
Route::post('/update-error-log', [\App\Http\Controllers\API\SocketController::class, 'updateErrorLog'])->name('api.updateErrorLog');
Route::post('/log-error', [\App\Http\Controllers\API\SocketController::class, 'log-error'])->name('api.log-error');
http://127.0.0.1:8000/api/log-error
