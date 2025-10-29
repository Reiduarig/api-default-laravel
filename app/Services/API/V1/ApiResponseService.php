<?php

namespace App\Services\API\V1;


use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
/** Servicio donde vamos a tener las respuestas que vamos a necesitar para nuestra aplicación, en vez de utilizar las responses de laravel */
/** La clase será abierta para poder heredar de ella en caso de que se creen nuevas versiones como una V2 */
class ApiResponseService
{

    public static function success($data, $message = 'Success', $code = Response::HTTP_OK): JsonResponse
    {
        // Si es una Resource Collection paginada, preservar la estructura
        if ($data instanceof \Illuminate\Http\Resources\Json\AnonymousResourceCollection && 
            $data->resource instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            
            // Obtener la respuesta original de la resource collection
            $originalResponse = $data->response()->getData(true);
            
            // Agregar nuestros campos personalizados
            $response = [
                'status' => 'success',
                'message' => $message,
                'data' => $originalResponse['data'],
                'links' => $originalResponse['links'] ?? null,
                'meta' => $originalResponse['meta'] ?? null,
            ];
            
            return response()->json($response, $code);
        }
        
        // Para datos no paginados, usar la estructura original
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    public static function successPaginated($resourceCollection, $message = 'Success', $code = Response::HTTP_OK): JsonResponse
    {
        // Método específico para colecciones paginadas
        $originalResponse = $resourceCollection->response()->getData(true);
        
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $originalResponse['data'],
            'links' => $originalResponse['links'] ?? null,
            'meta' => $originalResponse['meta'] ?? null,
        ], $code);
    }

    public static function error($message = 'Error', $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }


    public static function unauthorized($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public static function forbidden($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Forbidden',
        ], Response::HTTP_FORBIDDEN);
    }

    public static function notFound($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'No existe el recurso solicitado.',
        ], Response::HTTP_NOT_FOUND);
    }

    public static function validation($message = 'Validation Error', $errors = []): JsonResponse
    {
        Log::info('Validation errors: ', $errors);
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function throttled(int $maxAttempts = 60, int $retryAfter = 60): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Too many attempts, please slow down the request.',
            'retry_after' => $retryAfter,
            'max_attempts' => $maxAttempts,
        ], Response::HTTP_TOO_MANY_REQUESTS);
    }

}
