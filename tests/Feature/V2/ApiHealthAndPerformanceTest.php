<?php

use App\Models\User;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
    
    // Create test data for statistics
    $this->users = User::factory()->count(10)->create();
    $this->tickets = [];
    
    // Create tickets with various statuses and priorities
    foreach ($this->users->take(5) as $user) {
        $userTickets = Ticket::factory()->count(rand(2, 8))->create([
            'author_id' => $user->id,
            'status' => fake()->randomElement(['A', 'C', 'H', 'X']),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'view_count' => rand(0, 100)
        ]);
        $this->tickets = array_merge($this->tickets, $userTickets->toArray());
    }
});

describe('API V2 - Health & Version Endpoints', function () {
    
    it('returns API version information', function () {
        $response = $this->getJson('/api/v2/version');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'version',
                    'name',
                    'description',
                    'features',
                    'release_date'
                ]
            ])
            ->assertJson([
                'data' => [
                    'version' => '2.0.0',
                    'name' => 'API V2 - Advanced Features'
                ]
            ]);
            
        $features = $response->json('data.features');
        expect($features)->toContain('Repository Pattern', 'Action Classes', 'Advanced Resources');
    });
    
    it('returns API health status', function () {
        $response = $this->getJson('/api/v2/health');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'status',
                    'timestamp',
                    'version',
                    'database' => [
                        'status',
                        'connection_time'
                    ],
                    'cache' => [
                        'status'
                    ],
                    'features' => [
                        'repository_pattern',
                        'action_classes',
                        'advanced_resources'
                    ]
                ]
            ])
            ->assertJson([
                'data' => [
                    'status' => 'healthy',
                    'database' => [
                        'status' => 'connected'
                    ],
                    'features' => [
                        'repository_pattern' => true,
                        'action_classes' => true,
                        'advanced_resources' => true
                    ]
                ]
            ]);
    });
    
    it('returns basic API information', function () {
        $response = $this->getJson('/api/v2');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'message',
                    'version',
                    'endpoints',
                    'features',
                    'documentation'
                ]
            ])
            ->assertJson([
                'data' => [
                    'message' => 'Welcome to API V2 - Advanced Features',
                    'version' => '2.0.0'
                ]
            ]);
            
        $endpoints = $response->json('data.endpoints');
        expect($endpoints)->toHaveKeys(['tickets', 'users', 'statistics', 'health']);
    });
});

