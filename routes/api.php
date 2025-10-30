<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Routing\Middleware\ThrottleRequests;


Route::get('/', function () {
    return response()->json(['message' => 'API is working'], 200);
});



Route::prefix('v1')
    ->as('v1.')
    ->middleware(ThrottleRequests::with(10,1)) // 10 requests per minute
    ->group(function () {

        include __DIR__ . '/api/v1.php';

    });

Route::prefix('v2')
    ->as('api.v2.')
    ->middleware(ThrottleRequests::with(15,1)) // 15 requests per minute for V2
    ->group(function () {

        include __DIR__ . '/api/v2.php';

    });