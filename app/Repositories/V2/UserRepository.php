<?php

namespace App\Repositories\V2;

use App\Models\User;
use App\Http\Filters\V1\UserFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository para manejo de datos de Users en API V2
 * Encapsula lógica de acceso a datos de usuarios
 */
class UserRepository
{
    /**
     * Obtiene usuarios filtrados y paginados con relaciones
     */
    public function getFilteredPaginated(UserFilter $filters, array $with = []): LengthAwarePaginator
    {
        $query = User::filter($filters);
        
        if (!empty($with)) {
            $query->with($with);
        }
        
        return $query->paginate();
    }

    /**
     * Busca un usuario por ID con relaciones opcionales
     */
    public function findWithRelations(int $id, array $with = []): User
    {
        $query = User::where('id', $id);
        
        if (!empty($with)) {
            $query->with($with);
        }
        
        return $query->firstOrFail();
    }

    /**
     * Busca usuario por email
     */
    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    /**
     * Crea un nuevo usuario
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Actualiza un usuario existente
     */
    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    /**
     * Elimina un usuario
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Obtiene usuarios activos (ejemplo de query de negocio)
     */
    public function getActiveUsers(): Collection
    {
        return User::whereHas('tickets', function($query) {
            $query->where('created_at', '>=', now()->subMonths(3));
        })->get();
    }

    /**
     * Busca usuarios por rol (si implementas roles)
     */
    public function getByRole(string $role): Collection
    {
        return User::where('role', $role)->get();
    }

    /**
     * Obtiene estadísticas de usuarios
     */
    public function getUserStats(): array
    {
        return [
            'total_users' => User::count(),
            'users_with_tickets' => User::has('tickets')->count(),
            'recent_users' => User::where('created_at', '>=', now()->subWeek())->count(),
        ];
    }

    /**
     * Busca usuarios con tickets pendientes
     */
    public function getUsersWithPendingTickets(): Collection
    {
        return User::whereHas('tickets', function($query) {
            $query->where('status', 'A');
        })->with(['tickets' => function($query) {
            $query->where('status', 'A');
        }])->get();
    }
}