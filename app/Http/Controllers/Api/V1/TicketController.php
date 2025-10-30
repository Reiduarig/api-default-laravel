<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Ticket;
use App\Http\Requests\API\V1\StoreTicketRequest;
use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Resources\API\V1\TicketResource;
use App\Http\Filters\V1\TicketFilter;
use App\Policies\V1\TicketPolicy;
use App\Services\API\V1\ApiResponseService;
use App\Services\API\V1\JsonApiMapper;

/**
 * @group Tickets (V1)
 * 
 * Gestión básica de tickets de soporte con funcionalidades CRUD estándar.
 * Incluye filtros básicos y paginación. Para funcionalidades avanzadas usar V2.
 * Todos los endpoints requieren autenticación Bearer token.
 */
class TicketController extends ApiController
{
   
    protected $policyClass = TicketPolicy::class;

    /**
     * Listar tickets
     * 
     * Obtiene una lista paginada de tickets con filtros básicos.
     * 
     * @queryParam page integer Número de página para paginación. Example: 1
     * @queryParam filter[status] string Filtrar por estado. Valores: A(abierto), H(en_progreso), C(cerrado), X(cancelado). Example: A
     * @queryParam filter[priority] string Filtrar por prioridad. Valores: low, medium, high, critical. Example: high
     * @queryParam filter[author_id] integer Filtrar por ID del autor. Example: 1
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Tickets obtenidos correctamente.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Error en sistema de login",
     *       "description": "Los usuarios no pueden iniciar sesión",
     *       "status": "A",
     *       "priority": "high",
     *       "author_id": 1,
     *       "created_at": "2025-10-30T10:00:00.000000Z",
     *       "updated_at": "2025-10-30T10:30:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index(TicketFilter $filters)
    {
        $this->isAble('viewAny', Ticket::class);

        $query = Ticket::filter($filters);
        $results = $query->paginate();
        
        return ApiResponseService::success( 
            TicketResource::collection($results),
            'Tickets obtenidos correctamente.'
        );
    }

    /**
     * Crear ticket
     * 
     * Crea un nuevo ticket de soporte en el sistema.
     * 
     * @bodyParam data.type string required Tipo del recurso. Debe ser "ticket". Example: ticket
     * @bodyParam data.attributes.title string required Título del ticket (máximo 255 caracteres). Example: Error en sistema de login
     * @bodyParam data.attributes.description string required Descripción detallada del problema. Example: Los usuarios no pueden iniciar sesión
     * @bodyParam data.attributes.priority string required Prioridad del ticket. Valores: low, medium, high, critical. Example: high
     * @bodyParam data.attributes.status string Estado inicial (opcional, por defecto 'A'). Valores: A, H, C, X. Example: A
     * 
     * @response 201 {
     *   "status": "success",
     *   "message": "Ticket creado correctamente.",
     *   "data": {
     *     "id": 101,
     *     "title": "Error en sistema de login",
     *     "description": "Los usuarios no pueden iniciar sesión",
     *     "status": "A",
     *     "priority": "high",
     *     "author_id": 1,
     *     "created_at": "2025-10-30T11:00:00.000000Z",
     *     "updated_at": "2025-10-30T11:00:00.000000Z"
     *   }
     * }
     * 
     * @response 422 {
     *   "status": "error",
     *   "message": "Los datos proporcionados no son válidos.",
     *   "data": {
     *     "title": ["The title field is required."]
     *   }
     * }
     */
    public function store(StoreTicketRequest $request)
    {
       
        $this->isAble('create', Ticket::class);

        $modelData = JsonApiMapper::mapTicketData($request);

        return ApiResponseService::success(
            new TicketResource(Ticket::create($modelData)),
            'Ticket creado correctamente.',
            201
        );
       
    }

    /**
     * Mostrar ticket
     * 
     * Obtiene un ticket específico por su ID.
     * 
     * @urlParam ticket integer required ID del ticket. Example: 1
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Ticket obtenido correctamente.",
     *   "data": {
     *     "id": 1,
     *     "title": "Error en sistema de login",
     *     "description": "Los usuarios no pueden iniciar sesión",
     *     "status": "A",
     *     "priority": "high",
     *     "author_id": 1,
     *     "created_at": "2025-10-30T10:00:00.000000Z",
     *     "updated_at": "2025-10-30T10:30:00.000000Z"
     *   }
     * }
     * 
     * @response 404 {
     *   "status": "error",
     *   "message": "El recurso Ticket solicitado no fue encontrado."
     * }
     */
    public function show($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        
        $this->isAble('view', $ticket);

        return ApiResponseService::success(
            new TicketResource($ticket),
            'Ticket obtenido correctamente.'
        );
        
    }

    /**
     * Actualizar ticket
     * 
     * Actualiza un ticket existente en el sistema.
     * 
     * @urlParam ticket integer required ID del ticket. Example: 1
     * @bodyParam data.type string required Tipo del recurso. Debe ser "ticket". Example: ticket
     * @bodyParam data.attributes.title string Título del ticket. Example: Error en sistema de login (solucionado)
     * @bodyParam data.attributes.description string Descripción del problema. Example: Error solucionado mediante actualización
     * @bodyParam data.attributes.status string Estado del ticket. Valores: A, H, C, X. Example: C
     * @bodyParam data.attributes.priority string Prioridad. Valores: low, medium, high, critical. Example: medium
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Ticket actualizado correctamente.",
     *   "data": {
     *     "id": 1,
     *     "title": "Error en sistema de login (solucionado)",
     *     "description": "Error solucionado mediante actualización",
     *     "status": "C",
     *     "priority": "medium",
     *     "author_id": 1,
     *     "created_at": "2025-10-30T10:00:00.000000Z",
     *     "updated_at": "2025-10-30T11:30:00.000000Z"
     *   }
     * }
     * 
     * @response 404 {
     *   "status": "error",
     *   "message": "El recurso Ticket solicitado no fue encontrado."
     * }
     * 
     * @response 422 {
     *   "status": "error",
     *   "message": "Los datos proporcionados no son válidos.",
     *   "data": {
     *     "status": ["The selected status is invalid."]
     *   }
     * }
     */
    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        
        $this->isAble('update', $ticket);

        // Usar JsonApiMapper para obtener solo los campos validados y presentes
        $modelData = JsonApiMapper::mapTicketUpdateData($request->validated());

        $ticket->update($modelData);

        return ApiResponseService::success(
            new TicketResource($ticket),
            'Ticket actualizado correctamente.'
        ); 
    }

    /**
     * Eliminar ticket
     * 
     * Elimina un ticket del sistema de forma permanente.
     * 
     * @urlParam ticket integer required ID del ticket. Example: 1
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "El ticket ha sido eliminado correctamente.",
     *   "data": null
     * }
     * 
     * @response 404 {
     *   "status": "error",
     *   "message": "El recurso Ticket solicitado no fue encontrado."
     * }
     * 
     * @response 403 {
     *   "status": "error",
     *   "message": "No tienes permisos para realizar esta acción."
     * }
     */
    public function destroy($ticket_id)
    {
       
        $ticket = Ticket::findOrFail($ticket_id);
        
        $this->isAble('delete', $ticket);

        $ticket->delete();

        return ApiResponseService::success(null, 'El ticket ha sido eliminado correctamente.');

    }

}
