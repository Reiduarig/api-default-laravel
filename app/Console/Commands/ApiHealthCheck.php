<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Ticket;
use Carbon\Carbon;

class ApiHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'api:health-check {--report : Generate detailed report}';

    /**
     * The console command description.
     */
    protected $description = 'Verifica el estado de salud de la API y genera reportes de errores';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏥 Iniciando verificación de salud de la API...');
        
        $checks = [
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'authentication' => $this->checkAuthentication(),
            'api_endpoints' => $this->checkApiEndpoints(),
            'error_rates' => $this->checkErrorRates(),
            'performance' => $this->checkPerformance(),
        ];
        
        $this->displayResults($checks);
        
        if ($this->option('report')) {
            $this->generateDetailedReport($checks);
        }
        
        $overallHealth = $this->calculateOverallHealth($checks);
        
        if ($overallHealth < 80) {
            $this->error("⚠️  Estado de salud crítico: {$overallHealth}%");
            return 1;
        } elseif ($overallHealth < 90) {
            $this->warn("⚠️  Estado de salud regular: {$overallHealth}%");
        } else {
            $this->info("✅ Estado de salud excelente: {$overallHealth}%");
        }
        
        return 0;
    }

    /**
     * Verifica la conectividad de la base de datos
     */
    private function checkDatabase(): array
    {
        try {
            $start = microtime(true);
            $userCount = User::count();
            $ticketCount = Ticket::count();
            $responseTime = (microtime(true) - $start) * 1000;
            
            return [
                'status' => 'healthy',
                'details' => [
                    'users' => $userCount,
                    'tickets' => $ticketCount,
                    'response_time_ms' => round($responseTime, 2)
                ],
                'score' => $responseTime < 100 ? 100 : max(0, 100 - ($responseTime / 10))
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
                'score' => 0
            ];
        }
    }

    /**
     * Verifica el sistema de cache
     */
    private function checkCache(): array
    {
        try {
            $testKey = 'health_check_' . time();
            $testValue = 'test_value';
            
            Cache::put($testKey, $testValue, 60);
            $retrieved = Cache::get($testKey);
            Cache::forget($testKey);
            
            $working = $retrieved === $testValue;
            
            return [
                'status' => $working ? 'healthy' : 'unhealthy',
                'details' => ['cache_test' => $working],
                'score' => $working ? 100 : 0
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
                'score' => 0
            ];
        }
    }

    /**
     * Verifica el sistema de autenticación
     */
    private function checkAuthentication(): array
    {
        try {
            // Verificar que existan usuarios activos con tokens
            $usersWithTokens = DB::table('personal_access_tokens')->count();
            $activeTokens = DB::table('personal_access_tokens')
                ->where('expires_at', '>', now())
                ->orWhereNull('expires_at')
                ->count();
            
            return [
                'status' => 'healthy',
                'details' => [
                    'total_tokens' => $usersWithTokens,
                    'active_tokens' => $activeTokens
                ],
                'score' => 100
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
                'score' => 0
            ];
        }
    }

    /**
     * Verifica endpoints críticos de la API
     */
    private function checkApiEndpoints(): array
    {
        $endpoints = [
            '/api/v1' => 'V1 Health',
            '/api/v2' => 'V2 Health',
            '/api/v2/version' => 'V2 Version',
            '/api/v2/health' => 'V2 Health Check'
        ];
        
        $results = [];
        $totalScore = 0;
        
        foreach ($endpoints as $endpoint => $description) {
            try {
                $start = microtime(true);
                $response = $this->makeInternalRequest($endpoint);
                $responseTime = (microtime(true) - $start) * 1000;
                
                $score = $response ? (min(100, max(0, 100 - ($responseTime / 10)))) : 0;
                
                $results[$endpoint] = [
                    'status' => $response ? 'healthy' : 'unhealthy',
                    'response_time_ms' => round($responseTime, 2),
                    'score' => $score
                ];
                
                $totalScore += $score;
            } catch (\Exception $e) {
                $results[$endpoint] = [
                    'status' => 'unhealthy',
                    'error' => $e->getMessage(),
                    'score' => 0
                ];
            }
        }
        
        return [
            'status' => count(array_filter($results, fn($r) => $r['status'] === 'healthy')) > 0 ? 'healthy' : 'unhealthy',
            'details' => $results,
            'score' => $totalScore / count($endpoints)
        ];
    }

    /**
     * Analiza las tasas de error recientes
     */
    private function checkErrorRates(): array
    {
        try {
            $logFile = storage_path('logs/laravel.log');
            
            if (!file_exists($logFile)) {
                return [
                    'status' => 'healthy',
                    'details' => ['log_file' => 'not_found'],
                    'score' => 100
                ];
            }
            
            $recentLogs = $this->getRecentLogEntries($logFile, 60); // últimos 60 minutos
            
            $errorCount = substr_count($recentLogs, '.ERROR:');
            $criticalCount = substr_count($recentLogs, '.CRITICAL:');
            $warningCount = substr_count($recentLogs, '.WARNING:');
            
            $totalIssues = $errorCount + $criticalCount + ($warningCount * 0.5);
            
            // Calcular score basado en número de errores
            $score = max(0, 100 - ($totalIssues * 5));
            
            return [
                'status' => $totalIssues < 10 ? 'healthy' : 'unhealthy',
                'details' => [
                    'errors_last_hour' => $errorCount,
                    'critical_last_hour' => $criticalCount,
                    'warnings_last_hour' => $warningCount,
                    'total_issues' => $totalIssues
                ],
                'score' => $score
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unknown',
                'error' => $e->getMessage(),
                'score' => 50
            ];
        }
    }

    /**
     * Verifica métricas de rendimiento
     */
    private function checkPerformance(): array
    {
        try {
            $start = microtime(true);
            
            // Test de consulta compleja
            $complexQuery = DB::table('tickets')
                ->join('users', 'tickets.user_id', '=', 'users.id')
                ->select('tickets.*', 'users.name as user_name')
                ->where('tickets.status', 'A')
                ->limit(10)
                ->get();
            
            $queryTime = (microtime(true) - $start) * 1000;
            
            // Verificar uso de memoria
            $memoryUsage = memory_get_usage(true) / 1024 / 1024; // MB
            $peakMemory = memory_get_peak_usage(true) / 1024 / 1024; // MB
            
            $score = min(100, max(0, 100 - ($queryTime / 5) - ($memoryUsage / 10)));
            
            return [
                'status' => $queryTime < 500 && $memoryUsage < 128 ? 'healthy' : 'degraded',
                'details' => [
                    'complex_query_time_ms' => round($queryTime, 2),
                    'memory_usage_mb' => round($memoryUsage, 2),
                    'peak_memory_mb' => round($peakMemory, 2),
                    'query_result_count' => $complexQuery->count()
                ],
                'score' => $score
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unhealthy',
                'error' => $e->getMessage(),
                'score' => 0
            ];
        }
    }

    /**
     * Realiza una request interna para verificar endpoints
     */
    private function makeInternalRequest(string $endpoint): bool
    {
        try {
            $url = config('app.url') . $endpoint;
            $context = stream_context_create([
                'http' => [
                    'timeout' => 5,
                    'method' => 'GET',
                    'header' => 'Accept: application/json'
                ]
            ]);
            
            $response = @file_get_contents($url, false, $context);
            return $response !== false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Obtiene entradas de log recientes
     */
    private function getRecentLogEntries(string $logFile, int $minutes): string
    {
        $cutoffTime = Carbon::now()->subMinutes($minutes);
        $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        $recentLines = [];
        foreach (array_reverse($lines) as $line) {
            if (preg_match('/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/', $line, $matches)) {
                $logTime = Carbon::createFromFormat('Y-m-d H:i:s', $matches[1]);
                if ($logTime->gte($cutoffTime)) {
                    $recentLines[] = $line;
                } else {
                    break;
                }
            }
        }
        
        return implode("\n", array_reverse($recentLines));
    }

    /**
     * Muestra los resultados de las verificaciones
     */
    private function displayResults(array $checks): void
    {
        $this->info('📊 Resultados de la verificación:');
        $this->newLine();
        
        foreach ($checks as $checkName => $result) {
            $status = $result['status'];
            $score = $result['score'] ?? 0;
            
            $icon = match($status) {
                'healthy' => '✅',
                'unhealthy' => '❌',
                'degraded' => '⚠️',
                default => '❓'
            };
            
            $this->line("$icon " . ucfirst(str_replace('_', ' ', $checkName)) . ": $status (Score: {$score}%)");
            
            if (isset($result['error'])) {
                $this->error("   Error: " . $result['error']);
            }
            
            if (isset($result['details']) && is_array($result['details'])) {
                foreach ($result['details'] as $key => $value) {
                    if (is_array($value)) {
                        $this->line("   " . ucfirst(str_replace('_', ' ', $key)) . ":");
                        foreach ($value as $subKey => $subValue) {
                            $this->line("     $subKey: $subValue");
                        }
                    } else {
                        $this->line("   " . ucfirst(str_replace('_', ' ', $key)) . ": $value");
                    }
                }
            }
            
            $this->newLine();
        }
    }

    /**
     * Genera un reporte detallado
     */
    private function generateDetailedReport(array $checks): void
    {
        $reportPath = storage_path('logs/api_health_report_' . date('Y-m-d_H-i-s') . '.json');
        
        $report = [
            'timestamp' => now()->toISOString(),
            'overall_health' => $this->calculateOverallHealth($checks),
            'checks' => $checks,
            'recommendations' => $this->generateRecommendations($checks)
        ];
        
        file_put_contents($reportPath, json_encode($report, JSON_PRETTY_PRINT));
        
        $this->info("📄 Reporte detallado guardado en: $reportPath");
    }

    /**
     * Calcula el estado de salud general
     */
    private function calculateOverallHealth(array $checks): int
    {
        $totalScore = 0;
        $count = 0;
        
        foreach ($checks as $check) {
            if (isset($check['score'])) {
                $totalScore += $check['score'];
                $count++;
            }
        }
        
        return $count > 0 ? round($totalScore / $count) : 0;
    }

    /**
     * Genera recomendaciones basadas en los resultados
     */
    private function generateRecommendations(array $checks): array
    {
        $recommendations = [];
        
        foreach ($checks as $checkName => $result) {
            if ($result['status'] === 'unhealthy' || $result['status'] === 'degraded') {
                $recommendations[] = match($checkName) {
                    'database' => 'Verificar la conectividad y rendimiento de la base de datos',
                    'cache' => 'Revisar la configuración del sistema de cache',
                    'authentication' => 'Verificar el sistema de autenticación Sanctum',
                    'api_endpoints' => 'Revisar la disponibilidad de los endpoints críticos',
                    'error_rates' => 'Investigar la alta tasa de errores en los logs',
                    'performance' => 'Optimizar consultas y uso de memoria',
                    default => "Revisar el componente $checkName"
                };
            }
        }
        
        return $recommendations;
    }
}
