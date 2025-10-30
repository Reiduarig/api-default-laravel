<?php

namespace App\Actions\V2;

use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Resources\API\V2\TicketResource;
use App\Repositories\V2\TicketRepository;
use App\Services\API\V1\JsonApiMapper;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Action para actualizar tickets con lógica de negocio avanzada
 */
class UpdateTicketAction
{
    public function __construct(
        private TicketRepository $ticketRepository
    ) {}

    /**
     * Ejecuta la actualización de un ticket
     */
    public function execute(UpdateTicketRequest $request, Ticket $ticket): TicketResource
    {
        return DB::transaction(function () use ($request, $ticket) {
            // 1. Capturar estado anterior para auditoría
            $oldData = $ticket->toArray();
            
            // 2. Mapear nuevos datos
            $updateData = JsonApiMapper::mapTicketUpdateData($request->validated());
            
            // 3. Aplicar lógica de negocio en cambios
            $updateData = $this->processBusinessLogic($ticket, $updateData);
            
            // 4. Actualizar el ticket
            $updatedTicket = $this->ticketRepository->update($ticket, $updateData);
            
            // 5. Log de auditoría de cambios
            $this->logTicketUpdate($updatedTicket, $oldData, $updateData);
            
            // 6. Cargar relaciones para respuesta
            $updatedTicket = $this->ticketRepository->findWithRelations($updatedTicket->id, ['author']);
            
            return new TicketResource($updatedTicket);
        });
    }

    /**
     * Aplica lógica de negocio específica durante actualizaciones
     */
    private function processBusinessLogic(Ticket $ticket, array $updateData): array
    {
        // Si se cambia el status a completado, marcar fecha de completado
        if (isset($updateData['status']) && $updateData['status'] === 'C') {
            $updateData['completed_at'] = now();
        }
        
        // Si se cambia de completado a activo, limpiar fecha de completado
        if (isset($updateData['status']) && $updateData['status'] === 'A' && $ticket->status === 'C') {
            $updateData['completed_at'] = null;
        }
        
        // Recalcular prioridad si se actualiza título o descripción pero NO se especificó prioridad
        if ((isset($updateData['title']) || isset($updateData['description'])) && !isset($updateData['priority'])) {
            $updateData['priority'] = $this->calculatePriority($updateData, $ticket);
        }
        
        return $updateData;
    }

    /**
     * Calcula nueva prioridad basada en cambios
     */
    private function calculatePriority(array $updateData, Ticket $ticket): string
    {
        $title = $updateData['title'] ?? $ticket->title;
        $description = $updateData['description'] ?? $ticket->description;
        
        $urgentKeywords = ['urgente', 'crítico', 'emergencia', 'bloqueo'];
        $text = strtolower($title . ' ' . $description);
        
        foreach ($urgentKeywords as $keyword) {
            if (str_contains($text, $keyword)) {
                return 'high';
            }
        }
        
        return 'normal';
    }

    /**
     * Registra cambios para auditoría
     */
    private function logTicketUpdate(Ticket $ticket, array $oldData, array $changes): void
    {
        $changedFields = [];
        
        foreach ($changes as $field => $newValue) {
            if (isset($oldData[$field]) && $oldData[$field] !== $newValue) {
                $changedFields[$field] = [
                    'old' => $oldData[$field],
                    'new' => $newValue
                ];
            }
        }
        
        if (!empty($changedFields)) {
            Log::info('Ticket updated via V2 API', [
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'changes' => $changedFields,
                'updated_via' => 'api_v2'
            ]);
        }
    }
}