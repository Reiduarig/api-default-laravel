<?php

use App\Models\User;
use App\Models\Ticket;
use App\Repositories\V2\TicketRepository;
use App\Repositories\V2\UserRepository;
use App\Actions\V2\CreateTicketAction;
use App\Actions\V2\UpdateTicketAction;
use Illuminate\Foundation\Testing\RefreshDatabase;

describe('Repository Pattern Tests', function () {
    
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->ticketRepository = app(TicketRepository::class);
        $this->userRepository = app(UserRepository::class);
        
        // Create test data
        $this->tickets = Ticket::factory()->count(15)->create([
            'author_id' => $this->user->id,
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'status' => fake()->randomElement(['A', 'C', 'H', 'X'])
        ]);
    });
    
    describe('TicketRepository', function () {
        
        it('can get filtered and paginated tickets', function () {
            $filters = [
                'status' => ['A', 'C'],
                'priority' => ['high', 'medium']
            ];
            
            $result = $this->ticketRepository->getFilteredPaginated($filters, [], 5, 1);
            
            expect($result)->toBeInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class);
            expect($result->perPage())->toBe(5);
            
            foreach ($result->items() as $ticket) {
                expect(['A', 'C'])->toContain($ticket->status);
                expect(['high', 'medium'])->toContain($ticket->priority);
            }
        });
        
        it('can find ticket with relations', function () {
            $ticket = $this->tickets->first();
            
            $result = $this->ticketRepository->findWithRelations($ticket->id, ['author']);
            
            expect($result)->not->toBeNull();
            expect($result->id)->toBe($ticket->id);
            expect($result->relationLoaded('author'))->toBeTrue();
            expect($result->author->id)->toBe($this->user->id);
        });
        
        it('can search tickets by text', function () {
            // Create a ticket with specific title for search
            $searchTicket = Ticket::factory()->create([
                'title' => 'Unique Search Test Ticket',
                'description' => 'Special description for testing',
                'author_id' => $this->user->id
            ]);
            
            $result = $this->ticketRepository->getFilteredPaginated([], [], 10, 1, 'Unique Search');
            
            expect($result->total())->toBeGreaterThan(0);
            
            $found = false;
            foreach ($result->items() as $ticket) {
                if ($ticket->id === $searchTicket->id) {
                    $found = true;
                    break;
                }
            }
            expect($found)->toBeTrue();
        });
        
        it('can apply sorting correctly', function () {
            $result = $this->ticketRepository->getFilteredPaginated([], ['-created_at'], 10, 1);
            
            $tickets = $result->items();
            expect($tickets)->not->toBeEmpty();
            
            // Verify descending order by created_at
            for ($i = 0; $i < count($tickets) - 1; $i++) {
                expect($tickets[$i]->created_at->timestamp)
                    ->toBeGreaterThanOrEqual($tickets[$i + 1]->created_at->timestamp);
            }
        });
        
        it('can filter by date ranges', function () {
            $startDate = now()->subDays(7);
            $endDate = now();
            
            $filters = [
                'created_at' => [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]
            ];
            
            $result = $this->ticketRepository->getFilteredPaginated($filters, [], 10, 1);
            
            foreach ($result->items() as $ticket) {
                expect($ticket->created_at->timestamp)->toBeGreaterThanOrEqual($startDate->timestamp);
                expect($ticket->created_at->timestamp)->toBeLessThanOrEqual($endDate->timestamp);
            }
        });
        
        it('can get ticket statistics', function () {
            $stats = $this->ticketRepository->getStatistics();
            
            expect($stats)->toBeArray();
            expect($stats)->toHaveKeys([
                'total_tickets',
                'status_distribution',
                'priority_distribution',
                'average_view_count'
            ]);
            
            expect($stats['total_tickets'])->toBeGreaterThan(0);
            expect($stats['status_distribution'])->toBeArray();
            expect($stats['priority_distribution'])->toBeArray();
        });
    });
    
    describe('UserRepository', function () {
        
        beforeEach(function () {
            $this->additionalUsers = User::factory()->count(10)->create();
            
            // Create tickets for some users
            foreach ($this->additionalUsers->take(5) as $user) {
                Ticket::factory()->count(rand(1, 5))->create(['author_id' => $user->id]);
            }
        });
        
        it('can get filtered and paginated users', function () {
            $filters = ['name' => 'test'];
            
            $result = $this->userRepository->getFilteredPaginated($filters, [], 5, 1);
            
            expect($result)->toBeInstanceOf(\Illuminate\Contracts\Pagination\LengthAwarePaginator::class);
            expect($result->perPage())->toBe(5);
        });
        
        it('can find user with relations', function () {
            $result = $this->userRepository->findWithRelations($this->user->id, ['tickets']);
            
            expect($result)->not->toBeNull();
            expect($result->id)->toBe($this->user->id);
            expect($result->relationLoaded('tickets'))->toBeTrue();
            expect($result->tickets)->not->toBeEmpty();
        });
        
        it('can search users by text', function () {
            $searchUser = User::factory()->create([
                'name' => 'Unique Search User',
                'email' => 'unique.search@test.com'
            ]);
            
            $result = $this->userRepository->getFilteredPaginated([], [], 10, 1, 'Unique Search');
            
            expect($result->total())->toBeGreaterThan(0);
            
            $found = false;
            foreach ($result->items() as $user) {
                if ($user->id === $searchUser->id) {
                    $found = true;
                    break;
                }
            }
            expect($found)->toBeTrue();
        });
        
        it('can get active users', function () {
            $filters = ['active' => true];
            
            $result = $this->userRepository->getFilteredPaginated($filters, [], 10, 1);
            
            foreach ($result->items() as $user) {
                expect($user->tickets_count)->toBeGreaterThan(0);
            }
        });
        
        it('can get user statistics', function () {
            $stats = $this->userRepository->getStatistics();
            
            expect($stats)->toBeArray();
            expect($stats)->toHaveKeys([
                'total_users',
                'active_users',
                'users_with_tickets',
                'average_tickets_per_user'
            ]);
            
            expect($stats['total_users'])->toBeGreaterThan(0);
            expect($stats['users_with_tickets'])->toBeGreaterThanOrEqual(0);
        });
    });
});

