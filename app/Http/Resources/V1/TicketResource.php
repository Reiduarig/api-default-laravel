<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
                'description' => $this->description,
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
                        ['self' => 'por implementar'], // Puedes agregar enlaces relacionados si es necesario
                    ],
                ],
            ],
            'links' => [
                ['self' => route('v1.tickets.show', ['ticket' => $this->id])],
            ],
        ];
    }
}
