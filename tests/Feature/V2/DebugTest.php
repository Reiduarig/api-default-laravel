<?php

use App\Models\User;
use App\Models\Ticket;
use Laravel\Sanctum\Sanctum;

it('can debug V2 ticket response structure with includes', function () {
    $user = User::factory()->create();
    Sanctum::actingAs($user);
    
    // Create a single ticket
    $ticket = Ticket::factory()->create([
        'author_id' => $user->id,
        'user_id' => $user->id,
        'priority' => 'high',
        'internal_notes' => 'Test notes',
        'view_count' => 5
    ]);
    
    $response = $this->getJson('/api/v2/tickets?include=author');
    
    $response->assertStatus(200);
    
    // Print the actual response to debug
    dump('Response with includes:', $response->json());
    
    expect($response->status())->toBe(200);
});