<?php  

namespace App\Traits;
use Illuminate\Http\JsonResponse;

trait ApiResponses {

    protected function success(string $message, $data = [], $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function error($message, $statusCode): JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
        ], $statusCode);
    }
}