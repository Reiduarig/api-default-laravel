<?php

namespace App\Http\Controllers\API\V2;

use App\Actions\V2\CreateTicketAction;
use App\Actions\V2\UpdateTicketAction;
use App\Http\Requests\API\V1\StoreTicketRequest;
use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Resources\API\V2\TicketResource;
use App\Http\Filters\V1\TicketFilter;
use App\Policies\V1\TicketPolicy;
use App\Repositories\V2\TicketRepository;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @group Tickets (V2)
 * 
 * Gestión completa de tickets de soporte con funcionalidades avanzadas como filtros, búsqueda, 
 * estadísticas y gestión de relaciones. Incluye arquitectura mejorada con Actions y Repository Pattern.
 * Todos los endpoints requieren autenticación Bearer token.
 */
class TicketController extends ApiController
{
    protected $policyClass = TicketPolicy::class;

    public function __construct(
        private TicketRepository $ticketRepository,
        private CreateTicketAction $createAction,
        private UpdateTicketAction $updateAction
    ) {}

    /**
     * Listar tickets
     * 
     * Obtiene una lista paginada de tickets con filtros avanzados, búsqueda por texto y ordenamiento.
     * Soporta inclusión de relaciones como autor y comentarios.
     * 
     * @queryParam page integer Número de página para paginación. Example: 1
     * @queryParam per_page integer Elementos por página (máximo 100). Example: 15
     * @queryParam search string Búsqueda en título y descripción. Example: bug
     * @queryParam sort string Campo de ordenamiento. Valores: title, status, priority, created_at, updated_at. Example: created_at
     * @queryParam direction string Dirección del ordenamiento. Valores: asc, desc. Example: desc
     * @queryParam include string Relaciones a incluir. Valores: author, user, comments. Example: author,comments
     * @queryParam filter[status] string Filtrar por estado. Valores: A(abierto), H(en_progreso), C(cerrado), X(cancelado). Example: A
     * @queryParam filter[priority] string Filtrar por prioridad. Valores: low, medium, high, critical. Example: high
     * @queryParam filter[author_id] integer Filtrar por ID del autor. Example: 1
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Tickets obtenidos correctamente.",
     *   "data": [
     *     {
     *       "id": "1",
     *       "type": "ticket",
     *       "attributes": {
     *         "title": "Error en sistema de login",
     *         "description": "Los usuarios no pueden iniciar sesión después de la actualización",
     *         "status": "A",
     *         "priority": "high",
     *         "view_count": 15,
     *         "created_at": "2025-10-30T10:00:00.000000Z",
     *         "updated_at": "2025-10-30T10:30:00.000000Z",
     *         "days_open": 0.5,
     *         "is_overdue": false,
     *         "internal_notes": "Revisado por equipo técnico"
     *       },
     *       "relationships": {
     *         "author": {
     *           "links": {
     *             "self": "http://api-default-laravel.test/api/v2/tickets/1/relationships/author",
     *             "related": "http://api-default-laravel.test/api/v2/tickets/1/author"
     *           }
     *         }
     *       },
     *       "meta": {
     *         "version": "2.0",
     *         "cached_at": "2025-10-30T11:00:00.000000Z"
     *       }
     *     }
     *   ],
     *   "links": {
     *     "first": "http://api-default-laravel.test/api/v2/tickets?page=1",
     *     "last": "http://api-default-laravel.test/api/v2/tickets?page=10",
     *     "next": "http://api-default-laravel.test/api/v2/tickets?page=2"
     *   },
     *   "meta": {
     *     "total_tickets": 150,
     *     "filters_applied": {"status": "A", "priority": "high"},
     *     "includes": ["author"]
     *   }
     * }
     */
    public function index(Request $request, TicketFilter $filters)
    {
        $this->isAble('viewAny', Ticket::class);

        // Obtener relaciones a incluir
        $includes = $this->getIncludeRelations($request, ['author', 'user', 'comments']);
        
        // Aplicar búsqueda si se proporciona
        $query = Ticket::filter($filters);
        $query = $this->applySearch($query, $request, ['title', 'description']);
        $query = $this->applySorting($query, $request, ['title', 'status', 'priority', 'created_at', 'updated_at']);
        
        // Obtener tickets paginados con relaciones
        $perPage = $request->get('per_page', 15); // Valor por defecto de 15
        $tickets = $this->ticketRepository->getFilteredPaginated($filters, $includes, $perPage);
        
        $meta = [
            'total_tickets' => $tickets->total(),
            'filters_applied' => $request->except(['page', 'include', 'sort', 'search']),
            'includes' => $includes,
            'pagination' => [
                'current_page' => $tickets->currentPage(),
                'per_page' => $tickets->perPage(),
                'total' => $tickets->total(),
                'total_pages' => $tickets->lastPage(),
            ],
        ];

        return $this->successResponse(
            TicketResource::collection($tickets),
            'Tickets obtenidos correctamente.',
            200,
            $meta
        );
    }

