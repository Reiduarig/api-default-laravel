<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ApiErrorMonitoring
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        
        try {
            $response = $next($request);
            
            // Monitorear tiempo de respuesta
            $this->monitorResponseTime($request, $response, $startTime);
            
            // Monitorear errores frecuentes
            $this->monitorErrorPatterns($request, $response);
            
            return $response;
            
        } catch (\Throwable $e) {
            // Alertar sobre errores críticos
            $this->alertCriticalError($request, $e);
            throw $e;
        }
    }

    /**
     * Monitorea tiempos de respuesta lentos
     */
    private function monitorResponseTime(Request $request, Response $response, float $startTime): void
    {
        $responseTime = (microtime(true) - $startTime) * 1000; // en millisegundos
        
        // Alertar si la respuesta es muy lenta (>2 segundos)
        if ($responseTime > 2000) {
            Log::warning('Slow API Response Detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'response_time_ms' => round($responseTime, 2),
                'status_code' => $response->getStatusCode(),
                'user_id' => $request->user()?->id ?? 'anonymous'
            ]);
        }
    }

    /**
     * Monitorea patrones de errores frecuentes
     */
    private function monitorErrorPatterns(Request $request, Response $response): void
    {
        $statusCode = $response->getStatusCode();
        
        // Solo monitorear errores (4xx y 5xx)
        if ($statusCode < 400) {
            return;
        }
        
        $cacheKey = 'error_pattern_' . $request->ip() . '_' . $statusCode;
        $errorCount = Cache::increment($cacheKey, 1);
        
        // Si es la primera vez, establecer TTL de 5 minutos
        if ($errorCount === 1) {
            Cache::put($cacheKey, 1, now()->addMinutes(5));
        }
        
        // Alertar si hay muchos errores del mismo tipo desde la misma IP
        if ($errorCount >= 10) {
            Log::alert('High Error Rate Detected', [
                'ip' => $request->ip(),
                'status_code' => $statusCode,
                'error_count' => $errorCount,
                'url_pattern' => $request->path(),
                'user_id' => $request->user()?->id ?? 'anonymous',
                'last_5_minutes' => true
            ]);
            
            // Reset counter para evitar spam de alertas
            Cache::put($cacheKey, 0, now()->addMinutes(5));
        }
    }

    /**
     * Alerta sobre errores críticos del sistema
     */
    private function alertCriticalError(Request $request, \Throwable $e): void
    {
        $errorSignature = md5(get_class($e) . $e->getFile() . $e->getLine());
        $cacheKey = 'critical_error_' . $errorSignature;
        
        // Solo alertar una vez por hora por el mismo error
        if (!Cache::has($cacheKey)) {
            Log::critical('Critical API Error', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'user_id' => $request->user()?->id ?? 'anonymous',
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'request_data' => $this->sanitizeRequestData($request),
                'error_signature' => $errorSignature
            ]);
            
            Cache::put($cacheKey, true, now()->addHour());
        }
    }

    /**
     * Sanitiza datos sensibles del request para logging
     */
    private function sanitizeRequestData(Request $request): array
    {
        $data = $request->all();
        
        // Remover campos sensibles
        $sensitiveFields = ['password', 'password_confirmation', 'token', 'secret', 'key'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '[REDACTED]';
            }
        }
        
        return $data;
    }
}