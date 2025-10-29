<?php

namespace App\Policies\V1;

use App\Models\User;

class UserPolicy
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
        // Cualquier usuario autenticado puede ver la lista de usuarios
        return true;
    }

    public function view(User $user)
    {
        // Cualquier usuario autenticado puede ver otros usuarios
        return true;
    }

    public function create(User $user)
    {
        // Solo los administradores pueden crear usuarios (esto mantiene seguridad)
        return $user->role === 'admin';
    }

    public function update(User $user, User $model)
    {
        // Un usuario puede actualizar su propio perfil o un administrador puede hacerlo
        return $user->id === $model->id || $user->role === 'admin';
    }

    public function delete(User $user, User $model)
    {
        // Solo los administradores pueden eliminar usuarios
        return $user->role === 'admin';
    }
}
