<?php

namespace App\Http\Resources\API\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource avanzado para Users en API V2
 * Incluye optimizaciones y conditional loading
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (string) $this->id,
            'type' => 'user',
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => $this->created_at->toISOString(),
                'updated_at' => $this->updated_at->toISOString(),
                
                // Campos calculados
                'tickets_count' => $this->when(
                    $this->relationLoaded('tickets'), 
                    $this->tickets->count()
                ),
                'active_tickets_count' => $this->when(
                    $this->relationLoaded('tickets'),
                    $this->tickets->where('status', 'A')->count()
                ),
                
                // Campo condicional para admins
                'role' => $this->when(
                    $request->user()?->isAdmin() && isset($this->role),
                    $this->role
                ),
                'last_login' => $this->when(
                    $request->user()?->isAdmin() && isset($this->last_login_at),
                    $this->last_login_at?->toISOString()
                ),
            ],
            'relationships' => [
                'tickets' => [
                    'data' => $this->whenLoaded('tickets', function() {
                        return $this->tickets->map(function($ticket) {
                            return [
                                'id' => (string) $ticket->id,
                                'type' => 'ticket'
                            ];
                        });
                    }),
                    'meta' => $this->when($this->relationLoaded('tickets'), [
                        'count' => $this->tickets->count(),
                        'active_count' => $this->tickets->where('status', 'A')->count(),
                        'completed_count' => $this->tickets->where('status', 'C')->count(),
                    ])
                ]
            ],
            'meta' => [
                'version' => '2.0',
                'profile_completion' => $this->calculateProfileCompletion(),
                
                // Estadísticas adicionales
                'statistics' => $this->when($request->has('include_stats'), [
                    'member_since' => $this->created_at->diffForHumans(),
                    'tickets_this_month' => $this->getTicketsThisMonth(),
                    'avg_ticket_resolution_days' => $this->getAverageResolutionDays(),
                ]),
                
                // Links de navegación
                'links' => [
                    'self' => route('api.v2.users.show', $this->id),
                    'tickets' => route('api.v2.users.tickets', $this->id),
                    'edit' => $this->when(
                        $request->user()?->can('update', $this->resource),
                        route('api.v2.users.update', $this->id)
                    )
                ]
            ]
        ];
    }

    /**
     * Calcula el porcentaje de completitud del perfil
     */
    private function calculateProfileCompletion(): int
    {
        $fields = ['name', 'email'];
        $completed = 0;
        
        foreach ($fields as $field) {
            if (!empty($this->{$field})) {
                $completed++;
            }
        }
        
        return (int) (($completed / count($fields)) * 100);
    }

    /**
     * Obtiene tickets creados este mes
     */
    private function getTicketsThisMonth(): int
    {
        if (!$this->relationLoaded('tickets')) {
            return 0;
        }
        
        return $this->tickets->where('created_at', '>=', now()->startOfMonth())->count();
    }

    /**
     * Calcula días promedio de resolución de tickets
     */
    private function getAverageResolutionDays(): float
    {
        if (!$this->relationLoaded('tickets')) {
            return 0;
        }
        
        $completedTickets = $this->tickets->where('status', 'C');
        
        if ($completedTickets->isEmpty()) {
            return 0;
        }
        
        $totalDays = $completedTickets->sum(function($ticket) {
            return $ticket->created_at->diffInDays($ticket->updated_at);
        });
        
        return round($totalDays / $completedTickets->count(), 1);
    }

    /**
     * Customize the outgoing response for the resource.
     */
    public function withResponse(Request $request, $response): void
    {
        $response->header('X-API-Version', '2.0');
        $response->header('X-Resource-Type', 'user');
        
        if ($request->method() === 'GET') {
            $response->header('Cache-Control', 'private, max-age=600');
        }
    }
}