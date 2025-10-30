<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Controllers\API\V1\Controller;
use App\Services\API\V1\ApiResponseService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

/**
 * Controlador base para API V2 con mejoras y optimizaciones
 */
class ApiController extends Controller
{
    use AuthorizesRequests;

    protected $policyClass;

    /**
     * Verifica si el usuario actual tiene autorización para realizar una acción específica
     * Versión mejorada con mejor manejo de errores
     */
    public function isAble($ability, $targetModel)
    {
        return $this->authorize($ability, [$targetModel, $this->policyClass]);
    }

    /**
     * Maneja parámetros de inclusión de relaciones de manera más robusta
     */
    protected function getIncludeRelations(Request $request, array $allowed = []): array
    {
        $includes = $request->get('include', '');
        
        if (empty($includes)) {
            return [];
        }
        
        $requestedIncludes = explode(',', $includes);
        $validIncludes = [];
        
        foreach ($requestedIncludes as $include) {
            $include = trim($include);
            if (in_array($include, $allowed)) {
                $validIncludes[] = $include;
            }
        }
        
        return $validIncludes;
    }

    /**
     * Maneja parámetros de campos específicos para optimización
     */
    protected function getFieldSelection(Request $request, string $resourceType): array
    {
        $fields = $request->get('fields', []);
        
        if (!is_array($fields) || !isset($fields[$resourceType])) {
            return [];
        }
        
        return explode(',', $fields[$resourceType]);
    }

    /**
     * Aplica filtros de búsqueda avanzada
     */
    protected function applySearch($query, Request $request, array $searchableFields = [])
    {
        $search = $request->get('search');
        
        if (empty($search) || empty($searchableFields)) {
            return $query;
        }
        
        return $query->where(function($q) use ($search, $searchableFields) {
            foreach ($searchableFields as $field) {
                $q->orWhere($field, 'LIKE', "%{$search}%");
            }
        });
    }

    /**
     * Valida y sanitiza parámetros de ordenamiento
     */
    protected function applySorting($query, Request $request, array $allowedSorts = [])
    {
        $sort = $request->get('sort');
        
        if (empty($sort)) {
            return $query;
        }
        
        $sorts = explode(',', $sort);
        
        foreach ($sorts as $sortField) {
            $direction = 'asc';
            
            // Detectar orden descendente
            if (str_starts_with($sortField, '-')) {
                $direction = 'desc';
                $sortField = substr($sortField, 1);
            }
            
            // Validar que el campo está permitido
            if (in_array($sortField, $allowedSorts)) {
                $query->orderBy($sortField, $direction);
            }
        }
        
        return $query;
    }

    /**
     * Respuesta exitosa mejorada con metadata adicional
     */
    protected function successResponse($data, string $message = 'Success', int $code = 200, array $meta = [])
    {
        $defaultMeta = [
            'api_version' => '2.0',
            'timestamp' => now()->toISOString(),
        ];
        
        $response = ApiResponseService::success($data, $message, $code);
        $responseData = $response->getData(true);
        
        if (!empty($meta)) {
            $responseData['meta'] = array_merge($defaultMeta, $meta);
        } else {
            $responseData['meta'] = $defaultMeta;
        }
        
        return response()->json($responseData, $code);
    }
}