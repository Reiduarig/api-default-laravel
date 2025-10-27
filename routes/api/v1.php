<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TicketController;


Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::apiResource('tickets', TicketController::class);


Route::middleware('auth:sanctum')->group(function () {

    // Route::apiResource('tickets', TicketController::class)->name('tickets');

});

