<?php

namespace Database\Factories;

use App\Models\Equipe;
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
        // On récupère deux IDs d'équipes différentes au hasard
        $equipeA = Equipe::inRandomOrder()->first() ?? Equipe::factory()->create();
        $equipeB = Equipe::where('id', '!=', $equipeA->id)->inRandomOrder()->first() ?? Equipe::factory()->create();

        return [
            'equipe_a_id' => $equipeA->id,
            'equipe_b_id' => $equipeB->id,
            'score_a'     => $this->faker->numberBetween(0, 5),
            'score_b'     => $this->faker->numberBetween(0, 5),
            'joue_le'     => $this->faker->dateTimeBetween('-1 month', 'now'),
            'statut'      => 'termine',
        ];
    }
}
