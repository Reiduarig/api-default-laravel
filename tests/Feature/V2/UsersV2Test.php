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
    
    // Create tickets for users to test relationships
    $this->adminTickets = Ticket::factory()->count(5)->create([
        'author_id' => $this->adminUser->id,
        'priority' => fake()->randomElement(['low', 'medium', 'high'])
    ]);
    
    $this->userTickets = Ticket::factory()->count(3)->create([
        'author_id' => $this->regularUser->id,
        'priority' => 'high'
    ]);
});

describe('Users V2 API - Repository Pattern', function () {
    
    it('can get all users with enhanced data', function () {
        $response = $this->getJson('/api/v2/users');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'name',
                            'email',
                            'tickets_count', // Enhanced V2 field
                            'created_at',
                            'updated_at'
                        ]
                    ]
                ],
                'meta' => [
                    'pagination'
                ]
            ]);
    });
    
    it('can include tickets relationship with conditional loading', function () {
        $response = $this->getJson('/api/v2/users?include=tickets');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes',
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
                    ]
                ],
                'included' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'title',
                            'status',
                            'priority' // V2 ticket field
                        ]
                    ]
                ]
            ]);
    });
    
    it('can get single user with enhanced statistics', function () {
        $response = $this->getJson("/api/v2/users/{$this->adminUser->id}");
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'users',
                    'id' => (string) $this->adminUser->id,
                    'attributes' => [
                        'name' => $this->adminUser->name,
                        'email' => $this->adminUser->email,
                        'tickets_count' => 5 // Should match created tickets
                    ]
                ]
            ]);
    });
    
    it('can search users by name and email', function () {
        $response = $this->getJson('/api/v2/users?search=Admin');
        
        $response->assertStatus(200);
        
        $users = $response->json('data');
        $found = false;
        foreach ($users as $user) {
            if (str_contains($user['attributes']['name'], 'Admin')) {
                $found = true;
                break;
            }
        }
        expect($found)->toBeTrue();
    });
    
    it('can filter users by email domain', function () {
        $response = $this->getJson('/api/v2/users?filter[email]=test.com');
        
        $response->assertStatus(200);
        
        $users = $response->json('data');
        foreach ($users as $user) {
            expect($user['attributes']['email'])->toContain('test.com');
        }
    });
    
    it('can filter users by registration date range', function () {
        $startDate = now()->subDays(1)->format('Y-m-d');
        $endDate = now()->addDays(1)->format('Y-m-d');
        
        $response = $this->getJson("/api/v2/users?filter[created_at]={$startDate},{$endDate}");
        
        $response->assertStatus(200);
        
        $users = $response->json('data');
        expect($users)->not->toBeEmpty();
    });
    
    it('can get active users (with recent tickets)', function () {
        $response = $this->getJson('/api/v2/users?filter[active]=true');
        
        $response->assertStatus(200);
        
        $users = $response->json('data');
        foreach ($users as $user) {
            expect($user['attributes']['tickets_count'])->toBeGreaterThan(0);
        }
    });
});

describe('Users V2 API - CRUD Operations', function () {
    
    it('can update user with enhanced validation', function () {
        $updateData = [
            'data' => [
                'type' => 'users',
                'id' => (string) $this->adminUser->id,
                'attributes' => [
                    'name' => 'Updated Admin Name',
                    'email' => 'updated.admin@test.com'
                ]
            ]
        ];
        
        $response = $this->putJson("/api/v2/users/{$this->adminUser->id}", $updateData);
        
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'type' => 'users',
                    'id' => (string) $this->adminUser->id,
                    'attributes' => [
                        'name' => 'Updated Admin Name',
                        'email' => 'updated.admin@test.com'
                    ]
                ]
            ]);
            
        // Verify in database
        $this->adminUser->refresh();
        expect($this->adminUser->name)->toBe('Updated Admin Name');
        expect($this->adminUser->email)->toBe('updated.admin@test.com');
    });
    
    it('can delete user with audit logging', function () {
        $userToDelete = User::factory()->create();
        
        $response = $this->deleteJson("/api/v2/users/{$userToDelete->id}");
        
        $response->assertStatus(204);
        
        // Verify user is deleted
        $this->assertDatabaseMissing('users', [
            'id' => $userToDelete->id
        ]);
    });
});