describe('Action Classes Tests', function () {
    
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->createTicketAction = app(CreateTicketAction::class);
        $this->updateTicketAction = app(UpdateTicketAction::class);
    });
    
    describe('CreateTicketAction', function () {
        
        it('can create ticket with all fields', function () {
            $data = [
                'title' => 'Test Ticket from Action',
                'description' => 'This is a test ticket created by Action Class',
                'status' => 'A',
                'priority' => 'high',
                'internal_notes' => 'Internal notes for staff',
                'author_id' => $this->user->id
            ];
            
            $ticket = $this->createTicketAction->execute($data);
            
            expect($ticket)->toBeInstanceOf(Ticket::class);
            expect($ticket->title)->toBe('Test Ticket from Action');
            expect($ticket->description)->toBe('This is a test ticket created by Action Class');
            expect($ticket->status)->toBe('A');
            expect($ticket->priority)->toBe('high');
            expect($ticket->internal_notes)->toBe('Internal notes for staff');
            expect($ticket->author_id)->toBe($this->user->id);
            expect($ticket->view_count)->toBe(0); // Should initialize to 0
            
            // Verify in database
            $this->assertDatabaseHas('tickets', [
                'id' => $ticket->id,
                'title' => 'Test Ticket from Action',
                'priority' => 'high'
            ]);
        });
        
        it('sets default priority when not specified', function () {
            $data = [
                'title' => 'Ticket without Priority',
                'description' => 'Testing default priority',
                'status' => 'A',
                'author_id' => $this->user->id
            ];
            
            $ticket = $this->createTicketAction->execute($data);
            
            expect($ticket->priority)->toBe('medium'); // Should default to medium
        });
        
        it('handles missing optional fields gracefully', function () {
            $data = [
                'title' => 'Minimal Ticket',
                'description' => 'Only required fields',
                'status' => 'A',
                'author_id' => $this->user->id
            ];
            
            $ticket = $this->createTicketAction->execute($data);
            
            expect($ticket)->toBeInstanceOf(Ticket::class);
            expect($ticket->internal_notes)->toBeNull();
            expect($ticket->view_count)->toBe(0);
        });
        
        it('validates required fields', function () {
            $data = [
                'description' => 'Missing title',
                'status' => 'A',
                'author_id' => $this->user->id
            ];
            
            expect(fn() => $this->createTicketAction->execute($data))
                ->toThrow(\Illuminate\Validation\ValidationException::class);
        });
    });
    
    describe('UpdateTicketAction', function () {
        
        beforeEach(function () {
            $this->ticket = Ticket::factory()->create([
                'author_id' => $this->user->id,
                'title' => 'Original Title',
                'priority' => 'low',
                'internal_notes' => 'Original notes'
            ]);
        });
        
        it('can update all ticket fields', function () {
            $data = [
                'title' => 'Updated Title',
                'description' => 'Updated description',
                'status' => 'C',
                'priority' => 'high',
                'internal_notes' => 'Updated internal notes'
            ];
            
            $updatedTicket = $this->updateTicketAction->execute($this->ticket, $data);
            
            expect($updatedTicket->title)->toBe('Updated Title');
            expect($updatedTicket->description)->toBe('Updated description');
            expect($updatedTicket->status)->toBe('C');
            expect($updatedTicket->priority)->toBe('high');
            expect($updatedTicket->internal_notes)->toBe('Updated internal notes');
            
            // Verify in database
            $this->assertDatabaseHas('tickets', [
                'id' => $this->ticket->id,
                'title' => 'Updated Title',
                'priority' => 'high'
            ]);
        });
        
        it('can perform partial updates', function () {
            $originalTitle = $this->ticket->title;
            $originalDescription = $this->ticket->description;
            
            $data = [
                'status' => 'C',
                'priority' => 'high'
            ];
            
            $updatedTicket = $this->updateTicketAction->execute($this->ticket, $data);
            
            expect($updatedTicket->status)->toBe('C');
            expect($updatedTicket->priority)->toBe('high');
            expect($updatedTicket->title)->toBe($originalTitle); // Should remain unchanged
            expect($updatedTicket->description)->toBe($originalDescription); // Should remain unchanged
        });
        
        it('preserves existing values when not updating', function () {
            $data = ['priority' => 'medium'];
            
            $originalViewCount = $this->ticket->view_count;
            $updatedTicket = $this->updateTicketAction->execute($this->ticket, $data);
            
            expect($updatedTicket->priority)->toBe('medium');
            expect($updatedTicket->view_count)->toBe($originalViewCount); // Should not change
        });
        
        it('validates priority values', function () {
            $data = ['priority' => 'invalid_priority'];
            
            expect(fn() => $this->updateTicketAction->execute($this->ticket, $data))
                ->toThrow(\Illuminate\Validation\ValidationException::class);
        });
        
        it('validates status values', function () {
            $data = ['status' => 'INVALID'];
            
            expect(fn() => $this->updateTicketAction->execute($this->ticket, $data))
                ->toThrow(\Illuminate\Validation\ValidationException::class);
        });
    });
    
    describe('Action Classes - Transaction Handling', function () {
        
        it('creates ticket within transaction', function () {
            $initialCount = Ticket::count();
            
            $data = [
                'title' => 'Transaction Test Ticket',
                'description' => 'Testing transaction handling',
                'status' => 'A',
                'author_id' => $this->user->id
            ];
            
            $ticket = $this->createTicketAction->execute($data);
            
            expect(Ticket::count())->toBe($initialCount + 1);
            expect($ticket->exists)->toBeTrue();
        });
        
        it('updates ticket within transaction', function () {
            $ticket = Ticket::factory()->create(['author_id' => $this->user->id]);
            $originalUpdatedAt = $ticket->updated_at;
            
            $data = ['title' => 'Updated in Transaction'];
            
            $this->travel(1)->seconds();
            $updatedTicket = $this->updateTicketAction->execute($ticket, $data);
            
            expect($updatedTicket->title)->toBe('Updated in Transaction');
            expect($updatedTicket->updated_at->timestamp)->toBeGreaterThan($originalUpdatedAt->timestamp);
        });
    });
});