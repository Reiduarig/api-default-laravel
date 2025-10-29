<?php

use App\Exceptions\Api\V1\ApiExceptions;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Services\API\V1\ApiResponseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (ThrottleRequestsException $exception)
        {
            $retryAfter = data_get($exception->getHeaders(),'Retry-After');
            $maxAttempts = data_get($exception->getHeaders(),'X-RateLimit-Limit');

            return ApiResponseService::throttled(
                maxAttempts: $maxAttempts,
                retryAfter: $retryAfter,
            );
        });

        $exceptions->render(function (ModelNotFoundException $exception) {
            return ApiResponseService::notFound($exception->getMessage());
        });

        $exceptions->render(function (ValidationException $exception) {
            return ApiResponseService::validation($exception->getMessage(), $exception->errors());
        });

        $exceptions->render(function (AuthorizationException $exception) {
            return ApiResponseService::forbidden($exception->getMessage());
        });

        $exceptions->render(function (AccessDeniedHttpException $exception) {
            return ApiResponseService::unauthorized($exception->getMessage());
        });

        $exceptions->render(function (NotFoundHttpException $exception) {
            return ApiResponseService::notFound($exception->getMessage());
        });

        
    })->create();
