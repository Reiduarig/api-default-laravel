<?php

use App\Models\User;
use App\Models\Ticket;
use App\Http\Resources\V2\TicketResource;
use App\Http\Resources\V2\UserResource;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com'
    ]);
    
    Sanctum::actingAs($this->user);
    
    $this->ticket = Ticket::factory()->create([
        'author_id' => $this->user->id,
        'title' => 'Test Ticket for Resources',
        'description' => 'Testing advanced resources',
        'status' => 'A',
        'priority' => 'high',
        'internal_notes' => 'Internal staff notes',
        'view_count' => 25
    ]);
});

describe('Advanced Resources V2 - JSON:API Compliance', function () {
    
    it('returns correct JSON:API structure for single ticket', function () {
        $response = $this->getJson("/api/v2/tickets/{$this->ticket->id}");
        
        $response->assertStatus(200)
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
                    ],
                    'relationships' => [
                        'author' => [
                            'links' => [
                                'self',
                                'related'
                            ]
                        ]
                    ],
                    'links' => [
                        'self'
                    ]
                ]
            ])
            ->assertJson([
                'data' => [
                    'type' => 'tickets',
                    'id' => (string) $this->ticket->id,
                    'attributes' => [
                        'title' => 'Test Ticket for Resources',
                        'priority' => 'high',
                        'view_count' => 26 // Should increment after viewing
                    ]
                ]
            ]);
    });
    
    it('returns correct JSON:API structure for ticket collection', function () {
        // Create additional tickets
        Ticket::factory()->count(3)->create(['author_id' => $this->user->id]);
        
        $response = $this->getJson('/api/v2/tickets');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes',
                        'relationships',
                        'links'
                    ]
                ],
                'meta' => [
                    'pagination' => [
                        'count',
                        'current_page',
                        'per_page',
                        'total',
                        'total_pages'
                    ]
                ],
                'links' => [
                    'first',
                    'last',
                    'self'
                ]
            ]);
            
        // Verify all items are tickets
        $tickets = $response->json('data');
        foreach ($tickets as $ticket) {
            expect($ticket['type'])->toBe('tickets');
            expect($ticket['attributes'])->toHaveKeys(['title', 'status', 'priority']);
        }
    });
    
    it('includes related author when requested', function () {
        $response = $this->getJson("/api/v2/tickets/{$this->ticket->id}?include=author");
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes',
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'type',
                                'id'
                            ]
                        ]
                    ]
                ],
                'included' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'name',
                            'email',
                            'tickets_count'
                        ],
                        'links'
                    ]
                ]
            ])
            ->assertJson([
                'data' => [
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'type' => 'users',
                                'id' => (string) $this->user->id
                            ]
                        ]
                    ]
                ],
                'included' => [
                    [
                        'type' => 'users',
                        'id' => (string) $this->user->id,
                        'attributes' => [
                            'name' => 'Test User',
                            'email' => 'test@example.com'
                        ]
                    ]
                ]
            ]);
    });
    
    it('supports field selection (sparse fieldsets)', function () {
        $response = $this->getJson('/api/v2/tickets?fields[tickets]=title,status,priority');
        
        $response->assertStatus(200);
        
        $tickets = $response->json('data');
        foreach ($tickets as $ticket) {
            $attributes = array_keys($ticket['attributes']);
            expect($attributes)->toContain('title', 'status', 'priority');
            expect($attributes)->not->toContain('description', 'view_count');
        }
    });
    
    it('supports field selection with includes', function () {
        $response = $this->getJson('/api/v2/tickets?include=author&fields[tickets]=title,status&fields[users]=name');
        
        $response->assertStatus(200);
        
        $data = $response->json();
        
        // Check ticket fields
        foreach ($data['data'] as $ticket) {
            $attributes = array_keys($ticket['attributes']);
            expect($attributes)->toContain('title', 'status');
            expect($attributes)->not->toContain('description', 'priority');
        }
        
        // Check included user fields
        if (isset($data['included'])) {
            foreach ($data['included'] as $included) {
                if ($included['type'] === 'users') {
                    $attributes = array_keys($included['attributes']);
                    expect($attributes)->toContain('name');
                    expect($attributes)->not->toContain('email', 'tickets_count');
                }
            }
        }
    });
});

describe('Advanced Resources V2 - User Resources', function () {
    
    it('returns correct JSON:API structure for single user', function () {
        $response = $this->getJson("/api/v2/users/{$this->user->id}");
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'type',
                    'id',
                    'attributes' => [
                        'name',
                        'email',
                        'tickets_count',
                        'created_at',
                        'updated_at'
                    ],
                    'relationships' => [
                        'tickets' => [
                            'links' => [
                                'self',
                                'related'
                            ]
                        ]
                    ],
                    'links' => [
                        'self'
                    ]
                ]
            ])
            ->assertJson([
                'data' => [
                    'type' => 'users',
                    'id' => (string) $this->user->id,
                    'attributes' => [
                        'name' => 'Test User',
                        'email' => 'test@example.com'
                    ]
                ]
            ]);
    });
    
    it('includes tickets when requested', function () {
        // Create additional tickets for the user
        Ticket::factory()->count(2)->create(['author_id' => $this->user->id]);
        
        $response = $this->getJson("/api/v2/users/{$this->user->id}?include=tickets");
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'relationships' => [
                        'tickets' => [
                            'data' => [
                                '*' => [
                                    'type',
                                    'id'
                                ]
                            ]
                        ]
                    ]
                ],
                'included' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'title',
                            'status',
                            'priority'
                        ]
                    ]
                ]
            ]);
            
        $included = $response->json('included');
        foreach ($included as $item) {
            if ($item['type'] === 'tickets') {
                expect($item['attributes'])->toHaveKeys(['title', 'status', 'priority']);
            }
        }
    });
    
    it('calculates tickets_count correctly', function () {
        // Create specific number of tickets
        Ticket::factory()->count(5)->create(['author_id' => $this->user->id]);
        
        $response = $this->getJson("/api/v2/users/{$this->user->id}");
        
        $response->assertStatus(200);
        
        $ticketsCount = $response->json('data.attributes.tickets_count');
        expect($ticketsCount)->toBe(6); // 1 from beforeEach + 5 from this test
    });
});

