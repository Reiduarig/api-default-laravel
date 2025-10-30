<?php

namespace App\Http\Resources\API\V2;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource avanzado para Tickets en API V2
 * Incluye optimizaciones, conditional loading y campos adicionales
 */
class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        // Obtener campos solicitados para el tipo 'tickets'
        $requestedFields = $request->get('fields')['tickets'] ?? null;
        $requestedFields = $requestedFields ? explode(',', $requestedFields) : null;

        // Definir todos los atributos disponibles
        $allAttributes = [
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->when(isset($this->priority), $this->priority, 'normal'),
            'view_count' => $this->view_count ?? 0,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            
            // Campos calculados
            'days_open' => $this->created_at->diffInDays(now()),
            'is_overdue' => $this->created_at->addDays(7)->isPast() && $this->status === 'A',
            
            // Campos condicionales - mostrar internal_notes a todos los usuarios autenticados por ahora
            'internal_notes' => $this->when(
                $request->user() !== null, 
                $this->internal_notes
            ),
        ];

        // Filtrar atributos según los campos solicitados
        $attributes = $requestedFields 
            ? array_intersect_key($allAttributes, array_flip($requestedFields))
            : $allAttributes;

        return [
            'id' => (string) $this->id,
            'type' => 'ticket',
            'attributes' => $attributes,
            'relationships' => [
                'author' => [
                    'data' => $this->whenLoaded('author', function() {
                        return [
                            'id' => (string) $this->author->id,
                            'type' => 'users'
                        ];
                    }),
                    'links' => [
                        'self' => url("/api/v2/tickets/{$this->id}/relationships/author"),
                        'related' => url("/api/v2/tickets/{$this->id}/author"),
                    ]
                ],
                'comments' => [
                    'data' => $this->whenLoaded('comments', function() {
                        return $this->comments->map(function($comment) {
                            return [
                                'id' => (string) $comment->id,
                                'type' => 'comment'
                            ];
                        });
                    })
                ]
            ],
            'meta' => [
                'version' => '2.0',
                'cached_at' => now()->toISOString(),
                
                // Metadata adicional para V2
                'statistics' => $this->when($request->has('include_stats'), [
                    'view_count' => $this->view_count ?? 0,
                    'last_activity' => $this->updated_at->toISOString(),
                ]),
                
                // Links adicionales
                'links' => [
                    'self' => route('api.v2.tickets.show', $this->id),
                    'edit' => $this->when(
                        $request->user()?->can('update', $this->resource),
                        route('api.v2.tickets.update', $this->id)
                    ),
                    'delete' => $this->when(
                        $request->user()?->can('delete', $this->resource),
                        route('api.v2.tickets.destroy', $this->id)
                    )
                ]
            ]
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     */
    public function withResponse(Request $request, $response): void
    {
        // Headers adicionales para V2
        $response->header('X-API-Version', '2.0');
        $response->header('X-Resource-Type', 'ticket');
        
        // Cache headers para optimización
        if ($request->method() === 'GET') {
            $response->header('Cache-Control', 'public, max-age=300');
        }
    }
}