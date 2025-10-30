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
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Middleware personalizado para APIs
        $middleware->group('api', [
            \App\Http\Middleware\ApiErrorMonitoring::class,    // Middleware de monitoreo y logging de errores API: captura y registra errores en tiempo real para análisis y alertas.
            \App\Http\Middleware\ApiResourceValidator::class,  // Middleware de validación de requests API: verifica la estructura y los datos de entrada, asegurando que cumplan con las especificaciones del API.
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Manejo específico de errores de autenticación (tokens inválidos/expirados)
        $exceptions->render(function (AuthenticationException $exception, $request) {
            Log::warning('Authentication Failed', [
                'url' => $request->fullUrl(),
                'user_id' => $request->user()?->id ?? 'anonymous',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'message' => $exception->getMessage(),
                'token_provided' => $request->bearerToken() ? 'yes' : 'no'
            ]);

            return ApiResponseService::unauthorized(
                'Token de autenticación inválido o expirado.',
                [
                    'error_code' => 'INVALID_TOKEN',
                    'api_version' => $request->is('api/v2/*') ? '2.0' : '1.0',
                    'guards' => $exception->guards()
                ]
            );
        });

        // Manejo mejorado de errores de throttling
        $exceptions->render(function (ThrottleRequestsException $exception, $request) {
            $retryAfter = data_get($exception->getHeaders(),'Retry-After');
            $maxAttempts = data_get($exception->getHeaders(),'X-RateLimit-Limit');
            
            Log::warning('Rate Limit Exceeded', [
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_id' => $request->user()?->id ?? 'anonymous',
                'retry_after' => $retryAfter,
                'max_attempts' => $maxAttempts
            ]);

            return ApiResponseService::throttled(
                maxAttempts: $maxAttempts,
                retryAfter: $retryAfter,
            );
        });

        // Manejo mejorado de modelos no encontrados
        $exceptions->render(function (ModelNotFoundException $exception, $request) {
            $model = class_basename($exception->getModel());
            
            Log::info('Model Not Found', [
                'model' => $model,
                'url' => $request->fullUrl(),
                'user_id' => $request->user()?->id ?? 'anonymous'
            ]);
            
            return ApiResponseService::notFound(
                "El recurso {$model} solicitado no fue encontrado.",
                [
                    'error_code' => 'RESOURCE_NOT_FOUND',
                    'resource_type' => strtolower($model),
                    'api_version' => $request->is('api/v2/*') ? '2.0' : '1.0'
                ]
            );
        });

        // Manejo mejorado de errores de validación
        $exceptions->render(function (ValidationException $exception, $request) {
            Log::info('Validation Failed', [
                'url' => $request->fullUrl(),
                'errors' => $exception->errors(),
                'user_id' => $request->user()?->id ?? 'anonymous'
            ]);
            
            return ApiResponseService::validation(
                'Los datos proporcionados no son válidos.',
                $exception->errors(),
                [
                    'error_code' => 'VALIDATION_FAILED',
                    'api_version' => $request->is('api/v2/*') ? '2.0' : '1.0'
                ]
            );
        });

        // Manejo mejorado de errores de autorización
        $exceptions->render(function (AuthorizationException $exception, $request) {
            Log::warning('Authorization Failed', [
                'url' => $request->fullUrl(),
                'user_id' => $request->user()?->id ?? 'anonymous',
                'message' => $exception->getMessage()
            ]);
            
            return ApiResponseService::forbidden(
                'No tienes permisos para realizar esta acción.',
                [
                    'error_code' => 'FORBIDDEN',
                    'api_version' => $request->is('api/v2/*') ? '2.0' : '1.0'
                ]
            );
        });

        // Manejo mejorado de acceso denegado
        $exceptions->render(function (AccessDeniedHttpException $exception, $request) {
            Log::warning('Access Denied', [
                'url' => $request->fullUrl(),
                'user_id' => $request->user()?->id ?? 'anonymous',
                'message' => $exception->getMessage()
            ]);
            
            return ApiResponseService::unauthorized(
                'Acceso denegado. Verifica tus credenciales.',
                [
                    'error_code' => 'ACCESS_DENIED',
                    'api_version' => $request->is('api/v2/*') ? '2.0' : '1.0'
                ]
            );
        });

        // Manejo mejorado de rutas no encontradas
        $exceptions->render(function (NotFoundHttpException $exception, $request) {
            if ($request->is('api/*')) {
                Log::info('API Route Not Found', [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_id' => $request->user()?->id ?? 'anonymous'
                ]);
                
                return ApiResponseService::notFound(
                    'La ruta solicitada no existe.',
                    [
                        'error_code' => 'ROUTE_NOT_FOUND',
                        'requested_url' => $request->fullUrl(),
                        'api_version' => $request->is('api/v2/*') ? '2.0' : '1.0'
                    ]
                );
            }
            
            // Para rutas no API, usar manejo estándar
            return null;
        });

        // Manejo de errores genéricos 500
        $exceptions->render(function (\Throwable $exception, $request) {
            if ($request->is('api/*')) {
                $isDevelopment = config('app.debug', false);
                $apiVersion = $request->is('api/v2/*') ? '2.0' : '1.0';
                
                Log::error('API Internal Server Error', [
                    'exception' => get_class($exception),
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_id' => $request->user()?->id ?? 'anonymous',
                    'trace' => $exception->getTraceAsString()
                ]);

                if ($isDevelopment) {
                    return ApiResponseService::error(
                        'Error interno del servidor.',
                        500,
                        [
                            'error_code' => 'INTERNAL_SERVER_ERROR',
                            'api_version' => $apiVersion,
                            'debug_info' => [
                                'exception' => get_class($exception),
                                'message' => $exception->getMessage(),
                                'file' => $exception->getFile(),
                                'line' => $exception->getLine()
                            ]
                        ]
                    );
                }

                return ApiResponseService::error(
                    'Ha ocurrido un error interno. Por favor, inténtalo de nuevo más tarde.',
                    500,
                    [
                        'error_code' => 'INTERNAL_SERVER_ERROR',
                        'api_version' => $apiVersion,
                        'error_id' => uniqid('err_', true),
                        'timestamp' => now()->toISOString()
                    ]
                );
            }
            
            // Para rutas no API, usar manejo estándar
            return null;
        });

        
    })->create();
