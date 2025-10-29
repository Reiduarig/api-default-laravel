<?php

namespace App\Policies\V1;

use App\Models\User;
use App\Models\Ticket;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user)
    {
        // Los usuarios pueden ver la lista de tickets
        return true;
    }

    public function view(User $user, Ticket $ticket)
    {
        // Los usuarios pueden ver cualquier ticket
        return true;
    }

    public function create(User $user)
    {
        // Los usuarios pueden crear tickets
        return true;
    }

    public function update(User $user, Ticket $ticket)
    {
        // Solo el autor del ticket puede actualizarlo
        return $user->id === $ticket->user_id;
    }

    public function delete(User $user, Ticket $ticket)
    {
        // Solo el autor del ticket puede eliminarlo
        return $user->id === $ticket->user_id;
    }
}