    /**
     * Crear ticket
     * 
     * Crea un nuevo ticket de soporte en el sistema usando Action Pattern para lógica de negocio.
     * El ticket se asigna automáticamente al usuario autenticado como autor.
     * 
     * @bodyParam data.type string required Tipo del recurso. Debe ser "ticket". Example: ticket
     * @bodyParam data.attributes.title string required Título del ticket (máximo 255 caracteres). Example: Error en sistema de login
     * @bodyParam data.attributes.description string required Descripción detallada del problema. Example: Los usuarios no pueden iniciar sesión después de la actualización del sistema
     * @bodyParam data.attributes.priority string required Prioridad del ticket. Valores: low, medium, high, critical. Example: high
     * @bodyParam data.attributes.status string Estado inicial del ticket (opcional, por defecto 'A'). Valores: A, H, C, X. Example: A
     * @bodyParam data.attributes.internal_notes string Notas internas del ticket (opcional). Example: Revisado por equipo técnico
     * 
     * @response 201 {
     *   "status": "success",
     *   "message": "Ticket creado correctamente.",
     *   "data": {
     *     "id": "151",
     *     "type": "ticket",
     *     "attributes": {
     *       "title": "Error en sistema de login",
     *       "description": "Los usuarios no pueden iniciar sesión después de la actualización del sistema",
     *       "status": "A",
     *       "priority": "high",
     *       "view_count": 0,
     *       "created_at": "2025-10-30T11:00:00.000000Z",
     *       "updated_at": "2025-10-30T11:00:00.000000Z",
     *       "days_open": 0,
     *       "is_overdue": false,
     *       "internal_notes": "Revisado por equipo técnico"
     *     },
     *     "relationships": {
     *       "author": {
     *         "links": {
     *           "self": "http://api-default-laravel.test/api/v2/tickets/151/relationships/author",
     *           "related": "http://api-default-laravel.test/api/v2/tickets/151/author"
     *         }
     *       }
     *     },
     *     "meta": {
     *       "version": "2.0",
     *       "cached_at": "2025-10-30T11:00:00.000000Z"
     *     }
     *   },
     *   "meta": {
     *     "created_via": "api_v2"
     *   }
     * }
     * 
     * @response 422 {
     *   "status": "error",
     *   "message": "Los datos proporcionados no son válidos.",
     *   "data": {
     *     "title": ["The title field is required."],
     *     "priority": ["The selected priority is invalid."]
     *   }
     * }
     */
    public function store(StoreTicketRequest $request)
    {
        $this->isAble('create', Ticket::class);

        $ticketResource = $this->createAction->execute($request);

        return $this->successResponse(
            $ticketResource,
            'Ticket creado correctamente.',
            201,
            ['created_via' => 'api_v2']
        );
    }

