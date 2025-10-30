<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Filters\V1\UserFilter;
use App\Models\User;
use App\Http\Resources\API\V1\UserResource;
use App\Http\Requests\API\V1\StoreUserRequest;
use App\Http\Requests\API\V1\UpdateUserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Auth\Access\AuthorizationException;
use App\Policies\V1\UserPolicy;
use App\Services\API\V1\ApiResponseService;
use App\Services\API\V1\JsonApiMapper;
use Illuminate\Support\Facades\Log;

/**
 * @group Usuarios (V1)
 * 
 * Gestión básica de usuarios con funcionalidades CRUD estándar.
 * Para funcionalidades avanzadas como estadísticas usar V2.
 * Todos los endpoints requieren autenticación Bearer token.
 */
class UserController extends ApiController
{
    protected $policyClass = UserPolicy::class;
    
    /**
     * Listar usuarios
     * 
     * Obtiene una lista paginada de usuarios con filtros básicos.
     * 
     * @queryParam page integer Número de página para paginación. Example: 1
     * @queryParam filter[name] string Filtrar por nombre. Example: admin
     * @queryParam filter[email] string Filtrar por email. Example: admin@admin.com
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Usuarios obtenidos correctamente.",
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Admin User",
     *       "email": "admin@admin.com",
     *       "created_at": "2025-10-30T10:00:00.000000Z",
     *       "updated_at": "2025-10-30T10:00:00.000000Z"
     *     }
     *   ]
     * }
     */
    public function index(UserFilter $filters)
    {
        $this->isAble('viewAny', User::class);

        return ApiResponseService::success(
            UserResource::collection(User::filter($filters)->paginate()),
            'Usuarios obtenidos correctamente.'
        );
    }

    /**
     * Crear usuario
     * 
     * Crea un nuevo usuario en el sistema.
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
     *     "id": 51,
     *     "name": "Juan Pérez",
     *     "email": "juan@example.com",
     *     "created_at": "2025-10-30T11:00:00.000000Z",
     *     "updated_at": "2025-10-30T11:00:00.000000Z"
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

        $modelData = JsonApiMapper::mapUserData($request);

        return ApiResponseService::success(
            new UserResource(User::create($modelData)),
            'Usuario creado correctamente.'
        );
          
    }

    /**
     * Mostrar usuario
     * 
     * Obtiene un usuario específico por su ID.
     * 
     * @urlParam user integer required ID del usuario. Example: 1
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Usuario obtenido correctamente.",
     *   "data": {
     *     "id": 1,
     *     "name": "Admin User",
     *     "email": "admin@admin.com",
     *     "created_at": "2025-10-30T10:00:00.000000Z",
     *     "updated_at": "2025-10-30T10:00:00.000000Z"
     *   }
     * }
     * 
     * @response 404 {
     *   "status": "error",
     *   "message": "El recurso User solicitado no fue encontrado."
     * }
     */
    public function show($user_id)
    {
       
        $user = User::findOrFail($user_id);
        
        $this->isAble('view', $user);
        
        return ApiResponseService::success(
            new UserResource($user),
            'Usuario obtenido correctamente.'
        ); 
       
    }

    /**
     * Actualizar usuario
     * 
     * Actualiza un usuario existente en el sistema.
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
     *     "id": 1,
     *     "name": "Juan Pérez Actualizado",
     *     "email": "juan.actualizado@example.com",
     *     "created_at": "2025-10-30T10:00:00.000000Z",
     *     "updated_at": "2025-10-30T11:30:00.000000Z"
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
        
        $user = User::findOrFail($user_id);
        
        $this->isAble('update', $user);
        
        $modelData = JsonApiMapper::mapUserUpdateData($request, $user);

        $user->update($modelData);

        return ApiResponseService::success(
            new UserResource($user),
            'Usuario actualizado correctamente.'
        );

    }

    /**
     * Eliminar usuario
     * 
     * Elimina un usuario del sistema de forma permanente.
     * 
     * @urlParam user integer required ID del usuario. Example: 1
     * 
     * @response 200 {
     *   "status": "success",
     *   "message": "Usuario eliminado correctamente.",
     *   "data": null
     * }
     * 
     * @response 404 {
     *   "status": "error",
     *   "message": "El recurso User solicitado no fue encontrado."
     * }
     * 
     * @response 403 {
     *   "status": "error",
     *   "message": "No tienes permisos para realizar esta acción."
     * }
     */
    public function destroy($user_id)
    {
        
        $user = User::findOrFail($user_id);
        
        $this->isAble('delete', $user);
        
        $user->delete();
        
        return ApiResponseService::success(
            null,
            'Usuario eliminado correctamente.'
        );

    }
}
