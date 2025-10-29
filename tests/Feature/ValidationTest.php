<?php

use App\Models\User;

describe('API Validation Tests', function () {
    
    describe('Ticket Validation', function () {
        it('validates required fields when creating ticket', function () {
            $user = $this->authenticateUser();

            $response = $this->postJson('/api/v1/tickets', []);

            $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'data.attributes.title',
                    'data.attributes.status',
                    'data.relationships.author.data.id'
                ]);
        });

        it('validates title field constraints', function () {
            $user = $this->authenticateUser();

            // Título muy largo (más de 255 caracteres)
            $longTitle = str_repeat('a', 256);

            $response = $this->postJson('/api/v1/tickets', [
                'data' => [
                    'attributes' => [
                        'title' => $longTitle,
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
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['data.attributes.title']);
        });

        it('validates status field values', function () {
            $user = $this->authenticateUser();

            $response = $this->postJson('/api/v1/tickets', [
                'data' => [
                    'attributes' => [
                        'title' => 'Valid title',
                        'status' => 'INVALID_STATUS'
                    ],
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'id' => $user->id
                            ]
                        ]
                    ]
                ]
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['data.attributes.status']);
        });

        it('accepts valid status values', function () {
            $user = $this->authenticateUser();

            $validStatuses = ['A', 'C', 'H', 'X'];

            foreach ($validStatuses as $status) {
                $response = $this->postJson('/api/v1/tickets', [
                    'data' => [
                        'attributes' => [
                            'title' => "Test ticket with status {$status}",
                            'description' => "Test description for ticket with status {$status}",
                            'status' => $status
                        ],
                        'relationships' => [
                            'author' => [
                                'data' => [
                                    'id' => $user->id
                                ]
                            ]
                        ]
                    ]
                ]);

                $response->assertStatus(201);
            }
        });

        it('validates author exists', function () {
            $user = $this->authenticateUser();

            $response = $this->postJson('/api/v1/tickets', [
                'data' => [
                    'attributes' => [
                        'title' => 'Test ticket',
                        'status' => 'A'
                    ],
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'id' => 999999 // ID no existente
                            ]
                        ]
                    ]
                ]
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['data.relationships.author.data.id']);
        });

        it('validates author is integer', function () {
            $user = $this->authenticateUser();

            $response = $this->postJson('/api/v1/tickets', [
                'data' => [
                    'attributes' => [
                        'title' => 'Test ticket',
                        'status' => 'A'
                    ],
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'id' => 'not-an-integer'
                            ]
                        ]
                    ]
                ]
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['data.relationships.author.data.id']);
        });
    });

    describe('Ticket Update Validation', function () {
        it('allows partial updates with sometimes validation', function () {
            $user = $this->authenticateUser();
            $ticket = \App\Models\Ticket::factory()->create(['user_id' => $user->id]);

            // Solo actualizar título
            $response = $this->putJson("/api/v1/tickets/{$ticket->id}", [
                'data' => [
                    'attributes' => [
                        'title' => 'Updated title only'
                    ]
                ]
            ]);

            $response->assertStatus(200);
            
            $this->assertDatabaseHas('tickets', [
                'id' => $ticket->id,
                'title' => 'Updated title only'
            ]);
        });

        it('validates fields when they are provided in update', function () {
            $user = $this->authenticateUser();
            $ticket = \App\Models\Ticket::factory()->create(['user_id' => $user->id]);

            // Título muy largo en actualización
            $response = $this->putJson("/api/v1/tickets/{$ticket->id}", [
                'data' => [
                    'attributes' => [
                        'title' => str_repeat('a', 256)
                    ]
                ]
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['data.attributes.title']);
        });

        it('validates status when provided in update', function () {
            $user = $this->authenticateUser();
            $ticket = \App\Models\Ticket::factory()->create(['user_id' => $user->id]);

            $response = $this->putJson("/api/v1/tickets/{$ticket->id}", [
                'data' => [
                    'attributes' => [
                        'status' => 'INVALID'
                    ]
                ]
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['data.attributes.status']);
        });

        it('requires description in updates when provided', function () {
            $user = $this->authenticateUser();
            $ticket = \App\Models\Ticket::factory()->create([
                'user_id' => $user->id,
                'description' => 'Original description'
            ]);

            $response = $this->putJson("/api/v1/tickets/{$ticket->id}", [
                'data' => [
                    'attributes' => [
                        'description' => 'Updated description'
                    ]
                ]
            ]);

            $response->assertStatus(200);
            
            $this->assertDatabaseHas('tickets', [
                'id' => $ticket->id,
                'description' => 'Updated description'
            ]);
        });
    });

    describe('Authentication Validation', function () {
        it('validates login email format', function () {
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => 'not-an-email',
                'password' => 'password'
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });

        it('validates login required fields', function () {
            $response = $this->postJson('/api/v1/auth/login', []);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email', 'password']);
        });

        it('validates email is required for login', function () {
            $response = $this->postJson('/api/v1/auth/login', [
                'password' => 'password123'
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });

        it('validates password is required for login', function () {
            $response = $this->postJson('/api/v1/auth/login', [
                'email' => 'test@example.com'
            ]);

            $response->assertStatus(422)
                ->assertJsonValidationErrors(['password']);
        });
    });

    describe('JSON API Structure Validation', function () {
        it('validates proper JSON API structure for ticket creation', function () {
            $user = $this->authenticateUser();

            // Estructura incorrecta (sin 'data' wrapper)
            $response = $this->postJson('/api/v1/tickets', [
                'attributes' => [
                    'title' => 'Test ticket',
                    'status' => 'A'
                ]
            ]);

            $response->assertStatus(422);
        });

        it('validates nested JSON API attributes structure', function () {
            $user = $this->authenticateUser();

            // Estructura incorrecta (atributos en nivel incorrecto)
            $response = $this->postJson('/api/v1/tickets', [
                'data' => [
                    'title' => 'Test ticket', // Debería estar en 'attributes'
                    'status' => 'A'
                ]
            ]);

            $response->assertStatus(422);
        });

        it('validates JSON API relationships structure', function () {
            $user = $this->authenticateUser();

            // Estructura incorrecta de relaciones
            $response = $this->postJson('/api/v1/tickets', [
                'data' => [
                    'attributes' => [
                        'title' => 'Test ticket',
                        'status' => 'A'
                    ],
                    'relationships' => [
                        'author' => [
                            'id' => $user->id // Debería estar en 'data.id'
                        ]
                    ]
                ]
            ]);

            $response->assertStatus(422);
        });
    });

    describe('Error Message Localization', function () {
        it('returns localized error messages in Spanish', function () {
            $user = $this->authenticateUser();

            $response = $this->postJson('/api/v1/tickets', [
                'data' => [
                    'attributes' => [
                        'status' => 'INVALID'
                    ]
                ]
            ]);

            $response->assertStatus(422);
            
            $errors = $response->json('errors');
            
            // Verificar que hay mensajes de error en español
            $hasSpanishMessage = collect($errors)->contains(function ($error) {
                return str_contains($error['detail'], 'obligatorio') || 
                       str_contains($error['detail'], 'debe ser') ||
                       str_contains($error['detail'], 'campo');
            });
            
            expect($hasSpanishMessage)->toBeTrue();
        });

        it('includes field names in validation errors', function () {
            $user = $this->authenticateUser();

            $response = $this->postJson('/api/v1/tickets', [
                'data' => [
                    'attributes' => [
                        'title' => str_repeat('a', 256) // Muy largo
                    ]
                ]
            ]);

            $response->assertStatus(422);
            
            $errors = $response->json('errors');
            
            // Verificar que el campo está identificado en el error
            $titleError = collect($errors)->first(function ($error) {
                return $error['source']['pointer'] === '/data/attributes/title';
            });
            
            expect($titleError)->not->toBeNull();
            expect($titleError['detail'])->toContain('título');
        });
    });
});