    /**
     * Mostrar ticket
     * 
     * Obtiene un ticket específico con relaciones optimizadas e incremento automático de vistas.
     * 
     * @urlParam ticket integer required ID del ticket. Example: 1
     * @queryParam include string Relaciones a incluir. Valores: user, comments. Example: user,comments
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Ticket obtenido correctamente.",
     *   "data": {
     *     "id": "1",
     *     "type": "ticket",
     *     "attributes": {
     *       "title": "Error en sistema de login",
     *       "description": "Los usuarios no pueden iniciar sesión después de la actualización",
     *       "status": "A",
     *       "priority": "high",
     *       "view_count": 16,
     *       "created_at": "2025-10-30T10:00:00.000000Z",
     *       "updated_at": "2025-10-30T10:30:00.000000Z",
     *       "days_open": 0.5,
     *       "is_overdue": false,
     *       "internal_notes": "Revisado por equipo técnico"
     *     },
     *     "relationships": {
     *       "author": {
     *         "links": {
     *           "self": "http://api-default-laravel.test/api/v2/tickets/1/relationships/author",
     *           "related": "http://api-default-laravel.test/api/v2/tickets/1/author"
     *         }
     *       }
     *     },
     *     "meta": {
     *       "version": "2.0",
     *       "cached_at": "2025-10-30T11:00:00.000000Z",
     *       "view_incremented": true
     *     }
     *   },
     *   "meta": {
     *     "includes": ["user"]
     *   }
     * }
     * 
     * @response 404 {
     *   "status": "error",
     *   "message": "El recurso Ticket solicitado no fue encontrado."
     * }
     */
    public function show(Request $request, $ticket_id)
    {
        $includes = $this->getIncludeRelations($request, ['user', 'comments']);
        
        $ticket = $this->ticketRepository->findWithRelations($ticket_id, $includes);
        
        $this->isAble('view', $ticket);

        // Incrementar contador de vistas (característica V2)
        $ticket->increment('view_count');

        return $this->successResponse(
            new TicketResource($ticket),
            'Ticket obtenido correctamente.',
            200,
            [
                'view_count' => $ticket->view_count,
                'includes' => $includes
            ]
        );
    }

