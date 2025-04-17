<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Interaction;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interaction>
 */
class InteractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'interactable_id' => \App\Models\Movie::factory(),
            'interactable_type' => \App\Models\Movie::class,
            'type' => $this->faker->randomElement(['favorite', 'follow']),
        ];
    }
}
