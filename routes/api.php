<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TranslationController;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [AuthController::class, 'login']);

Route::apiResource('translation', TranslationController::class)
        ->middleware('auth:sanctum')
        ->only('index','store','update');
