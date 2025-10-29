<?php

use App\Models\User;

describe('Users API', function () {
    
    describe('List Users', function () {
        it('can list users when authenticated', function () {
            $user = $this->authenticateUser();
            
            // Crear usuarios adicionales
            User::factory()->count(3)->create();

            $response = $this->getJson('/api/v1/users');

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'type',
                            'attributes' => [
                                'name',
                                'email',
                                'created_at',
                                'updated_at'
                            ],
                            'relationships' => [
                                'tickets' => [
                                    'data'
                                ]
                            ]
                        ]
                    ],
                    'links',
                    'meta'
                ]);
        });

        it('cannot list users without authentication', function () {
            $response = $this->getJson('/api/v1/users');

            $response->assertStatus(401);
        });

        it('returns paginated results', function () {
            $user = $this->authenticateUser();
            
            // Crear muchos usuarios para probar paginación
            User::factory()->count(20)->create();

            $response = $this->getJson('/api/v1/users');

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'data',
                    'links' => [
                        'first',
                        'last',
                        'prev',
                        'next'
                    ],
                    'meta' => [
                        'current_page',
                        'total',
                        'per_page'
                    ]
                ]);
        });
    });

    describe('User Filtering', function () {
        it('can filter users by id', function () {
            $user = $this->authenticateUser();
            $targetUser = User::factory()->create(['name' => 'Target User']);
            User::factory()->count(3)->create(); // Usuarios adicionales

            $response = $this->getJson("/api/v1/users?filter[id]={$targetUser->id}");

            $response->assertStatus(200);
            
            $data = $response->json('data');
            expect($data)->toHaveCount(1);
            expect($data[0]['id'])->toBe((string) $targetUser->id);
            expect($data[0]['attributes']['name'])->toBe('Target User');
        });

        it('can filter users by email substring', function () {
            $user = $this->authenticateUser();
            
            User::factory()->create(['email' => 'john@example.net']);
            User::factory()->create(['email' => 'jane@example.net']);
            User::factory()->create(['email' => 'bob@different.com']);

            $response = $this->getJson('/api/v1/users?filter[email]=example.net');

            $response->assertStatus(200);
            
            $emails = collect($response->json('data'))->pluck('attributes.email');
            
            expect($emails)->toContain('john@example.net')
                ->and($emails)->toContain('jane@example.net')
                ->and($emails)->not->toContain('bob@different.com');
        });

        it('can filter users by name substring', function () {
            $user = $this->authenticateUser();
            
            User::factory()->create(['name' => 'Dr. John Smith']);
            User::factory()->create(['name' => 'Dr. Jane Doe']);
            User::factory()->create(['name' => 'Mr. Bob Wilson']);

            $response = $this->getJson('/api/v1/users?filter[name]=Dr');

            $response->assertStatus(200);
            
            $names = collect($response->json('data'))->pluck('attributes.name');
            
            expect($names)->toContain('Dr. John Smith')
                ->and($names)->toContain('Dr. Jane Doe')
                ->and($names)->not->toContain('Mr. Bob Wilson');
        });

        it('returns empty results for non-matching filters', function () {
            $user = $this->authenticateUser();
            
            User::factory()->create(['email' => 'user@example.com']);

            $response = $this->getJson('/api/v1/users?filter[email]=nonexistent');

            $response->assertStatus(200);
            expect($response->json('data'))->toBeArray()->toBeEmpty();
        });
    });

    describe('User Sorting', function () {
        it('can sort users by name ascending', function () {
            $user = $this->authenticateUser();
            
            User::factory()->create(['name' => 'Zebra User']);
            User::factory()->create(['name' => 'Alpha User']);
            User::factory()->create(['name' => 'Beta User']);

            $response = $this->getJson('/api/v1/users?sort=name');

            $response->assertStatus(200);
            
            $names = collect($response->json('data'))->pluck('attributes.name');
            
            // Verificar que los primeros nombres están ordenados alfabéticamente
            $sortedNames = $names->filter(function($name) {
                return in_array($name, ['Alpha User', 'Beta User', 'Zebra User']);
            })->values();
            
            expect($sortedNames->toArray())->toBe(['Alpha User', 'Beta User', 'Zebra User']);
        });

        it('can sort users by name descending', function () {
            $user = $this->authenticateUser();
            
            User::factory()->create(['name' => 'Alpha User']);
            User::factory()->create(['name' => 'Zebra User']);
            User::factory()->create(['name' => 'Beta User']);

            $response = $this->getJson('/api/v1/users?sort=-name');

            $response->assertStatus(200);
            
            $names = collect($response->json('data'))->pluck('attributes.name');
            
            // Verificar que los nombres están ordenados alfabéticamente descendente
            $sortedNames = $names->filter(function($name) {
                return in_array($name, ['Alpha User', 'Beta User', 'Zebra User']);
            })->values();
            
            expect($sortedNames->toArray())->toBe(['Zebra User', 'Beta User', 'Alpha User']);
        });
    });

    describe('Combined Filtering and Sorting', function () {
        it('can filter by email and sort by name', function () {
            $user = $this->authenticateUser();
            
            User::factory()->create(['name' => 'Zebra User', 'email' => 'zebra@example.net']);
            User::factory()->create(['name' => 'Alpha User', 'email' => 'alpha@example.net']);
            User::factory()->create(['name' => 'Beta User', 'email' => 'beta@different.com']);

            $response = $this->getJson('/api/v1/users?filter[email]=example.net&sort=-name');

            $response->assertStatus(200);
            
            $data = $response->json('data');
            
            // Verificar que solo aparecen usuarios con example.net
            $emails = collect($data)->pluck('attributes.email');
            expect($emails)->each->toContain('example.net');
            
            // Verificar ordenamiento descendente por nombre
            $names = collect($data)->pluck('attributes.name');
            $filteredNames = $names->filter(function($name) {
                return in_array($name, ['Alpha User', 'Zebra User']);
            })->values();
            
            expect($filteredNames->toArray())->toBe(['Zebra User', 'Alpha User']);
        });
    });

    describe('User Relationships', function () {
        it('includes user tickets in relationships', function () {
            $user = $this->authenticateUser();
            $targetUser = User::factory()->create();
            
            // Crear tickets para el usuario
            $tickets = \App\Models\Ticket::factory()->count(2)->create([
                'user_id' => $targetUser->id
            ]);

            $response = $this->getJson("/api/v1/users?filter[id]={$targetUser->id}");

            $response->assertStatus(200);
            
            $userData = $response->json('data.0');
            $ticketRelationships = $userData['relationships']['tickets']['data'];
            
            expect($ticketRelationships)->toHaveCount(2);
            expect($ticketRelationships[0])->toHaveKey('id');
            expect($ticketRelationships[0])->toHaveKey('type');
            expect($ticketRelationships[0]['type'])->toBe('tickets');
        });

        it('shows empty tickets relationship for user without tickets', function () {
            $user = $this->authenticateUser();
            $userWithoutTickets = User::factory()->create();

            $response = $this->getJson("/api/v1/users?filter[id]={$userWithoutTickets->id}");

            $response->assertStatus(200);
            
            $userData = $response->json('data.0');
            $ticketRelationships = $userData['relationships']['tickets']['data'];
            
            expect($ticketRelationships)->toBeArray()->toBeEmpty();
        });
    });

    describe('User Authorization', function () {
        it('requires authentication for all user endpoints', function () {
            $response = $this->getJson('/api/v1/users');
            $response->assertStatus(401);

            $response = $this->getJson('/api/v1/users?filter[id]=1');
            $response->assertStatus(401);

            $response = $this->getJson('/api/v1/users?sort=name');
            $response->assertStatus(401);
        });

        it('allows authenticated users to view user list', function () {
            $user = $this->authenticateUser();

            $response = $this->getJson('/api/v1/users');

            $response->assertStatus(200);
        });
    });
});