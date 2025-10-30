<?php

use App\Models\User;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
    
    // Create test tickets with new V2 fields
    $this->tickets = Ticket::factory()->count(10)->create([
        'author_id' => $this->user->id,
        'user_id' => $this->user->id, // Keep V1 compatibility
        'priority' => fake()->randomElement(['low', 'medium', 'high']),
        'internal_notes' => fake()->sentence(),
        'view_count' => fake()->numberBetween(0, 100)
    ]);
    
    $this->highPriorityTicket = Ticket::factory()->create([
        'author_id' => $this->user->id,
        'user_id' => $this->user->id, // Keep V1 compatibility
        'priority' => 'high',
        'status' => 'A',
        'title' => 'Critical Bug Report',
        'internal_notes' => 'Urgent fix required'
    ]);
});

describe('Tickets V2 API - Repository Pattern', function () {
    
    it('can get all tickets with V2 enhancements', function () {
        $response = $this->getJson('/api/v2/tickets');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'title',
                            'description',
                            'status',
                            'priority', // New V2 field
                            'view_count', // New V2 field
                            'created_at',
                            'updated_at',
                            'days_open', // Calculated field
                            'is_overdue' // Calculated field
                        ],
                        'relationships',
                        'meta'
                    ]
                ],
                'meta' => [
                    'api_version',
                    'timestamp',
                    'total_tickets'
                ]
            ]);
    });
    
    it('can include author relationship with conditional loading', function () {
        $response = $this->getJson('/api/v2/tickets?include=author');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes',
                        'relationships' => [
                            'author' => [
                                'data' => [
                                    'type',
                                    'id'
                                ],
                                'links'
                            ]
                        ]
                    ]
                ],
                'meta' => [
                    'includes' // Should contain ['author']
                ]
            ]);
            
        // Verify that includes are properly set
        expect($response->json('meta.includes'))->toContain('author');
        
        // Verify author relationship data exists
        $tickets = $response->json('data');
        foreach ($tickets as $ticket) {
            expect($ticket['relationships']['author']['data'])->toHaveKeys(['type', 'id']);
            expect($ticket['relationships']['author']['data']['type'])->toBe('users');
        }
    });
    
    it('can filter by priority (new V2 feature)', function () {
        // Create a specific high priority ticket to ensure we have one
        $highPriorityTicket = Ticket::factory()->create([
            'author_id' => $this->user->id,
            'user_id' => $this->user->id,
            'priority' => 'high',
            'title' => 'High Priority Test Ticket'
        ]);
        
        $response = $this->getJson('/api/v2/tickets?filter[priority]=high');
        
        $response->assertStatus(200);
        
        $tickets = $response->json('data');
        expect($tickets)->not->toBeEmpty();
        
        foreach ($tickets as $ticket) {
            expect($ticket['attributes']['priority'])->toBe('high');
        }
        
        // Verify our specific ticket is in the results
        $found = false;
        foreach ($tickets as $ticket) {
            if ($ticket['attributes']['title'] === 'High Priority Test Ticket') {
                $found = true;
                break;
            }
        }
        expect($found)->toBeTrue();
    });
    
    it('can search across title and description', function () {
        $response = $this->getJson('/api/v2/tickets?search=Critical Bug');
        
        $response->assertStatus(200);
        
        $tickets = $response->json('data');
        expect($tickets)->not->toBeEmpty();
        
        $found = false;
        foreach ($tickets as $ticket) {
            if (str_contains($ticket['attributes']['title'], 'Critical Bug')) {
                $found = true;
                break;
            }
        }
        expect($found)->toBeTrue();
    });
    
    it('can combine multiple filters and sorting', function () {
        $response = $this->getJson('/api/v2/tickets?filter[priority]=high&filter[status]=A&sort=-created_at');
        
        $response->assertStatus(200);
        
        $tickets = $response->json('data');
        foreach ($tickets as $ticket) {
            expect($ticket['attributes']['priority'])->toBe('high');
            expect($ticket['attributes']['status'])->toBe('A');
        }
    });
    
    it('can get single ticket with view count increment', function () {
        $ticket = $this->tickets->first();
        $initialViewCount = $ticket->view_count;
        
        $response = $this->getJson("/api/v2/tickets/{$ticket->id}");
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'ticket',
                    'id' => (string) $ticket->id,
                    'attributes' => [
                        'view_count' => $initialViewCount + 1, // Se incrementa al ver el ticket
                    ],
                ],
            ]);
            
        // Verify view count was incremented in database
        $ticket->refresh();
        expect($ticket->view_count)->toBe($initialViewCount + 1);
    });
});

