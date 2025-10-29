<?php

namespace Tests;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Helper para autenticar un usuario con Sanctum
     */
    protected function authenticateUser(User $user = null): User
    {
        $user = $user ?? User::factory()->create();
        Sanctum::actingAs($user, ['*']);
        return $user;
    }

    /**
     * Helper para crear headers JSON API estándar
     */
    protected function jsonApiHeaders(array $additional = []): array
    {
        return array_merge([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ], $additional);
    }
}
