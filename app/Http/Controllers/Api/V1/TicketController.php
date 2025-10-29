<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Ticket;
use App\Http\Requests\API\V1\StoreTicketRequest;
use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Resources\API\V1\TicketResource;
use App\Http\Filters\V1\TicketFilter;
use App\Policies\V1\TicketPolicy;
use App\Services\API\V1\ApiResponseService;
use App\Services\API\V1\JsonApiMapper;


class TicketController extends ApiController
{
   
    protected $policyClass = TicketPolicy::class;

    public function index(TicketFilter $filters)
    {
        $this->isAble('viewAny', Ticket::class);

        $query = Ticket::filter($filters);
        $results = $query->paginate();
        
        return ApiResponseService::success( 
            TicketResource::collection($results),
            'Tickets obtenidos correctamente.'
        );
    }

    public function store(StoreTicketRequest $request)
    {
       
        $this->isAble('create', Ticket::class);

        $modelData = JsonApiMapper::mapTicketData($request);

        return ApiResponseService::success(
            new TicketResource(Ticket::create($modelData)),
            'Ticket creado correctamente.',
            201
        );
       
    }

    public function show($ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        
        $this->isAble('view', $ticket);

        return ApiResponseService::success(
            new TicketResource($ticket),
            'Ticket obtenido correctamente.'
        );
        
    }

    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        $ticket = Ticket::findOrFail($ticket_id);
        
        $this->isAble('update', $ticket);

        // Usar JsonApiMapper para obtener solo los campos validados y presentes
        $modelData = JsonApiMapper::mapTicketUpdateData($request->validated());

        $ticket->update($modelData);

        return ApiResponseService::success(
            new TicketResource($ticket),
            'Ticket actualizado correctamente.'
        ); 
    }

    public function destroy($ticket_id)
    {
       
        $ticket = Ticket::findOrFail($ticket_id);
        
        $this->isAble('delete', $ticket);

        $ticket->delete();

        return ApiResponseService::success(null, 'El ticket ha sido eliminado correctamente.');

    }

}
