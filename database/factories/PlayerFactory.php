<?php

namespace Database\Factories;

use App\Models\Equipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'equipe_id'     => Equipe::factory(), // Crée une équipe si non spécifiée
            'name'          => strtoupper($this->faker->lastName()) . ' ' . $this->faker->firstName('male'),
            'goals'         => $this->faker->numberBetween(0, 15),

            // Identification
            'photo'         => 'https://i.pravatar.cc' . $this->faker->uuid(),
            'birth_place'   => $this->faker->city(),
            'birth_date'    => $this->faker->dateTimeBetween('-55 years', '-35 years'), // Vétérans
            'nationality'   => 'Congolaise',
            'profession'    => $this->faker->randomElement([
                'Avocat', 'Médecin', 'Commerçant', 'Ingénieur IT',
                'Entrepreneur', 'Cadre Bancaire', 'Enseignant', 'Journaliste'
            ]),
            'phone'         => '+243 ' . $this->faker->numerify('#########'),

            // Sportif
            'position'      => $this->faker->randomElement(['Gardien', 'Défenseur', 'Milieu', 'Attaquant']),
            'foot'          => $this->faker->randomElement(['Droitier', 'Gaucher', 'Ambidextre']),
            'jersey_number' => $this->faker->numberBetween(1, 99),
            'level'         => $this->faker->randomElement(['Ancien Pro', 'Amateur confirmé', 'Vétéran']),
            'is_fit'        => $this->faker->boolean(80), // 80% de chance d'être apte

            'join_year'     => $this->faker->year(),
        ];
    }
}
