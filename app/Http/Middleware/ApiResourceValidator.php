<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\API\V1\ApiResponseService;
use Illuminate\Support\Facades\Log;

class ApiResourceValidator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Validar estructura de request para APIs
            if ($request->is('api/*')) {
                $this->validateApiRequest($request);
            }
            
            return $next($request);
            
        } catch (\InvalidArgumentException $e) {
            return $this->handleValidationError($request, $e);
        } catch (\Throwable $e) {
            return $this->handleUnexpectedError($request, $e);
        }
    }

    /**
     * Valida la estructura básica de requests API
     */
    private function validateApiRequest(Request $request): void
    {
        // Validar Content-Type para requests POST/PUT/PATCH
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH']) && 
            !$request->isJson() && 
            !empty($request->getContent())) {
            throw new \InvalidArgumentException(
                'Content-Type debe ser application/json para este tipo de request.'
            );
        }

        // Validar Accept header
        if (!$request->accepts(['application/json', '*/*'])) {
            throw new \InvalidArgumentException(
                'Accept header debe incluir application/json.'
            );
        }

        // Validar parámetros de paginación
        if ($request->has('per_page')) {
            $perPage = $request->get('per_page');
            if (!is_numeric($perPage) || $perPage < 1 || $perPage > 100) {
                throw new \InvalidArgumentException(
                    'El parámetro per_page debe ser un número entre 1 y 100.'
                );
            }
        }

        // Validar parámetros de ordenamiento
        if ($request->has('sort')) {
            $sort = $request->get('sort');
            if (!is_string($sort) || strlen($sort) > 100) {
                throw new \InvalidArgumentException(
                    'El parámetro sort no tiene un formato válido.'
                );
            }
        }
    }

    /**
     * Maneja errores de validación
     */
    private function handleValidationError(Request $request, \InvalidArgumentException $e): Response
    {
        $apiVersion = $this->getApiVersion($request);
        
        Log::warning('API Request Validation Error', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'error' => $e->getMessage(),
            'user_id' => $request->user()?->id ?? 'anonymous'
        ]);

        return ApiResponseService::error(
            $e->getMessage(),
            400,
            [
                'error_code' => 'INVALID_REQUEST_FORMAT',
                'api_version' => $apiVersion,
                'help' => [
                    'content_type' => 'Usa Content-Type: application/json para POST/PUT/PATCH',
                    'accept' => 'Incluye Accept: application/json en los headers',
                    'pagination' => 'per_page debe ser un número entre 1 y 100',
                    'sorting' => 'sort debe ser una string válida (ej: "name,-created_at")'
                ]
            ]
        );
    }

    /**
     * Maneja errores inesperados
     */
    private function handleUnexpectedError(Request $request, \Throwable $e): Response
    {
        $apiVersion = $this->getApiVersion($request);
        
        Log::error('Unexpected Error in API Resource Validator', [
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'user_id' => $request->user()?->id ?? 'anonymous'
        ]);

        return ApiResponseService::error(
            'Error en la validación del request.',
            500,
            [
                'error_code' => 'VALIDATION_ERROR',
                'api_version' => $apiVersion,
                'error_id' => uniqid('val_', true)
            ]
        );
    }

    /**
     * Determina la versión de API basada en la URL
     */
    private function getApiVersion(Request $request): string
    {
        if ($request->is('api/v2/*')) {
            return '2.0';
        } elseif ($request->is('api/v1/*')) {
            return '1.0';
        }
        
        return 'unknown';
    }
}