describe('Users V2 API - Advanced Filtering', function () {
    
    it('can combine search with filters', function () {
        $response = $this->getJson('/api/v2/users?search=User&filter[email]=test.com');
        
        $response->assertStatus(200);
        
        $users = $response->json('data');
        foreach ($users as $user) {
            expect($user['attributes']['email'])->toContain('test.com');
        }
    });
    
    it('can sort users with enhanced sorting options', function () {
        $response = $this->getJson('/api/v2/users?sort=-tickets_count,name');
        
        $response->assertStatus(200);
        
        $users = $response->json('data');
        expect($users)->not->toBeEmpty();
        
        // Verify sorting by tickets_count descending
        $ticketCounts = array_column(array_column($users, 'attributes'), 'tickets_count');
        $sortedCounts = $ticketCounts;
        rsort($sortedCounts);
        expect($ticketCounts)->toBe($sortedCounts);
    });
    
    it('can paginate users with custom per_page', function () {
        // Create more users for pagination test
        User::factory()->count(15)->create();
        
        $response = $this->getJson('/api/v2/users?per_page=3&page=2');
        
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
        expect($pagination['per_page'])->toBe(3);
        expect(count($response->json('data')))->toBeLessThanOrEqual(3);
    });
});

describe('Users V2 API - Statistics', function () {
    
    it('can get users statistics', function () {
        $response = $this->getJson('/api/v2/users/statistics');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'total_users',
                    'active_users',
                    'users_with_tickets',
                    'average_tickets_per_user',
                    'top_contributors',
                    'recent_registrations'
                ]
            ]);
            
        $stats = $response->json('data');
        expect($stats['total_users'])->toBeGreaterThan(0);
        expect($stats['users_with_tickets'])->toBeGreaterThan(0);
    });
});

describe('Users V2 API - Performance Optimization', function () {
    
    it('can use field selection for users', function () {
        $response = $this->getJson('/api/v2/users?fields[users]=name,email');
        
        $response->assertStatus(200);
        
        $users = $response->json('data');
        foreach ($users as $user) {
            $attributes = array_keys($user['attributes']);
            expect($attributes)->toContain('name', 'email');
            expect($attributes)->not->toContain('created_at'); // Should be excluded
        }
    });
    
    it('can combine includes with field selection', function () {
        $response = $this->getJson('/api/v2/users?include=tickets&fields[users]=name,email&fields[tickets]=title,status');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'type',
                        'id',
                        'attributes' => [
                            'name',
                            'email'
                        ],
                        'relationships'
                    ]
                ],
                'included'
            ]);
    });
});

describe('Users V2 API - Error Handling', function () {
    
    it('validates email format on update', function () {
        $invalidData = [
            'data' => [
                'type' => 'users',
                'id' => (string) $this->adminUser->id,
                'attributes' => [
                    'name' => 'Valid Name',
                    'email' => 'invalid-email-format'
                ]
            ]
        ];
        
        $response = $this->putJson("/api/v2/users/{$this->adminUser->id}", $invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['data.attributes.email']);
    });
    
    it('validates unique email on update', function () {
        $anotherUser = User::factory()->create(['email' => 'existing@test.com']);
        
        $invalidData = [
            'data' => [
                'type' => 'users',
                'id' => (string) $this->adminUser->id,
                'attributes' => [
                    'name' => 'Valid Name',
                    'email' => 'existing@test.com' // Already exists
                ]
            ]
        ];
        
        $response = $this->putJson("/api/v2/users/{$this->adminUser->id}", $invalidData);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['data.attributes.email']);
    });
    
    it('handles not found users gracefully', function () {
        $response = $this->getJson('/api/v2/users/99999');
        
        $response->assertStatus(404)
            ->assertJson([
                'message' => 'User not found'
            ]);
    });
    
    it('validates authorization for user operations', function () {
        $unauthorizedUser = User::factory()->create();
        
        // Test without authentication
        $response = $this->withHeaders([])
            ->getJson('/api/v2/users');
            
        $response->assertStatus(401);
    });
});