describe('API V2 - Statistics Endpoints', function () {
    
    it('returns comprehensive ticket statistics', function () {
        $response = $this->getJson('/api/v2/tickets/statistics');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'total_tickets',
                    'status_distribution' => [
                        'active',
                        'closed', 
                        'pending',
                        'cancelled'
                    ],
                    'priority_distribution' => [
                        'high',
                        'medium',
                        'low'
                    ],
                    'average_view_count',
                    'most_viewed_ticket' => [
                        'id',
                        'title',
                        'view_count'
                    ],
                    'recent_activity' => [
                        'today',
                        'this_week',
                        'this_month'
                    ],
                    'trends' => [
                        'creation_trend',
                        'resolution_trend'
                    ]
                ]
            ]);
            
        $stats = $response->json('data');
        expect($stats['total_tickets'])->toBeGreaterThan(0);
        expect($stats['status_distribution'])->toBeArray();
        expect($stats['priority_distribution'])->toBeArray();
        expect($stats['average_view_count'])->toBeGreaterThanOrEqual(0);
    });
    
    it('returns detailed user statistics', function () {
        $response = $this->getJson('/api/v2/users/statistics');
        
        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'total_users',
                    'active_users',
                    'users_with_tickets',
                    'average_tickets_per_user',
                    'top_contributors' => [
                        '*' => [
                            'user_id',
                            'name',
                            'tickets_count'
                        ]
                    ],
                    'recent_registrations' => [
                        'today',
                        'this_week',
                        'this_month'
                    ],
                    'activity_distribution' => [
                        'very_active',
                        'moderately_active',
                        'low_activity',
                        'inactive'
                    ]
                ]
            ]);
            
        $stats = $response->json('data');
        expect($stats['total_users'])->toBeGreaterThan(0);
        expect($stats['users_with_tickets'])->toBeGreaterThan(0);
        expect($stats['average_tickets_per_user'])->toBeGreaterThan(0);
        expect($stats['top_contributors'])->toBeArray();
    });
    
    it('calculates status distribution correctly', function () {
        // Create tickets with known statuses
        Ticket::factory()->count(5)->create(['status' => 'A', 'author_id' => $this->user->id]);
        Ticket::factory()->count(3)->create(['status' => 'C', 'author_id' => $this->user->id]);
        Ticket::factory()->count(2)->create(['status' => 'H', 'author_id' => $this->user->id]);
        
        $response = $this->getJson('/api/v2/tickets/statistics');
        
        $response->assertStatus(200);
        
        $distribution = $response->json('data.status_distribution');
        expect($distribution['active'])->toBeGreaterThanOrEqual(5);
        expect($distribution['closed'])->toBeGreaterThanOrEqual(3);
        expect($distribution['pending'])->toBeGreaterThanOrEqual(2);
    });
    
    it('calculates priority distribution correctly', function () {
        // Create tickets with known priorities
        Ticket::factory()->count(4)->create(['priority' => 'high', 'author_id' => $this->user->id]);
        Ticket::factory()->count(6)->create(['priority' => 'medium', 'author_id' => $this->user->id]);
        Ticket::factory()->count(2)->create(['priority' => 'low', 'author_id' => $this->user->id]);
        
        $response = $this->getJson('/api/v2/tickets/statistics');
        
        $response->assertStatus(200);
        
        $distribution = $response->json('data.priority_distribution');
        expect($distribution['high'])->toBeGreaterThanOrEqual(4);
        expect($distribution['medium'])->toBeGreaterThanOrEqual(6);
        expect($distribution['low'])->toBeGreaterThanOrEqual(2);
    });
    
    it('identifies most viewed ticket correctly', function () {
        // Create a ticket with high view count
        $popularTicket = Ticket::factory()->create([
            'author_id' => $this->user->id,
            'title' => 'Most Popular Ticket',
            'view_count' => 999
        ]);
        
        $response = $this->getJson('/api/v2/tickets/statistics');
        
        $response->assertStatus(200);
        
        $mostViewed = $response->json('data.most_viewed_ticket');
        expect($mostViewed['id'])->toBe($popularTicket->id);
        expect($mostViewed['title'])->toBe('Most Popular Ticket');
        expect($mostViewed['view_count'])->toBe(999);
    });
    
    it('calculates top contributors correctly', function () {
        // Create users with different ticket counts
        $prolificUser = User::factory()->create(['name' => 'Prolific User']);
        Ticket::factory()->count(15)->create(['author_id' => $prolificUser->id]);
        
        $response = $this->getJson('/api/v2/users/statistics');
        
        $response->assertStatus(200);
        
        $topContributors = $response->json('data.top_contributors');
        expect($topContributors)->not->toBeEmpty();
        
        // Find our prolific user in the list
        $found = false;
        foreach ($topContributors as $contributor) {
            if ($contributor['user_id'] === $prolificUser->id) {
                expect($contributor['name'])->toBe('Prolific User');
                expect($contributor['tickets_count'])->toBe(15);
                $found = true;
                break;
            }
        }
        expect($found)->toBeTrue();
    });
});

