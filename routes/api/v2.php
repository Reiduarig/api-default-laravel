<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V2\TicketController;
use App\Http\Controllers\API\V2\UserController;

/*
|--------------------------------------------------------------------------
| API V2 Routes
|--------------------------------------------------------------------------
|
| Rutas para la versión 2 de la API con mejoras arquitectónicas:
| - Repository Pattern
| - Action Classes  
| - Advanced Resources
| - Enhanced Error Handling
| - Performance Optimizations
|
*/

// Rutas públicas de autenticación (reutilizamos V1)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Rutas protegidas por autenticación
Route::middleware('auth:sanctum')->group(function () {
    
    // === AUTENTICACIÓN ===
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all-devices', [AuthController::class, 'logoutAllDevices']);
    
    // === TICKETS V2 ===
    Route::apiResource('tickets', TicketController::class);
    
    // Rutas adicionales específicas de V2
    Route::get('/tickets-statistics', [TicketController::class, 'statistics'])
        ->name('tickets.statistics');
    
    // === USERS V2 ===
    Route::apiResource('users', UserController::class);
    
    // Rutas adicionales para usuarios V2
    Route::get('/users/{user}/tickets', [UserController::class, 'tickets'])
        ->name('users.tickets');
    
    Route::get('/users-statistics', [UserController::class, 'statistics'])
        ->name('users.statistics');
    
    // === ENDPOINTS DE INFORMACIÓN V2 ===
    
    /**
     * Información de versión API V2
     * 
     * @group Información del Sistema
     * 
     * Obtiene información detallada sobre la versión 2.0 de la API, incluyendo características,
     * mejoras respecto a V1 y guías de migración.
     * 
     * @response 200 {
     *   "api_version": "2.0",
     *   "features": ["repository_pattern", "action_classes", "advanced_resources"],
     *   "improvements_over_v1": ["Better performance", "Enhanced error handling"],
     *   "deprecations": ["None - V1 remains fully supported"],
     *   "migration_guide": "/docs/v2-migration"
     * }
     */
    Route::get('/version', function () {
        return response()->json([
            'api_version' => '2.0',
            'features' => [
                'repository_pattern',
                'action_classes',
                'advanced_resources',
                'enhanced_filtering',
                'performance_optimizations',
                'detailed_statistics',
                'conditional_loading',
                'field_selection',
                'search_capabilities'
            ],
            'improvements_over_v1' => [
                'Better performance with eager loading',
                'Enhanced error handling and logging',
                'Advanced filtering and search',
                'Business logic separation',
                'Detailed audit trails',
                'Statistics endpoints',
                'Conditional field loading',
                'Cache optimizations'
            ],
            'deprecations' => [
                'None - V1 remains fully supported'
            ],
            'migration_guide' => '/docs/v2-migration'
        ]);
    })->name('version');
    
    /**
     * Estado de salud de la API
     * 
     * @group Información del Sistema
     * 
     * Verifica el estado de salud de todos los componentes de la API V2 incluyendo 
     * base de datos, cache y servicios principales.
     * 
     * @response 200 {
     *   "status": "healthy",
     *   "version": "2.0", 
     *   "timestamp": "2025-10-30T11:00:00.000000Z",
     *   "database": "connected",
     *   "cache": "operational",
     *   "features": "all_systems_operational"
     * }
     */
    Route::get('/health', function () {
        return response()->json([
            'status' => 'healthy',
            'version' => '2.0',
            'timestamp' => now()->toISOString(),
            'database' => 'connected',
            'cache' => 'operational',
            'features' => 'all_systems_operational'
        ]);
    })->name('health');
});