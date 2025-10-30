<?php

use App\Models\User;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->adminUser = User::factory()->create([
        'name' => 'Admin User',
        'email' => 'admin@test.com'
    ]);
    
    $this->regularUser = User::factory()->create([
        'name' => 'Regular User', 
        'email' => 'user@test.com'
    ]);
    
    Sanctum::actingAs($this->adminUser);
});

describe('API V2 - Complete Integration Tests', function () {
    
    it('can perform complete ticket lifecycle with V2 features', function () {
        // 1. Create a ticket with V2 features
        $createData = [
            'data' => [
                'type' => 'tickets',
                'attributes' => [
                    'title' => 'Integration Test Ticket',
                    'description' => 'Testing complete V2 workflow',
                    'status' => 'A',
                    'priority' => 'high',
                    'internal_notes' => 'Initial internal notes'
                ],
                'relationships' => [
                    'author' => [
                        'data' => [
                            'type' => 'users',
                            'id' => (string) $this->adminUser->id
                        ]
                    ]
                ]
            ]
        ];
        
        $createResponse = $this->postJson('/api/v2/tickets', $createData);
        $createResponse->assertStatus(201);
        
        $ticketId = $createResponse->json('data.id');
        expect($ticketId)->not->toBeNull();
        
        // 2. View the ticket (should increment view count)
        $viewResponse = $this->getJson("/api/v2/tickets/{$ticketId}");
        $viewResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'title' => 'Integration Test Ticket',
                        'priority' => 'high',
                        'view_count' => 1
                    ]
                ]
            ]);
        
        // 3. View again (should increment further)
        $viewResponse2 = $this->getJson("/api/v2/tickets/{$ticketId}");
        $viewResponse2->assertStatus(200)
            ->assertJsonPath('data.attributes.view_count', 2);
        
        // 4. Update the ticket with Action Class
        $updateData = [
            'data' => [
                'type' => 'tickets',
                'id' => $ticketId,
                'attributes' => [
                    'title' => 'Updated Integration Test Ticket',
                    'status' => 'H',
                    'priority' => 'medium',
                    'internal_notes' => 'Updated notes via V2 API'
                ]
            ]
        ];
        
        $updateResponse = $this->putJson("/api/v2/tickets/{$ticketId}", $updateData);
        $updateResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'title' => 'Updated Integration Test Ticket',
                        'status' => 'H',
                        'priority' => 'medium',
                        'view_count' => 2 // Should preserve view count
                    ]
                ]
            ]);
        
        // 5. Get ticket with includes
        $includeResponse = $this->getJson("/api/v2/tickets/{$ticketId}?include=author");
        $includeResponse->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'relationships' => [
                        'author' => ['data']
                    ]
                ],
                'included'
            ]);
        
        // 6. Filter tickets to find our ticket
        $filterResponse = $this->getJson('/api/v2/tickets?filter[priority]=medium&search=Integration');
        $filterResponse->assertStatus(200);
        
        $tickets = $filterResponse->json('data');
        $found = false;
        foreach ($tickets as $ticket) {
            if ($ticket['id'] === $ticketId) {
                $found = true;
                expect($ticket['attributes']['priority'])->toBe('medium');
                break;
            }
        }
        expect($found)->toBeTrue();
        
        // 7. Partial update via PATCH
        $patchData = [
            'data' => [
                'type' => 'tickets',
                'id' => $ticketId,
                'attributes' => [
                    'status' => 'C'
                ]
            ]
        ];
        
        $patchResponse = $this->patchJson("/api/v2/tickets/{$ticketId}", $patchData);
        $patchResponse->assertStatus(200)
            ->assertJsonPath('data.attributes.status', 'C')
            ->assertJsonPath('data.attributes.title', 'Updated Integration Test Ticket'); // Should preserve title
        
        // 8. Verify in statistics
        $statsResponse = $this->getJson('/api/v2/tickets/statistics');
        $statsResponse->assertStatus(200);
        
        $stats = $statsResponse->json('data');
        expect($stats['total_tickets'])->toBeGreaterThan(0);
        expect($stats['status_distribution']['closed'])->toBeGreaterThan(0);
        expect($stats['priority_distribution']['medium'])->toBeGreaterThan(0);
    });
    
    it('can perform complete user workflow with V2 features', function () {
        // 1. Get user with enhanced data
        $userResponse = $this->getJson("/api/v2/users/{$this->adminUser->id}");
        $userResponse->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'attributes' => [
                        'name',
                        'email',
                        'tickets_count'
                    ]
                ]
            ]);
        
        $initialTicketsCount = $userResponse->json('data.attributes.tickets_count');
        
        // 2. Create tickets for the user
        $ticketsToCreate = 3;
        $createdTickets = [];
        
        for ($i = 0; $i < $ticketsToCreate; $i++) {
            $ticketData = [
                'data' => [
                    'type' => 'tickets',
                    'attributes' => [
                        'title' => "User Workflow Ticket " . ($i + 1),
                        'description' => "Description for ticket " . ($i + 1),
                        'status' => 'A',
                        'priority' => ['low', 'medium', 'high'][$i % 3]
                    ],
                    'relationships' => [
                        'author' => [
                            'data' => [
                                'type' => 'users',
                                'id' => (string) $this->adminUser->id
                            ]
                        ]
                    ]
                ]
            ];
            
            $response = $this->postJson('/api/v2/tickets', $ticketData);
            $response->assertStatus(201);
            $createdTickets[] = $response->json('data.id');
        }
        
        // 3. Verify user's ticket count increased
        $userResponseAfter = $this->getJson("/api/v2/users/{$this->adminUser->id}");
        $userResponseAfter->assertStatus(200);
        
        $newTicketsCount = $userResponseAfter->json('data.attributes.tickets_count');
        expect($newTicketsCount)->toBe($initialTicketsCount + $ticketsToCreate);
        
        // 4. Get user with tickets included
        $userWithTicketsResponse = $this->getJson("/api/v2/users/{$this->adminUser->id}?include=tickets");
        $userWithTicketsResponse->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'relationships' => [
                        'tickets' => ['data']
                    ]
                ],
                'included'
            ]);
        
        $includedTickets = $userWithTicketsResponse->json('included');
        expect(count($includedTickets))->toBeGreaterThanOrEqual($ticketsToCreate);
        
        // 5. Filter tickets by this user
        $userTicketsResponse = $this->getJson("/api/v2/tickets?filter[author_id]={$this->adminUser->id}&include=author");
        $userTicketsResponse->assertStatus(200);
        
        $tickets = $userTicketsResponse->json('data');
        expect(count($tickets))->toBeGreaterThanOrEqual($ticketsToCreate);
        
        // 6. Update user information
        $updateUserData = [
            'data' => [
                'type' => 'users',
                'id' => (string) $this->adminUser->id,
                'attributes' => [
                    'name' => 'Updated Admin User Name',
                    'email' => 'updated.admin@test.com'
                ]
            ]
        ];
        
        $updateUserResponse = $this->putJson("/api/v2/users/{$this->adminUser->id}", $updateUserData);
        $updateUserResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'name' => 'Updated Admin User Name',
                        'email' => 'updated.admin@test.com'
                    ]
                ]
            ]);
        
        // 7. Verify tickets still reference updated user
        $ticketWithAuthorResponse = $this->getJson("/api/v2/tickets/{$createdTickets[0]}?include=author");
        $ticketWithAuthorResponse->assertStatus(200);
        
        $included = $ticketWithAuthorResponse->json('included');
        $authorFound = false;
        foreach ($included as $item) {
            if ($item['type'] === 'users' && $item['id'] === (string) $this->adminUser->id) {
                expect($item['attributes']['name'])->toBe('Updated Admin User Name');
                $authorFound = true;
                break;
            }
        }
        expect($authorFound)->toBeTrue();
    });
    
    it('handles complex filtering and sorting scenarios', function () {
        // Create diverse dataset
        $users = [$this->adminUser, $this->regularUser];
        $statuses = ['A', 'C', 'H'];
        $priorities = ['low', 'medium', 'high'];
        
        $createdTickets = [];
        foreach ($users as $user) {
            foreach ($statuses as $status) {
                foreach ($priorities as $priority) {
                    $ticket = Ticket::factory()->create([
                        'author_id' => $user->id,
                        'status' => $status,
                        'priority' => $priority,
                        'title' => "Test {$status} {$priority} ticket",
                        'view_count' => rand(1, 50)
                    ]);
                    $createdTickets[] = $ticket;
                }
            }
        }
        
        // Test complex filtering
        $complexFilterResponse = $this->getJson('/api/v2/tickets?filter[status]=A,C&filter[priority]=high,medium&sort=-priority,created_at&include=author&per_page=10');
        $complexFilterResponse->assertStatus(200);
        
        $tickets = $complexFilterResponse->json('data');
        expect($tickets)->not->toBeEmpty();
        
        // Verify filtering
        foreach ($tickets as $ticket) {
            expect(['A', 'C'])->toContain($ticket['attributes']['status']);
            expect(['high', 'medium'])->toContain($ticket['attributes']['priority']);
        }
        
        // Verify sorting (high priority should come first)
        $priorities = array_column(array_column($tickets, 'attributes'), 'priority');
        $highPriorityFirst = true;
        $foundMedium = false;
        foreach ($priorities as $priority) {
            if ($priority === 'medium') {
                $foundMedium = true;
            } elseif ($priority === 'high' && $foundMedium) {
                $highPriorityFirst = false;
                break;
            }
        }
        expect($highPriorityFirst)->toBeTrue();
        
        // Test search combined with filters
        $searchResponse = $this->getJson('/api/v2/tickets?search=Test&filter[status]=A&sort=-view_count');
        $searchResponse->assertStatus(200);
        
        $searchTickets = $searchResponse->json('data');
        foreach ($searchTickets as $ticket) {
            expect($ticket['attributes']['status'])->toBe('A');
            expect($ticket['attributes']['title'])->toContain('Test');
        }
    });
    
    it('validates V1 and V2 coexistence', function () {
        // Create a ticket via V2
        $v2TicketData = [
            'data' => [
                'type' => 'tickets',
                'attributes' => [
                    'title' => 'V2 Created Ticket',
                    'description' => 'Created via V2 API',
                    'status' => 'A',
                    'priority' => 'high'
                ],
                'relationships' => [
                    'author' => [
                        'data' => [
                            'type' => 'users',
                            'id' => (string) $this->adminUser->id
                        ]
                    ]
                ]
            ]
        ];
        
        $v2CreateResponse = $this->postJson('/api/v2/tickets', $v2TicketData);
        $v2CreateResponse->assertStatus(201);
        
        $ticketId = $v2CreateResponse->json('data.id');
        
        // Verify ticket can be read via V1 (backwards compatibility)
        $v1ReadResponse = $this->getJson("/api/v1/tickets/{$ticketId}");
        $v1ReadResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'tickets',
                    'id' => $ticketId,
                    'attributes' => [
                        'title' => 'V2 Created Ticket'
                    ]
                ]
            ]);
        
        // Create a ticket via V1
        $v1TicketData = [
            'data' => [
                'attributes' => [
                    'title' => 'V1 Created Ticket',
                    'description' => 'Created via V1 API',
                    'status' => 'A'
                ],
                'relationships' => [
                    'author' => [
                        'data' => [
                            'id' => $this->adminUser->id
                        ]
                    ]
                ]
            ]
        ];
        
        $v1CreateResponse = $this->postJson('/api/v1/tickets', $v1TicketData);
        $v1CreateResponse->assertStatus(201);
        
        $v1TicketId = $v1CreateResponse->json('data.id');
        
        // Verify V1-created ticket can be enhanced via V2
        $v2UpdateData = [
            'data' => [
                'type' => 'tickets',
                'id' => $v1TicketId,
                'attributes' => [
                    'priority' => 'medium', // V2 field
                    'internal_notes' => 'Added via V2' // V2 field
                ]
            ]
        ];
        
        $v2UpdateResponse = $this->putJson("/api/v2/tickets/{$v1TicketId}", $v2UpdateData);
        $v2UpdateResponse->assertStatus(200)
            ->assertJson([
                'data' => [
                    'attributes' => [
                        'title' => 'V1 Created Ticket',
                        'priority' => 'medium'
                    ]
                ]
            ]);
        
        // Verify both tickets appear in V2 statistics
        $statsResponse = $this->getJson('/api/v2/tickets/statistics');
        $statsResponse->assertStatus(200);
        
        $stats = $statsResponse->json('data');
        expect($stats['total_tickets'])->toBeGreaterThanOrEqual(2);
    });
});