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


class UserController extends ApiController
{
    protected $policyClass = UserPolicy::class;
    
   
    public function index(UserFilter $filters)
    {
        $this->isAble('viewAny', User::class);

        return ApiResponseService::success(
            UserResource::collection(User::filter($filters)->paginate()),
            'Usuarios obtenidos correctamente.'
        );
    }

    public function store(StoreUserRequest $request)
    {
      
        $this->isAble('create', User::class);

        $modelData = JsonApiMapper::mapUserData($request);

        return ApiResponseService::success(
            new UserResource(User::create($modelData)),
            'Usuario creado correctamente.'
        );
          
    }

    public function show($user_id)
    {
       
        $user = User::findOrFail($user_id);
        
        $this->isAble('view', $user);
        
        return ApiResponseService::success(
            new UserResource($user),
            'Usuario obtenido correctamente.'
        ); 
       
    }

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
