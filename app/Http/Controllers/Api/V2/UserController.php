<?php

namespace App\Http\Controllers\API\V2;

use App\Http\Filters\V1\UserFilter;
use App\Models\User;
use App\Http\Resources\API\V2\UserResource;
use App\Http\Requests\API\V1\StoreUserRequest;
use App\Http\Requests\API\V1\UpdateUserRequest;
use App\Policies\V1\UserPolicy;
use App\Repositories\V2\UserRepository;
use App\Services\API\V1\JsonApiMapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @group Usuarios (V2)
 * 
 * Gestión completa de usuarios con funcionalidades avanzadas, filtros, paginación y estadísticas.
 * Todos los endpoints requieren autenticación Bearer token excepto donde se indique lo contrario.
 */
class UserController extends ApiController
{
    protected $policyClass = UserPolicy::class;
    
    public function __construct(
        private UserRepository $userRepository
    ) {}

    /**
     * Listar usuarios
     * 
     * Obtiene una lista paginada de usuarios con filtros avanzados, búsqueda y ordenamiento.
     * 
     * @queryParam page integer Número de página para paginación. Example: 1
     * @queryParam per_page integer Elementos por página (máximo 100). Example: 15
     * @queryParam search string Búsqueda en nombre y email. Example: admin
     * @queryParam sort string Campo de ordenamiento. Valores: name, email, created_at, updated_at. Example: name
     * @queryParam direction string Dirección del ordenamiento. Valores: asc, desc. Example: asc
     * @queryParam include string Relaciones a incluir. Valores: tickets. Example: tickets
     * @queryParam filter[name] string Filtrar por nombre. Example: admin
     * @queryParam filter[email] string Filtrar por email. Example: admin@admin.com
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Usuarios obtenidos correctamente.",
     *   "data": [
     *     {
     *       "id": "1",
     *       "type": "user",
     *       "attributes": {
     *         "name": "Admin User",
     *         "email": "admin@admin.com",
     *         "created_at": "2025-10-30T10:00:00.000000Z",
     *         "updated_at": "2025-10-30T10:00:00.000000Z",
     *         "isAdmin": true
     *       },
     *       "relationships": {
     *         "tickets": {
     *           "links": {
     *             "self": "http://api-default-laravel.test/api/v2/users/1/relationships/tickets",
     *             "related": "http://api-default-laravel.test/api/v2/users/1/tickets"
     *           }
     *         }
     *       }
     *     }
     *   ],
     *   "links": {
     *     "first": "http://api-default-laravel.test/api/v2/users?page=1",
     *     "last": "http://api-default-laravel.test/api/v2/users?page=10",
     *     "prev": null,
     *     "next": "http://api-default-laravel.test/api/v2/users?page=2"
     *   },
     *   "meta": {
     *     "total_users": 150,
     *     "filters_applied": {"name": "admin"},
     *     "includes": ["tickets"]
     *   }
     * }
     */
    public function index(Request $request, UserFilter $filters)
    {
        $this->isAble('viewAny', User::class);

        // Obtener relaciones a incluir
        $includes = $this->getIncludeRelations($request, ['tickets']);
        
        // Aplicar búsqueda y ordenamiento
        $query = User::filter($filters);
        $query = $this->applySearch($query, $request, ['name', 'email']);
        $query = $this->applySorting($query, $request, ['name', 'email', 'created_at', 'updated_at']);

        // Obtener usuarios paginados
        $users = $this->userRepository->getFilteredPaginated($filters, $includes);

        $meta = [
            'total_users' => $users->total(),
            'filters_applied' => $request->except(['page', 'include', 'sort', 'search']),
            'includes' => $includes,
        ];

        return $this->successResponse(
            UserResource::collection($users),
            'Usuarios obtenidos correctamente.',
            200,
            $meta
        );
    }

    /**
     * Crear usuario
     * 
     * Crea un nuevo usuario en el sistema con validación completa y logging.
     * 
     * @bodyParam data.type string required Tipo del recurso. Debe ser "user". Example: user
     * @bodyParam data.attributes.name string required Nombre completo del usuario. Example: Juan Pérez
     * @bodyParam data.attributes.email string required Email único del usuario. Example: juan@example.com
     * @bodyParam data.attributes.password string required Contraseña (mínimo 8 caracteres). Example: password123
     * @bodyParam data.attributes.password_confirmation string required Confirmación de contraseña. Example: password123
     * 
     * @response 201 {
     *   "status": "success",
     *   "message": "Usuario creado correctamente.",
     *   "data": {
     *     "id": "151",
     *     "type": "user",
     *     "attributes": {
     *       "name": "Juan Pérez",
     *       "email": "juan@example.com",
     *       "created_at": "2025-10-30T11:00:00.000000Z",
     *       "updated_at": "2025-10-30T11:00:00.000000Z",
     *       "isAdmin": false
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
     *     "email": ["The email has already been taken."]
     *   }
     * }
     */
    public function store(StoreUserRequest $request)
    {
        $this->isAble('create', User::class);

        $userData = JsonApiMapper::mapUserData($request);
        
        $user = $this->userRepository->create($userData);

        // Log de auditoría
        Log::info('User created via V2 API', [
            'user_id' => $user->id,
            'created_by' => Auth::id(),
            'email' => $user->email,
            'created_via' => 'api_v2'
        ]);

        return $this->successResponse(
            new UserResource($user),
            'Usuario creado correctamente.',
            201,
            ['created_via' => 'api_v2']
        );
    }