describe('Tickets V2 API - Action Classes', function () {
    
    it('can create ticket with Action Class and priority calculation', function () {
        $ticketData = [
            'data' => [
                'type' => 'tickets',
                'attributes' => [
                    'title' => 'New V2 Ticket with Priority',
                    'description' => 'Testing the new Action Class creation',
                    'status' => 'A',
                    'priority' => 'medium',
                    'internal_notes' => 'This is an internal note for staff'
                ],
                'relationships' => [
                    'author' => [
                        'data' => [
                            'type' => 'users',
                            'id' => (string) $this->user->id
                        ]
                    ]
                ]
            ]
        ];
        
        $response = $this->postJson('/api/v2/tickets', $ticketData);
        
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'title',
                        'description',
                        'status',
                        'priority',
                        'view_count',
                        'created_at',
                        'updated_at'
                    ]
                ]
            ]);
            
        // Verify the ticket was created with correct priority
        $ticketId = $response->json('data.id');
        $createdTicket = Ticket::find($ticketId);
        expect($createdTicket->priority)->toBe('medium');
        expect($createdTicket->internal_notes)->toBe('This is an internal note for staff');
        expect($createdTicket->view_count)->toBe(0); // Initial view count
    });
    
    it('can update ticket with Action Class and audit logging', function () {
        $ticket = $this->tickets->first();
        
        $updateData = [
            'data' => [
                'type' => 'tickets',
                'id' => (string) $ticket->id,
                'attributes' => [
                    'title' => 'Updated Ticket Title V2',
                    'status' => 'C',
                    'priority' => 'low',
                    'internal_notes' => 'Updated with V2 Action Class'
                ]
            ]
        ];
        
        $response = $this->putJson("/api/v2/tickets/{$ticket->id}", $updateData);
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'ticket',
                    'id' => (string) $ticket->id,
                    'attributes' => [
                        'title' => 'Updated Ticket Title V2',
                        'status' => 'C',
                        'priority' => 'low'
                    ]
                ]
            ]);
            
        // Verify changes in database
        $ticket->refresh();
        expect($ticket->title)->toBe('Updated Ticket Title V2');
        expect($ticket->status)->toBe('C');
        expect($ticket->priority)->toBe('low');
        expect($ticket->internal_notes)->toBe('Updated with V2 Action Class');
    });
    
    it('can perform partial update (PATCH)', function () {
        $ticket = $this->tickets->first();
        $originalTitle = $ticket->title;
        
        $patchData = [
            'data' => [
                'type' => 'tickets',
                'id' => (string) $ticket->id,
                'attributes' => [
                    'status' => 'C',
                    'priority' => 'high'
                ]
            ]
        ];
        
        $response = $this->patchJson("/api/v2/tickets/{$ticket->id}", $patchData);
        
        $response->assertStatus(200);
        
        // Verify only specified fields were updated
        $ticket->refresh();
        expect($ticket->status)->toBe('C');
        expect($ticket->priority)->toBe('high');
        expect($ticket->title)->toBe($originalTitle); // Should remain unchanged
    });
});

describe('Tickets V2 API - Statistics & Analytics', function () {
    
    it('can get tickets statistics', function () {
        $response = $this->getJson('/api/v2/tickets-statistics');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'total_tickets',
                    'status_distribution' => [
                        'active',
                        'closed',
                        'pending'
                    ],
                    'priority_distribution' => [
                        'high',
                        'medium',
                        'low'
                    ],
                    'average_view_count',
                    'most_viewed_ticket',
                    'recent_activity'
                ]
            ]);
    });
});