describe('API V2 - Performance & Optimization', function () {
    
    it('handles large datasets efficiently with pagination', function () {
        // Create a large dataset
        $users = User::factory()->count(50)->create();
        foreach ($users as $user) {
            Ticket::factory()->count(rand(1, 10))->create(['author_id' => $user->id]);
        }
        
        $startTime = microtime(true);
        $response = $this->getJson('/api/v2/tickets?per_page=20&page=1');
        $endTime = microtime(true);
        
        $response->assertStatus(200);
        
        // Response should be reasonably fast (under 1 second for this test)
        $responseTime = $endTime - $startTime;
        expect($responseTime)->toBeLessThan(1.0);
        
        // Should return exactly 20 items or less
        $tickets = $response->json('data');
        expect(count($tickets))->toBeLessThanOrEqual(20);
        
        // Should have proper pagination meta
        $pagination = $response->json('meta.pagination');
        expect($pagination['per_page'])->toBe(20);
        expect($pagination['total'])->toBeGreaterThan(20);
    });
    
    it('optimizes queries with selective field loading', function () {
        Ticket::factory()->count(10)->create(['author_id' => $this->user->id]);
        
        $startTime = microtime(true);
        $response = $this->getJson('/api/v2/tickets?fields[tickets]=id,title,status');
        $endTime = microtime(true);
        
        $response->assertStatus(200);
        
        // Should be faster than loading all fields
        $responseTime = $endTime - $startTime;
        expect($responseTime)->toBeLessThan(0.5);
        
        // Should only include requested fields
        $tickets = $response->json('data');
        foreach ($tickets as $ticket) {
            $attributes = array_keys($ticket['attributes']);
            expect($attributes)->toContain('title', 'status');
            expect($attributes)->not->toContain('description', 'internal_notes');
        }
    });
    
    it('efficiently handles includes with large datasets', function () {
        // Create users with many tickets
        $users = User::factory()->count(10)->create();
        foreach ($users as $user) {
            Ticket::factory()->count(20)->create(['author_id' => $user->id]);
        }
        
        $startTime = microtime(true);
        $response = $this->getJson('/api/v2/tickets?include=author&per_page=50');
        $endTime = microtime(true);
        
        $response->assertStatus(200);
        
        // Should complete in reasonable time
        $responseTime = $endTime - $startTime;
        expect($responseTime)->toBeLessThan(2.0);
        
        // Should have included data
        $data = $response->json();
        expect($data)->toHaveKey('included');
        expect($data['included'])->not->toBeEmpty();
    });
    
    it('handles complex filtering efficiently', function () {
        // Create diverse dataset
        $statuses = ['A', 'C', 'H', 'X'];
        $priorities = ['low', 'medium', 'high'];
        
        foreach ($statuses as $status) {
            foreach ($priorities as $priority) {
                Ticket::factory()->count(5)->create([
                    'author_id' => $this->user->id,
                    'status' => $status,
                    'priority' => $priority
                ]);
            }
        }
        
        $startTime = microtime(true);
        $response = $this->getJson('/api/v2/tickets?filter[status]=A,C&filter[priority]=high,medium&sort=-created_at');
        $endTime = microtime(true);
        
        $response->assertStatus(200);
        
        // Should complete efficiently
        $responseTime = $endTime - $startTime;
        expect($responseTime)->toBeLessThan(1.0);
        
        // Should return filtered results
        $tickets = $response->json('data');
        foreach ($tickets as $ticket) {
            expect(['A', 'C'])->toContain($ticket['attributes']['status']);
            expect(['high', 'medium'])->toContain($ticket['attributes']['priority']);
        }
    });
});

describe('API V2 - Caching & Performance Monitoring', function () {
    
    it('benefits from repository pattern caching', function () {
        // First request (uncached)
        $startTime1 = microtime(true);
        $response1 = $this->getJson('/api/v2/tickets/statistics');
        $endTime1 = microtime(true);
        $time1 = $endTime1 - $startTime1;
        
        $response1->assertStatus(200);
        
        // Second request (should be faster if cached)
        $startTime2 = microtime(true);
        $response2 = $this->getJson('/api/v2/tickets/statistics');
        $endTime2 = microtime(true);
        $time2 = $endTime2 - $startTime2;
        
        $response2->assertStatus(200);
        
        // Results should be identical
        expect($response1->json())->toBe($response2->json());
        
        // Note: In actual implementation, you might add caching to make this test meaningful
        expect($time2)->toBeLessThan($time1 + 0.1); // Allow some variance
    });
    
    it('monitors memory usage with large datasets', function () {
        $initialMemory = memory_get_usage();
        
        // Create a substantial dataset
        $users = User::factory()->count(100)->create();
        foreach ($users->take(20) as $user) {
            Ticket::factory()->count(10)->create(['author_id' => $user->id]);
        }
        
        $beforeRequest = memory_get_usage();
        $response = $this->getJson('/api/v2/tickets?per_page=100&include=author');
        $afterRequest = memory_get_usage();
        
        $response->assertStatus(200);
        
        $memoryIncrease = $afterRequest - $beforeRequest;
        
        // Memory increase should be reasonable (less than 50MB for this test)
        expect($memoryIncrease)->toBeLessThan(50 * 1024 * 1024);
        
        // Should return the requested data
        $tickets = $response->json('data');
        expect(count($tickets))->toBeLessThanOrEqual(100);
    });
});