<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipe>
 */
class EquipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Liste personnalisée de suffixes pour vos équipes
        $suffixe = $this->faker->randomElement([
            'MODERNE', 'UNION-SACREE', 'F23', 'WAZALENDO',
            'BALLE DE MATCH', 'ASED', 'NGWASUMA', 'NOUVELLE GENERATION'
        ]);

        $nom = $this->faker->unique()->city() . ' ' . $suffixe;

        return [
            'nom'       => $nom,
            // Génère un sigle à partir des premières lettres du nom et du suffixe
            'sigle'     => strtoupper(substr($nom, 0, 2) . substr($suffixe, 0, 2)),
            // Correction de l'URL du logo (ajout du / et format 100x100)
            'logo'      => 'https://placehold.co' . urlencode($nom),
            'est_actif' => true,
        ];
    }
}