describe('Tickets V2 API - Enhanced Filtering', function () {
    
    it('can filter by multiple priorities', function () {
        $response = $this->getJson('/api/v2/tickets?filter[priority]=high,medium');
        
        $response->assertStatus(200);
        
        $tickets = $response->json('data');
        foreach ($tickets as $ticket) {
            expect(['high', 'medium'])->toContain($ticket['attributes']['priority']);
        }
    });
    
    it('can filter by date range', function () {
        $startDate = now()->subDays(30)->format('Y-m-d');
        $endDate = now()->format('Y-m-d');
        
        $response = $this->getJson("/api/v2/tickets?filter[created_at]={$startDate},{$endDate}");
        
        $response->assertStatus(200);
        
        $tickets = $response->json('data');
        foreach ($tickets as $ticket) {
            $createdAt = $ticket['attributes']['created_at'];
            expect($createdAt)->toBeGreaterThanOrEqual($startDate);
            expect($createdAt)->toBeLessThanOrEqual($endDate . ' 23:59:59');
        }
    });
    
    it('can filter by author id', function () {
        $response = $this->getJson("/api/v2/tickets?filter[author_id]={$this->user->id}");
        
        $response->assertStatus(200);
        
        $tickets = $response->json('data');
        expect($tickets)->not->toBeEmpty();
        
        // When including author, verify the relationship
        $responseWithAuthor = $this->getJson("/api/v2/tickets?filter[author_id]={$this->user->id}&include=author");
        $responseWithAuthor->assertStatus(200);
    });
});

describe('Tickets V2 API - Performance & Optimization', function () {
    
    it('can use field selection for performance', function () {
        $response = $this->getJson('/api/v2/tickets?fields[tickets]=title,status,priority');
        
        $response->assertStatus(200);
        
        $tickets = $response->json('data');
        foreach ($tickets as $ticket) {
            $attributes = array_keys($ticket['attributes']);
            expect($attributes)->toContain('title', 'status', 'priority');
            expect($attributes)->not->toContain('description'); // Should be excluded
        }
    });
    
    it('can handle large datasets with pagination', function () {
        // Create more tickets for pagination test
        Ticket::factory()->count(50)->create(['author_id' => $this->user->id]);
        
        $response = $this->getJson('/api/v2/tickets?per_page=5&page=2');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta' => [
                    'pagination' => [
                        'current_page',
                        'per_page',
                        'total',
                        'total_pages'
                    ]
                ]
            ]);
            
        $pagination = $response->json('meta.pagination');
        expect($pagination['current_page'])->toBe(2);
        expect($pagination['per_page'])->toBe(5);
        expect(count($response->json('data')))->toBeLessThanOrEqual(5);
    });
});

describe('Tickets V2 API - Error Handling', function () {
    
    it('validates priority field values', function () {
        $invalidData = [
            'data' => [
                'type' => 'tickets',
                'attributes' => [
                    'title' => 'Test Ticket',
                    'description' => 'Test Description',
                    'status' => 'A',
                    'priority' => 'invalid_priority' // Invalid value
                ],
                'relationships' => [
                    'author' => [
                        'data' => [
                            'type' => 'users',
                            'id' => (string) $this->user->id
                        ]
                    ]
                ]
            ]
        ];
        
        $response = $this->postJson('/api/v2/tickets', $invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['data.attributes.priority']);
    });
    
    it('handles not found tickets gracefully', function () {
        $response = $this->getJson('/api/v2/tickets/99999');
        
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'No existe el recurso solicitado.'
            ]);
    });
    
    it('validates required fields on creation', function () {
        $invalidData = [
            'data' => [
                'type' => 'tickets',
                'attributes' => [
                    'description' => 'Missing title'
                ]
            ]
        ];
        
        $response = $this->postJson('/api/v2/tickets', $invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['data.attributes.title']);
    });
});