    /**
     * Muestra un usuario específico con relaciones optimizadas
     */

    /**
     * Mostrar usuario
     * 
     * Obtiene un usuario específico con relaciones optimizadas y carga condicional.
     * 
     * @urlParam user integer required ID del usuario. Example: 1
     * @queryParam include string Relaciones a incluir. Valores: tickets. Example: tickets
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Usuario obtenido correctamente.",
     *   "data": {
     *     "id": "1",
     *     "type": "user", 
     *     "attributes": {
     *       "name": "Admin User",
     *       "email": "admin@admin.com",
     *       "created_at": "2025-10-30T10:00:00.000000Z",
     *       "updated_at": "2025-10-30T10:00:00.000000Z",
     *       "isAdmin": true
     *     },
     *     "relationships": {
     *       "tickets": {
     *         "links": {
     *           "self": "http://api-default-laravel.test/api/v2/users/1/relationships/tickets",
     *           "related": "http://api-default-laravel.test/api/v2/users/1/tickets"
     *         }
     *       }
     *     },
     *     "meta": {
     *       "version": "2.0",
     *       "cached_at": "2025-10-30T11:00:00.000000Z"
     *     }
     *   },
     *   "meta": {
     *     "includes": ["tickets"]
     *   }
     * }
     * 
     * @response 404 {
     *   "status": "error",
     *   "message": "El recurso User solicitado no fue encontrado."
     * }
     */
    public function show(Request $request, $user_id)
    {
        $includes = $this->getIncludeRelations($request, ['tickets']);
        
        $user = $this->userRepository->findWithRelations($user_id, $includes);
        
        $this->isAble('view', $user);

        return $this->successResponse(
            new UserResource($user),
            'Usuario obtenido correctamente.',
            200,
            ['includes' => $includes]
        );
    }

    /**
     * Actualizar usuario
     * 
     * Actualiza un usuario existente con logging de cambios y validaciones avanzadas.
     * 
     * @urlParam user integer required ID del usuario. Example: 1
     * @bodyParam data.type string required Tipo del recurso. Debe ser "user". Example: user
     * @bodyParam data.attributes.name string Nombre completo del usuario. Example: Juan Pérez Actualizado
     * @bodyParam data.attributes.email string Email del usuario. Example: juan.actualizado@example.com
     * @bodyParam data.attributes.password string Nueva contraseña (opcional). Example: newpassword123
     * @bodyParam data.attributes.password_confirmation string Confirmación de nueva contraseña. Example: newpassword123
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Usuario actualizado correctamente.",
     *   "data": {
     *     "id": "1",
     *     "type": "user",
     *     "attributes": {
     *       "name": "Juan Pérez Actualizado",
     *       "email": "juan.actualizado@example.com",
     *       "created_at": "2025-10-30T10:00:00.000000Z",
     *       "updated_at": "2025-10-30T11:30:00.000000Z",
     *       "isAdmin": false
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
     *   "message": "El recurso User solicitado no fue encontrado."
     * }
     * 
     * @response 422 {
     *   "status": "error",
     *   "message": "Los datos proporcionados no son válidos.",
     *   "data": {
     *     "email": ["The email has already been taken."]
     *   }
     * }
     */
    public function update(UpdateUserRequest $request, $user_id)
    {
        $user = $this->userRepository->findWithRelations($user_id);
        
        $this->isAble('update', $user);

        // Capturar datos antiguos para auditoría
        $oldData = $user->only(['name', 'email']);
        
        $updateData = JsonApiMapper::mapUserUpdateData($request, $user);
        
        $updatedUser = $this->userRepository->update($user, $updateData);

        // Log de cambios
        $changes = array_diff_assoc($updateData, $oldData);
        if (!empty($changes)) {
            Log::info('User updated via V2 API', [
                'user_id' => $updatedUser->id,
                'updated_by' => Auth::id(),
                'changes' => $changes,
                'updated_via' => 'api_v2'
            ]);
        }

        return $this->successResponse(
            new UserResource($updatedUser),
            'Usuario actualizado correctamente.',
            200,
            ['updated_via' => 'api_v2']
        );
    }