    /**
     * Actualizar ticket
     * 
     * Actualiza un ticket existente usando Action Pattern con validaciones y logging.
     * 
     * @urlParam ticket integer required ID del ticket. Example: 1
     * @bodyParam data.type string required Tipo del recurso. Debe ser "ticket". Example: ticket
     * @bodyParam data.attributes.title string Título del ticket. Example: Error en sistema de login (solucionado)
     * @bodyParam data.attributes.description string Descripción del problema. Example: Error solucionado mediante actualización
     * @bodyParam data.attributes.status string Estado del ticket. Valores: A, H, C, X. Example: C
     * @bodyParam data.attributes.priority string Prioridad. Valores: low, medium, high, critical. Example: medium
     * @bodyParam data.attributes.internal_notes string Notas internas del ticket. Example: Solucionado por el equipo técnico
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Ticket actualizado correctamente.",
     *   "data": {
     *     "id": "1",
     *     "type": "ticket",
     *     "attributes": {
     *       "title": "Error en sistema de login (solucionado)",
     *       "description": "Error solucionado mediante actualización",
     *       "status": "C",
     *       "priority": "medium",
     *       "view_count": 16,
     *       "created_at": "2025-10-30T10:00:00.000000Z",
     *       "updated_at": "2025-10-30T11:30:00.000000Z",
     *       "days_open": 1.5,
     *       "is_overdue": false,
     *       "internal_notes": "Solucionado por el equipo técnico"
     *     },
     *     "meta": {
     *       "version": "2.0",
     *       "cached_at": "2025-10-30T11:30:00.000000Z"
     *     }
     *   },
     *   "meta": {
     *     "updated_via": "api_v2"
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
        $ticket = $this->ticketRepository->findWithRelations($ticket_id);
        
        $this->isAble('update', $ticket);

        $ticketResource = $this->updateAction->execute($request, $ticket);

        return $this->successResponse(
            $ticketResource,
            'Ticket actualizado correctamente.',
            200,
            ['updated_via' => 'api_v2']
        );
    }

    /**
     * Eliminar ticket
     * 
     * Elimina un ticket del sistema con logging de auditoría mejorado.
     * 
     * @urlParam ticket integer required ID del ticket. Example: 1
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Ticket eliminado correctamente.",
     *   "data": null,
     *   "meta": {
     *     "deleted_via": "api_v2"
     *   }
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
        $ticket = $this->ticketRepository->findWithRelations($ticket_id);
        
        $this->isAble('delete', $ticket);

        // Log antes de eliminar
        Log::info('Ticket deleted via V2 API', [
            'ticket_id' => $ticket->id,
            'ticket_title' => $ticket->title,
            'user_id' => Auth::id(),
            'deleted_via' => 'api_v2'
        ]);

        $this->ticketRepository->delete($ticket);

        return $this->successResponse(
            null,
            'El ticket ha sido eliminado correctamente.',
            200,
            ['deleted_via' => 'api_v2']
        );
    }

    /**
     * Estadísticas de tickets
     * 
     * Obtiene estadísticas completas del sistema de tickets incluyendo distribución por estado,
     * prioridad, tendencias temporales y métricas de rendimiento.
     * 
     * @queryParam period string Período para métricas temporales. Valores: day, week, month, year. Example: month
     * @queryParam include_trends boolean Incluir datos de tendencias temporales. Example: true
     * 
     * @response 200 {
     *   "status": "success", 
     *   "message": "Estadísticas de tickets obtenidas correctamente.",
     *   "data": {
     *     "totals": {
     *       "total_tickets": 500,
     *       "open_tickets": 125,
     *       "closed_tickets": 350,
     *       "overdue_tickets": 15
     *     },
     *     "status_distribution": {
     *       "active": 125,
     *       "closed": 350,
     *       "pending": 20,
     *       "cancelled": 5
     *     },
     *     "priority_distribution": {
     *       "low": 150,
     *       "medium": 200,
     *       "high": 120,
     *       "critical": 30
     *     },
     *     "performance_metrics": {
     *       "average_resolution_time": "2.5 days",
     *       "most_active_authors": [
     *         {"id": 1, "name": "Admin User", "tickets_count": 45},
     *         {"id": 5, "name": "Support Team", "tickets_count": 32}
     *       ],
     *       "peak_hours": {
     *         "busiest_hour": 14,
     *         "tickets_created_peak": 25
     *       }
     *     },
     *     "trends": {
     *       "period": "month",
     *       "created_last_period": 80,
     *       "resolved_last_period": 75,
     *       "growth_rate": "6.7%"
     *     }
     *   },
     *   "meta": {
     *     "generated_at": "2025-10-30T11:00:00.000000Z",
     *     "cache_ttl": 300,
     *     "api_version": "2.0"
     *   }
     * }
     */
    public function statistics(Request $request)
    {
        $this->isAble('viewAny', Ticket::class);

        // Estadísticas básicas
        $totalTickets = Ticket::count();
        
        // Distribución por estado (mapear códigos a nombres legibles)
        $statusCounts = $this->ticketRepository->countByStatus();
        $statusDistribution = [
            'active' => $statusCounts['A'] ?? 0,
            'closed' => $statusCounts['C'] ?? 0,
            'pending' => $statusCounts['H'] ?? 0,
            'cancelled' => $statusCounts['X'] ?? 0,
        ];

        // Distribución por prioridad
        $priorityDistribution = Ticket::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority')
            ->toArray();
        
        // Completar prioridades faltantes
        $priorityDistribution = [
            'high' => $priorityDistribution['high'] ?? 0,
            'medium' => $priorityDistribution['medium'] ?? 0,
            'low' => $priorityDistribution['low'] ?? 0,
        ];

        // Estadísticas de vistas
        $avgViewCount = round(Ticket::avg('view_count') ?? 0, 2);
        $mostViewedTicket = Ticket::orderBy('view_count', 'desc')->first();

        // Actividad reciente
        $recentActivity = [
            'tickets_created_last_week' => Ticket::where('created_at', '>=', now()->subWeek())->count(),
            'tickets_updated_last_day' => Ticket::where('updated_at', '>=', now()->subDay())->count(),
            'most_active_author' => Ticket::selectRaw('author_id, COUNT(*) as count')
                ->whereNotNull('author_id')
                ->groupBy('author_id')
                ->orderBy('count', 'desc')
                ->with('author:id,name')
                ->first()
        ];

        $stats = [
            'total_tickets' => $totalTickets,
            'status_distribution' => $statusDistribution,
            'priority_distribution' => $priorityDistribution,
            'average_view_count' => $avgViewCount,
            'most_viewed_ticket' => $mostViewedTicket ? [
                'id' => $mostViewedTicket->id,
                'title' => $mostViewedTicket->title,
                'view_count' => $mostViewedTicket->view_count
            ] : null,
            'recent_activity' => $recentActivity
        ];

        return $this->successResponse(
            $stats,
            'Estadísticas de tickets obtenidas correctamente.',
            200,
            ['generated_at' => now()->toISOString()]
        );
    }
}