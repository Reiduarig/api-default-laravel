<?php

use App\Models\User;
use App\Models\Ticket;

describe('Tickets Filtering and Search', function () {
    
    describe('Title Filtering', function () {
        it('can filter tickets by title substring', function () {
            $user = $this->authenticateUser();
            
            // Crear tickets con diferentes títulos
            $ticket1 = Ticket::factory()->create(['title' => 'Important dolorum task']);
            $ticket2 = Ticket::factory()->create(['title' => 'Regular task']);
            $ticket3 = Ticket::factory()->create(['title' => 'Another dolorum issue']);

            $response = $this->getJson('/api/v1/tickets?filter[title]=dolorum');

            $response->assertStatus(200);
            
            $titles = collect($response->json('data'))->pluck('attributes.title');
            
            expect($titles)->toContain('Important dolorum task')
                ->and($titles)->toContain('Another dolorum issue')
                ->and($titles)->not->toContain('Regular task');
        });

        it('can filter tickets with wildcard characters', function () {
            $user = $this->authenticateUser();
            
            $ticket1 = Ticket::factory()->create(['title' => 'Bug report']);
            $ticket2 = Ticket::factory()->create(['title' => 'Feature request']);
            $ticket3 = Ticket::factory()->create(['title' => 'Documentation']);

            $response = $this->getJson('/api/v1/tickets?filter[title]=*report*');

            $response->assertStatus(200);
            
            $titles = collect($response->json('data'))->pluck('attributes.title');
            
            expect($titles)->toContain('Bug report');
        });

        it('returns empty results for non-matching title filter', function () {
            $user = $this->authenticateUser();
            
            Ticket::factory()->create(['title' => 'Completely different title']);

            $response = $this->getJson('/api/v1/tickets?filter[title]=nonexistent');

            $response->assertStatus(200);
            expect($response->json('data'))->toBeArray()->toBeEmpty();
        });

        it('is case insensitive', function () {
            $user = $this->authenticateUser();
            
            Ticket::factory()->create(['title' => 'Important TASK']);

            $response = $this->getJson('/api/v1/tickets?filter[title]=important');

            $response->assertStatus(200);
            expect($response->json('data'))->toHaveCount(1);
        });
    });

    describe('Status Filtering', function () {
        it('can filter tickets by single status', function () {
            $user = $this->authenticateUser();
            
            Ticket::factory()->create(['status' => 'A']); // Activo
            Ticket::factory()->create(['status' => 'C']); // Completado
            Ticket::factory()->create(['status' => 'H']); // En espera

            $response = $this->getJson('/api/v1/tickets?filter[status]=A');

            $response->assertStatus(200);
            
            $statuses = collect($response->json('data'))->pluck('attributes.status')->unique();
            
            expect($statuses)->toHaveCount(1)
                ->and($statuses->first())->toBe('A');
        });

        it('can filter tickets by multiple statuses', function () {
            $user = $this->authenticateUser();
            
            Ticket::factory()->create(['status' => 'A']);
            Ticket::factory()->create(['status' => 'C']);
            Ticket::factory()->create(['status' => 'H']);
            Ticket::factory()->create(['status' => 'X']);

            $response = $this->getJson('/api/v1/tickets?filter[status]=A,C');

            $response->assertStatus(200);
            
            $statuses = collect($response->json('data'))->pluck('attributes.status')->unique()->sort()->values();
            
            expect($statuses)->toEqual(['A', 'C']);
        });
    });

    describe('Date Filtering', function () {
        it('can filter tickets by specific date', function () {
            $user = $this->authenticateUser();
            
            $targetDate = '2025-10-27';
            
            Ticket::factory()->create([
                'created_at' => $targetDate . ' 10:00:00'
            ]);
            Ticket::factory()->create([
                'created_at' => '2025-10-26 10:00:00'
            ]);

            $response = $this->getJson("/api/v1/tickets?filter[created_at]={$targetDate}");

            $response->assertStatus(200);
            expect($response->json('data'))->toHaveCount(1);
        });

        it('can filter tickets by date range', function () {
            $user = $this->authenticateUser();
            
            Ticket::factory()->create(['created_at' => '2025-10-25 10:00:00']); // Antes del rango
            Ticket::factory()->create(['created_at' => '2025-10-27 10:00:00']); // Dentro del rango
            Ticket::factory()->create(['created_at' => '2025-10-28 10:00:00']); // Dentro del rango
            Ticket::factory()->create(['created_at' => '2025-10-30 10:00:00']); // Después del rango

            $response = $this->getJson('/api/v1/tickets?filter[created_at]=2025-10-26,2025-10-29');

            $response->assertStatus(200);
            expect($response->json('data'))->toHaveCount(2);
        });
    });

    describe('Author Filtering', function () {
        it('can filter tickets by author id', function () {
            $user = $this->authenticateUser();
            $author1 = User::factory()->create();
            $author2 = User::factory()->create();
            
            Ticket::factory()->create(['user_id' => $author1->id]);
            Ticket::factory()->create(['user_id' => $author1->id]);
            Ticket::factory()->create(['user_id' => $author2->id]);

            $response = $this->getJson("/api/v1/tickets?filter[author]={$author1->id}");

            $response->assertStatus(200);
            
            $authorIds = collect($response->json('data'))
                ->pluck('relationships.author.data.id')
                ->unique();
            
            expect($authorIds)->toHaveCount(1)
                ->and($authorIds->first())->toBe((string) $author1->id);
        });
    });

    describe('Combined Filtering', function () {
        it('can apply multiple filters simultaneously', function () {
            $user = $this->authenticateUser();
            $author = User::factory()->create();
            
            // Ticket que coincide con todos los filtros
            $matchingTicket = Ticket::factory()->create([
                'title' => 'Important task',
                'status' => 'A',
                'user_id' => $author->id,
                'created_at' => '2025-10-27 10:00:00'
            ]);
            
            // Tickets que no coinciden
            Ticket::factory()->create(['title' => 'Other task', 'status' => 'A', 'user_id' => $author->id]);
            Ticket::factory()->create(['title' => 'Important task', 'status' => 'C', 'user_id' => $author->id]);

            $response = $this->getJson("/api/v1/tickets?filter[title]=Important&filter[status]=A&filter[author]={$author->id}");

            $response->assertStatus(200);
            expect($response->json('data'))->toHaveCount(1);
            
            $ticket = $response->json('data.0');
            expect($ticket['attributes']['title'])->toBe('Important task');
            expect($ticket['attributes']['status'])->toBe('A');
            expect($ticket['relationships']['author']['data']['id'])->toBe((string) $author->id);
        });
    });

    describe('Sorting', function () {
        it('can sort tickets by title ascending', function () {
            $user = $this->authenticateUser();
            
            Ticket::factory()->create(['title' => 'Zebra task']);
            Ticket::factory()->create(['title' => 'Alpha task']);
            Ticket::factory()->create(['title' => 'Beta task']);

            $response = $this->getJson('/api/v1/tickets?sort=title');

            $response->assertStatus(200);
            
            $titles = collect($response->json('data'))->pluck('attributes.title');
            
            expect($titles->toArray())->toBe(['Alpha task', 'Beta task', 'Zebra task']);
        });

        it('can sort tickets by title descending', function () {
            $user = $this->authenticateUser();
            
            Ticket::factory()->create(['title' => 'Alpha task']);
            Ticket::factory()->create(['title' => 'Zebra task']);
            Ticket::factory()->create(['title' => 'Beta task']);

            $response = $this->getJson('/api/v1/tickets?sort=-title');

            $response->assertStatus(200);
            
            $titles = collect($response->json('data'))->pluck('attributes.title');
            
            expect($titles->toArray())->toBe(['Zebra task', 'Beta task', 'Alpha task']);
        });

        it('can sort tickets by created_at descending', function () {
            $user = $this->authenticateUser();
            
            $ticket1 = Ticket::factory()->create(['created_at' => '2025-10-25 10:00:00']);
            $ticket2 = Ticket::factory()->create(['created_at' => '2025-10-27 10:00:00']);
            $ticket3 = Ticket::factory()->create(['created_at' => '2025-10-26 10:00:00']);

            $response = $this->getJson('/api/v1/tickets?sort=-created_at');

            $response->assertStatus(200);
            
            $createdDates = collect($response->json('data'))->pluck('attributes.created_at');
            
            // Verificar que están ordenados de más reciente a más antiguo
            expect($createdDates[0])->toContain('2025-10-27');
            expect($createdDates[1])->toContain('2025-10-26');
            expect($createdDates[2])->toContain('2025-10-25');
        });
    });

    describe('Combined Filtering and Sorting', function () {
        it('can filter and sort simultaneously', function () {
            $user = $this->authenticateUser();
            
            // Crear tickets con estado A
            Ticket::factory()->create(['title' => 'Zebra active task', 'status' => 'A']);
            Ticket::factory()->create(['title' => 'Alpha active task', 'status' => 'A']);
            
            // Ticket con estado diferente (no debería aparecer)
            Ticket::factory()->create(['title' => 'Beta completed task', 'status' => 'C']);

            $response = $this->getJson('/api/v1/tickets?filter[status]=A&sort=title');

            $response->assertStatus(200);
            
            $data = $response->json('data');
            expect($data)->toHaveCount(2);
            
            $titles = collect($data)->pluck('attributes.title');
            expect($titles->toArray())->toBe(['Alpha active task', 'Zebra active task']);
            
            $statuses = collect($data)->pluck('attributes.status')->unique();
            expect($statuses)->toHaveCount(1)->and($statuses->first())->toBe('A');
        });
    });
});