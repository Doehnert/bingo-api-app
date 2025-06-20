<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_active' => false,
            'called_numbers' => collect(range(1, 100))->shuffle()->take(40)->toArray(),
            'winner' => User::factory(),
            'winner_score' => $this->faker->numberBetween(1, 100),
        ];
    }
}