describe('Advanced Resources V2 - Conditional Loading', function () {
    
    it('does not load relationships by default', function () {
        $response = $this->getJson("/api/v2/tickets/{$this->ticket->id}");
        
        $response->assertStatus(200);
        
        // Should have relationship links but no included data
        $data = $response->json();
        expect($data['data']['relationships']['author'])->toHaveKey('links');
        expect($data['data']['relationships']['author'])->not->toHaveKey('data');
        expect($data)->not->toHaveKey('included');
    });
    
    it('loads relationships only when requested', function () {
        $response = $this->getJson("/api/v2/tickets/{$this->ticket->id}?include=author");
        
        $response->assertStatus(200);
        
        $data = $response->json();
        expect($data['data']['relationships']['author'])->toHaveKey('data');
        expect($data)->toHaveKey('included');
        expect($data['included'])->not->toBeEmpty();
    });
    
    it('handles multiple includes correctly', function () {
        // For this test, we'll focus on ticket->author relationship
        $response = $this->getJson("/api/v2/tickets?include=author&per_page=2");
        
        $response->assertStatus(200);
        
        $data = $response->json();
        expect($data)->toHaveKey('included');
        
        // Verify all tickets have author relationship data
        foreach ($data['data'] as $ticket) {
            expect($ticket['relationships']['author'])->toHaveKey('data');
        }
    });
});

describe('Advanced Resources V2 - Performance Features', function () {
    
    it('optimizes queries with conditional loading', function () {
        // Create multiple tickets and users
        $users = User::factory()->count(5)->create();
        foreach ($users as $user) {
            Ticket::factory()->count(3)->create(['author_id' => $user->id]);
        }
        
        // Test without includes (should be more efficient)
        $response1 = $this->getJson('/api/v2/tickets?per_page=10');
        $response1->assertStatus(200);
        
        // Test with includes
        $response2 = $this->getJson('/api/v2/tickets?include=author&per_page=10');
        $response2->assertStatus(200);
        
        // Both should return the same number of tickets
        expect(count($response1->json('data')))->toBe(count($response2->json('data')));
        
        // But only the second should have included data
        expect($response1->json())->not->toHaveKey('included');
        expect($response2->json())->toHaveKey('included');
    });
    
    it('handles large datasets efficiently', function () {
        // Create a larger dataset
        $users = User::factory()->count(10)->create();
        $tickets = [];
        foreach ($users as $user) {
            $userTickets = Ticket::factory()->count(5)->create(['author_id' => $user->id]);
            $tickets = array_merge($tickets, $userTickets->toArray());
        }
        
        $response = $this->getJson('/api/v2/tickets?per_page=20&include=author');
        
        $response->assertStatus(200);
        
        $data = $response->json();
        expect(count($data['data']))->toBeLessThanOrEqual(20);
        expect($data['meta']['pagination']['total'])->toBeGreaterThan(20);
    });
});

describe('Advanced Resources V2 - Links and Meta', function () {
    
    it('includes correct self links', function () {
        $response = $this->getJson("/api/v2/tickets/{$this->ticket->id}");
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'links' => [
                        'self' => url("/api/v2/tickets/{$this->ticket->id}")
                    ]
                ]
            ]);
    });
    
    it('includes correct relationship links', function () {
        $response = $this->getJson("/api/v2/tickets/{$this->ticket->id}");
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'relationships' => [
                        'author' => [
                            'links' => [
                                'self' => url("/api/v2/tickets/{$this->ticket->id}/relationships/author"),
                                'related' => url("/api/v2/tickets/{$this->ticket->id}/author")
                            ]
                        ]
                    ]
                ]
            ]);
    });
    
    it('includes pagination meta for collections', function () {
        // Create enough tickets to trigger pagination
        Ticket::factory()->count(15)->create(['author_id' => $this->user->id]);
        
        $response = $this->getJson('/api/v2/tickets?per_page=5&page=2');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta' => [
                    'pagination' => [
                        'count',
                        'current_page',
                        'per_page',
                        'total',
                        'total_pages'
                    ]
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                    'self'
                ]
            ]);
            
        $pagination = $response->json('meta.pagination');
        expect($pagination['current_page'])->toBe(2);
        expect($pagination['per_page'])->toBe(5);
        expect($pagination['total'])->toBeGreaterThan(15);
    });
});