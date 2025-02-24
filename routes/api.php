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