    /**
     * Eliminar usuario
     * 
     * Elimina un usuario del sistema con validaciones de negocio y logging de auditoría.
     * 
     * @urlParam user integer required ID del usuario. Example: 1
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Usuario eliminado correctamente.",
     *   "data": null,
     *   "meta": {
     *     "deleted_via": "api_v2"
     *   }
     * }
     * 
     * @response 404 {
     *   "status": "error",
     *   "message": "El recurso User solicitado no fue encontrado."
     * }
     * 
     * @response 422 {
     *   "status": "error",
     *   "message": "No se puede eliminar un usuario con tickets activos.",
     *   "meta": {
     *     "active_tickets_count": 5,
     *     "suggested_action": "Complete or reassign active tickets before deletion"
     *   }
     * }
     * 
     * @response 403 {
     *   "status": "error",
     *   "message": "No tienes permisos para realizar esta acción."
     * }
     */
    public function destroy($user_id)
    {
        $user = $this->userRepository->findWithRelations($user_id, ['tickets']);
        
        $this->isAble('delete', $user);

        // Validación de negocio: no eliminar usuario con tickets activos
        $activeTickets = $user->tickets->where('status', 'A')->count();
        if ($activeTickets > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se puede eliminar un usuario con tickets activos.',
                'meta' => [
                    'active_tickets_count' => $activeTickets,
                    'suggested_action' => 'Complete or reassign active tickets before deletion'
                ]
            ], 422);
        }

        // Log antes de eliminar
        Log::info('User deleted via V2 API', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'deleted_by' => Auth::id(),
            'tickets_count' => $user->tickets->count(),
            'deleted_via' => 'api_v2'
        ]);

        $this->userRepository->delete($user);

        return $this->successResponse(
            null,
            'Usuario eliminado correctamente.',
            200,
            ['deleted_via' => 'api_v2']
        );
    }

    /**
     * Tickets de usuario
     * 
     * Obtiene todos los tickets de un usuario específico con paginación.
     * 
     * @urlParam user integer required ID del usuario. Example: 1
     * @queryParam page integer Número de página para paginación. Example: 1
     * @queryParam per_page integer Elementos por página. Example: 15
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Tickets del usuario obtenidos correctamente.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Error en sistema de login",
     *       "description": "Los usuarios no pueden iniciar sesión",
     *       "status": "A",
     *       "priority": "high",
     *       "created_at": "2025-10-30T10:00:00.000000Z",
     *       "updated_at": "2025-10-30T10:30:00.000000Z"
     *     }
     *   ],
     *   "links": {
     *     "first": "http://api-default-laravel.test/api/v2/users/1/tickets?page=1",
     *     "last": "http://api-default-laravel.test/api/v2/users/1/tickets?page=3",
     *     "next": "http://api-default-laravel.test/api/v2/users/1/tickets?page=2"
     *   },
     *   "meta": {
     *     "user_id": 1,
     *     "total_tickets": 45
     *   }
     * }
     * 
     * @response 404 {
     *   "status": "error",
     *   "message": "El recurso User solicitado no fue encontrado."
     * }
     */
    public function tickets(Request $request, $user_id)
    {
        $user = $this->userRepository->findWithRelations($user_id, ['tickets']);
        
        $this->isAble('view', $user);

        $tickets = $user->tickets()->paginate();

        return $this->successResponse(
            $tickets,
            'Tickets del usuario obtenidos correctamente.',
            200,
            [
                'user_id' => $user->id,
                'total_tickets' => $tickets->total()
            ]
        );
    }

    /**
     * Estadísticas de usuarios
     * 
     * Obtiene estadísticas completas del sistema de usuarios incluyendo métricas de actividad
     * y análisis de comportamiento.
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Estadísticas de usuarios obtenidas correctamente.",
     *   "data": {
     *     "totals": {
     *       "total_users": 150,
     *       "active_users": 125,
     *       "users_with_tickets": 89,
     *       "admin_users": 5
     *     },
     *     "activity_metrics": {
     *       "users_created_this_month": 15,
     *       "most_active_users": [
     *         {"id": 1, "name": "Admin User", "tickets_count": 45},
     *         {"id": 5, "name": "Support Team", "tickets_count": 32}
     *       ],
     *       "users_with_pending_tickets": 25
     *     },
     *     "user_engagement": {
     *       "average_tickets_per_user": 3.2,
     *       "users_active_last_week": 89,
     *       "registration_trends": {
     *         "this_week": 8,
     *         "last_week": 12,
     *         "growth_rate": "-33.3%"
     *       }
     *     }
     *   },
     *   "meta": {
     *     "generated_at": "2025-10-30T11:00:00.000000Z",
     *     "api_version": "2.0"
     *   }
     * }
     */
    public function statistics(Request $request)
    {
        $this->isAble('viewAny', User::class);

        $stats = $this->userRepository->getUserStats();
        $activeUsers = $this->userRepository->getActiveUsers();
        $usersWithPending = $this->userRepository->getUsersWithPendingTickets();

        $statistics = array_merge($stats, [
            'active_users_count' => $activeUsers->count(),
            'users_with_pending_tickets' => $usersWithPending->count(),
            'user_activity' => [
                'most_active_users' => $activeUsers->take(5)->map(function($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                        'tickets_count' => $user->tickets_count ?? 0
                    ];
                })
            ]
        ]);

        return $this->successResponse(
            $statistics,
            'Estadísticas de usuarios obtenidas correctamente.',
            200,
            ['generated_at' => now()->toISOString()]
        );
    }
}