<?php

use App\Models\User;
use App\Models\Ticket;

describe('Tickets API', function () {
    
    describe('List Tickets', function () {
        it('can list tickets when authenticated', function () {
            $user = $this->authenticateUser();
            $tickets = Ticket::factory()->count(3)->create();

            $response = $this->getJson('/api/v1/tickets');

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'type',
                            'attributes' => [
                                'title',
                                'description',
                                'status',
                                'created_at',
                                'updated_at'
                            ],
                            'relationships' => [
                                'author' => [
                                    'data' => [
                                        'id',
                                        'type'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'links',
                    'meta'
                ]);
        });

        it('cannot list tickets without authentication', function () {
            $response = $this->getJson('/api/v1/tickets');

            $response->assertStatus(401);
        });

        it('returns paginated results', function () {
            $user = $this->authenticateUser();
            Ticket::factory()->count(20)->create();

            $response = $this->getJson('/api/v1/tickets');

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

    describe('Show Ticket', function () {
        it('can show a specific ticket', function () {
            $user = $this->authenticateUser();
            $ticket = Ticket::factory()->create([
                'title' => 'Test Ticket',
                'user_id' => $user->id
            ]);

            $response = $this->getJson("/api/v1/tickets/{$ticket->id}");

            $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'data' => [
                        'id' => (string) $ticket->id,
                        'type' => 'tickets',
                        'attributes' => [
                            'title' => 'Test Ticket'
                        ]
                    ]
                ]);
        });

        it('returns 404 for non-existent ticket', function () {
            $user = $this->authenticateUser();

            $response = $this->getJson('/api/v1/tickets/999999');

            $response->assertStatus(404);
        });

        it('cannot show ticket without authentication', function () {
            $ticket = Ticket::factory()->create();

            $response = $this->getJson("/api/v1/tickets/{$ticket->id}");

            $response->assertStatus(401);
        });
    });

    describe('Create Ticket', function () {
        it('can create a ticket with valid data', function () {
            $user = $this->authenticateUser();

            $ticketData = [
                'data' => [
                    'attributes' => [
                        'title' => 'New Test Ticket',
                        'description' => 'Test description',
                        'status' => 'A'
                    ],
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'id' => $user->id
                            ]
                        ]
                    ]
                ]
            ];

            $response = $this->postJson('/api/v1/tickets', $ticketData);

            $response->assertStatus(201)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'Ticket creado correctamente.',
                    'data' => [
                        'id' => (string) $response->json('data.id'),
                        'type' => 'tickets',
                        'attributes' => [
                            'title' => 'New Test Ticket',
                            'description' => 'Test description',
                            'status' => 'A'
                        ]
                    ]
                ]);

            $this->assertDatabaseHas('tickets', [
                'title' => 'New Test Ticket',
                'description' => 'Test description',
                'status' => 'A',
                'user_id' => $user->id
            ]);
        });

        it('cannot create ticket without authentication', function () {
            $ticketData = [
                'data' => [
                    'attributes' => [
                        'title' => 'New Test Ticket',
                        'description' => 'Test description',
                        'status' => 'A'
                    ]
                ]
            ];

            $response = $this->postJson('/api/v1/tickets', $ticketData);

            $response->assertStatus(401);
        });

        it('validates required fields', function () {
            $user = $this->authenticateUser();

            // Test enviando campos vacíos/inválidos
            $response = $this->postJson('/api/v1/tickets', [
                'data' => [
                    'attributes' => [
                        'title' => '',      // Campo vacío
                        'status' => ''      // Campo vacío
                    ],
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'id' => ''  // Campo vacío
                            ]
                        ]
                    ]
                ]
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'data.attributes.title',
                    'data.attributes.status',
                    'data.relationships.author.data.id'
                ]);
        });

        it('validates status values', function () {
            $user = $this->authenticateUser();

            $ticketData = [
                'data' => [
                    'attributes' => [
                        'title' => 'Test Ticket',
                        'description' => 'Test description',
                        'status' => 'INVALID'
                    ],
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'id' => $user->id
                            ]
                        ]
                    ]
                ]
            ];

            $response = $this->postJson('/api/v1/tickets', $ticketData);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['data.attributes.status']);
        });
    });

    describe('Update Ticket', function () {
        it('can update a ticket with partial data', function () {
            $user = $this->authenticateUser();
            $ticket = Ticket::factory()->create([
                'title' => 'Original Title',
                'user_id' => $user->id
            ]);

            $updateData = [
                'data' => [
                    'attributes' => [
                        'title' => 'Updated Title'
                    ]
                ]
            ];

            $response = $this->putJson("/api/v1/tickets/{$ticket->id}", $updateData);

            $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'data' => [
                        'attributes' => [
                            'title' => 'Updated Title'
                        ]
                    ]
                ]);

            $this->assertDatabaseHas('tickets', [
                'id' => $ticket->id,
                'title' => 'Updated Title'
            ]);
        });

        it('can update all fields', function () {
            $user = $this->authenticateUser();
            $ticket = Ticket::factory()->create(['user_id' => $user->id]);

            $updateData = [
                'data' => [
                    'attributes' => [
                        'title' => 'Completely Updated Title',
                        'description' => 'Updated description',
                        'status' => 'C'
                    ],
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'id' => $user->id
                            ]
                        ]
                    ]
                ]
            ];

            $response = $this->putJson("/api/v1/tickets/{$ticket->id}", $updateData);

            $response->assertStatus(200);

            $this->assertDatabaseHas('tickets', [
                'id' => $ticket->id,
                'title' => 'Completely Updated Title',
                'description' => 'Updated description',
                'status' => 'C'
            ]);
        });

        it('returns 404 for non-existent ticket', function () {
            $user = $this->authenticateUser();

            $response = $this->putJson('/api/v1/tickets/999999', [
                'data' => [
                    'attributes' => [
                        'title' => 'Updated Title'
                    ]
                ]
            ]);

            $response->assertStatus(404);
        });

        it('cannot update without authentication', function () {
            $ticket = Ticket::factory()->create();

            $response = $this->putJson("/api/v1/tickets/{$ticket->id}", [
                'data' => [
                    'attributes' => [
                        'title' => 'Updated Title'
                    ]
                ]
            ]);

            $response->assertStatus(401);
        });
    });

    describe('Delete Ticket', function () {
        it('can delete a ticket', function () {
            $user = $this->authenticateUser();
            $ticket = Ticket::factory()->create(['user_id' => $user->id]);

            $response = $this->deleteJson("/api/v1/tickets/{$ticket->id}");

            $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 'El ticket ha sido eliminado correctamente.'
                ]);

            $this->assertDatabaseMissing('tickets', [
                'id' => $ticket->id
            ]);
        });

        it('returns 404 for non-existent ticket', function () {
            $user = $this->authenticateUser();

            $response = $this->deleteJson('/api/v1/tickets/999999');

            $response->assertStatus(404);
        });

        it('cannot delete without authentication', function () {
            $ticket = Ticket::factory()->create();

            $response = $this->deleteJson("/api/v1/tickets/{$ticket->id}");

            $response->assertStatus(401);
        });
    });
});