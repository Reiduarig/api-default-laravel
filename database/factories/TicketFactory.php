<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['A', 'C', 'H', 'X']),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'internal_notes' => fake()->optional(0.3)->sentence(),
            'view_count' => fake()->numberBetween(0, 100)
        ];
    }
    
    /**
     * Configure the model factory.
     */
    public function configure(): static
    { 
        return $this->afterCreating(function ($ticket) {
            // Añadir author_id igual a user_id si no está establecido para mantener compatibilidad
            if (!$ticket->author_id) {
                $ticket->update(['author_id' => $ticket->user_id]);
            }
        });
    }
}
