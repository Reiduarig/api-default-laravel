<?php

namespace App\Repositories\V2;

use App\Models\Ticket;
use App\Models\User;
use App\Http\Filters\V1\TicketFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository para manejo de datos de Tickets en API V2
 * Implementa Repository Pattern para separar lógica de acceso a datos
 */
class TicketRepository
{
    /**
     * Obtiene tickets filtrados y paginados con relaciones optimizadas
     */
    public function getFilteredPaginated(TicketFilter $filters, array $with = [], ?int $perPage = null): LengthAwarePaginator
    {
        $query = Ticket::filter($filters);
        
        // Optimización: Eager loading de relaciones si se especifican
        if (!empty($with)) {
            $query->with($with);
        }
        
        return $query->paginate($perPage);
    }

    /**
     * Busca un ticket por ID con eager loading opcional
     */
    public function findWithRelations(int $id, array $with = []): Ticket
    {
        $query = Ticket::where('id', $id);
        
        if (!empty($with)) {
            $query->with($with);
        }
        
        return $query->firstOrFail();
    }

    /**
     * Busca un ticket asegurando que pertenezca al usuario
     */
    public function findOwnedByUser(int $ticketId, int $userId): Ticket
    {
        return Ticket::where('id', $ticketId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    /**
     * Crea un nuevo ticket con los datos validados
     */
    public function create(array $data): Ticket
    {
        return Ticket::create($data);
    }

    /**
     * Actualiza un ticket existente
     */
    public function update(Ticket $ticket, array $data): Ticket
    {
        $ticket->update($data);
        return $ticket->fresh();
    }

    /**
     * Elimina un ticket
     */
    public function delete(Ticket $ticket): bool
    {
        return $ticket->delete();
    }

    /**
     * Obtiene tickets por estado específico
     */
    public function getByStatus(string $status, array $with = []): Collection
    {
        $query = Ticket::where('status', $status);
        
        if (!empty($with)) {
            $query->with($with);
        }
        
        return $query->get();
    }

    /**
     * Obtiene tickets de un usuario específico
     */
    public function getByUser(User $user, array $with = []): Collection
    {
        $query = $user->tickets();
        
        if (!empty($with)) {
            $query->with($with);
        }
        
        return $query->get();
    }

    /**
     * Cuenta tickets por estado
     */
    public function countByStatus(): array
    {
        return Ticket::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    /**
     * Busca tickets que requieren atención (ejemplo de query de negocio)
     */
    public function getRequiringAttention(): Collection
    {
        return Ticket::where('status', 'A')
            ->where('created_at', '<', now()->subDays(7))
            ->with('user')
            ->get();
    }
}