<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\TicketController;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
});



Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('users', UserController::class)
        ->only(['index', 'show'])
        ->name('*', 'users');

    Route::apiResource('tickets', TicketController::class)
        ->only(['index', 'show'])
        ->name('*', 'tickets');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

