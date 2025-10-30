<?php

namespace App\Actions\V2;

use App\Http\Requests\API\V1\StoreTicketRequest;
use App\Http\Resources\API\V2\TicketResource;
use App\Repositories\V2\TicketRepository;
use App\Services\API\V1\JsonApiMapper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Action para crear un nuevo ticket con lógica de negocio compleja
 */
class CreateTicketAction
{
    public function __construct(
        private TicketRepository $ticketRepository
    ) {}

    /**
     * Ejecuta la creación de un ticket con toda la lógica de negocio
     */
    public function execute(StoreTicketRequest $request): TicketResource
    {
        return DB::transaction(function () use ($request) {
            // 1. Mapear datos de la request
            $ticketData = JsonApiMapper::mapTicketData($request);
            
            // 2. Lógica de negocio adicional
            $ticketData = $this->enrichTicketData($ticketData);
            
            // 3. Crear el ticket
            $ticket = $this->ticketRepository->create($ticketData);
            
            // 4. Log de auditoría
            $this->logTicketCreation($ticket);
            
            // 5. Cargar relaciones para la respuesta
            $ticket = $this->ticketRepository->findWithRelations($ticket->id, ['author']);
            
            return new TicketResource($ticket);
        });
    }

    /**
     * Enriquece los datos del ticket con lógica de negocio
     */
    private function enrichTicketData(array $data): array
    {
        // Asignar al usuario autenticado si no se especificó
        if (!isset($data['user_id'])) {
            $data['user_id'] = Auth::id();
        }
        
        // V2: Establecer author_id (nuevo campo V2)
        $data['author_id'] = Auth::id();
        
        // Lógica de prioridad automática basada en título/descripción solo si no se especificó
        if (!isset($data['priority'])) {
            $data['priority'] = $this->calculatePriority($data);
        }
        
        // Timestamp de creación mejorado
        $data['created_at'] = now();
        
        return $data;
    }

    /**
     * Calcula prioridad automática (ejemplo de lógica de negocio)
     */
    private function calculatePriority(array $data): string
    {
        $urgentKeywords = ['urgente', 'crítico', 'emergencia', 'bloqueo'];
        $text = strtolower($data['title'] . ' ' . ($data['description'] ?? ''));
        
        foreach ($urgentKeywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return 'high';
            }
        }
        
        return 'normal';
    }

    /**
     * Registra la creación del ticket para auditoría
     */
    private function logTicketCreation($ticket): void
    {
        Log::info('Ticket created via V2 API', [
            'ticket_id' => $ticket->id,
            'user_id' => $ticket->user_id,
            'priority' => $ticket->priority ?? 'normal',
            'status' => $ticket->status,
            'created_via' => 'api_v2'
        ]);
    }
}