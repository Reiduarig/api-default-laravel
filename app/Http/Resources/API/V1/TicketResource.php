<?php

namespace App\Http\Resources\API\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\V1\UserResource;

class TicketResource extends JsonResource
{

    //public static $wrap = 'ticket'; // Opcional: personaliza el nombre del envoltorio de la respuesta

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return 
        [
            'type' => 'tickets',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'description' => $this->when(
                    !request()->routeIs(['tickets.index', 'users.tickets.index']), 
                    $this->description
                ),
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ],
                    'links' => [
                        'user' => route('v1.users.show', ['user' => $this->user_id]),
                    ],
                ],
            ],
            // 'includes' => [
            //     // (Opcional) Puedes incluir recursos relacionados aquí si es necesario
            //     new UserResource($this->whenLoaded('author')),
            // ],
            'links' => [
                ['self' => route('v1.tickets.show', ['ticket' => $this->id])],
            ],
        ];
    }
}
