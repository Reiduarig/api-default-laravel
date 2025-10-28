<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\Controller;
use App\Models\Ticket;
use App\Http\Requests\API\V1\StoreTicketRequest;
use App\Http\Requests\API\V1\UpdateTicketRequest;
use App\Http\Resources\API\V1\TicketResource;
use App\Http\Filters\V1\TicketFilter;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\ApiResponses;

class TicketController extends Controller
{
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index(TicketFilter $filters)
    {
       
        try {

            $query = Ticket::filter($filters);

            $results = $query->paginate();
            
            return TicketResource::collection($results);


        } catch (\Exception $e) {

            return $this->error('Ha ocurrido un error al obtener los tickets.', 500);
        }
    }

    public function store(StoreTicketRequest $request)
    {
        // Validar que el autor exista, esto debería poder validarse en el StoreTicketRequest pero está dando problemas TODO: revisar 
        try {
            
            $user = User::findOrFail($request->input('data.relationships.author.data.id'));
        
        } catch (ModelNotFoundException $e) {
        
            return $this->error('El autor especificado no existe.', 404);
        
        }

        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $request->input('data.relationships.author.data.id'),
        ];

        return new TicketResource(Ticket::create($model));
       
    }

    public function show($ticket_id)
    {
        try {

            $ticket = Ticket::findOrFail($ticket_id);

            return new TicketResource($ticket);
        
        } catch (ModelNotFoundException $e) {
        
            return $this->error('El ticket especificado no existe.', 404);
        
        }
    }


    public function update(UpdateTicketRequest $request, $ticket_id)
    {
        try {

            $ticket = Ticket::findOrFail($ticket_id);

            $model = [
                'title' => $request->input('data.attributes.title'),
                'description' => $request->input('data.attributes.description'),
                'status' => $request->input('data.attributes.status'),
                'user_id' => $request->input('data.relationships.author.data.id'),
            ];

            $ticket->update($model);

            return new TicketResource($ticket);
        
        } catch (ModelNotFoundException $e) {
            
            return $this->error('El ticket especificado no existe.', 404);
        
        }
    }

    public function destroy($ticket_id)
    {

        try{
            $ticket = Ticket::findOrFail($ticket_id);

            $ticket->delete();

            return $this->success('El ticket ha sido eliminado correctamente.');

        } catch (ModelNotFoundException $e) {
            
            return $this->error('El ticket especificado no existe.', 404);
        
        }
        
    }
}
