<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Routing\Middleware\ThrottleRequests;


Route::prefix('v1')
    ->as('v1.')
    ->middleware(ThrottleRequests::with(10,1)) // 10 requests per minute
    ->group(function () {

        include __DIR__ . '/api/v1.php';

    });